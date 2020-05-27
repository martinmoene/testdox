TestDox: create simple documentation from test case names
---------------------------------------------------------

```Python
#!/usr/bin/env python
#
# testdox.py (Python 2.6, 3.0)
#
# Generate a readable overview of test case names from the specified files.
#
# Inspired on TestDox by Chris Stevenson, see
# http://skizz.biz/blog/2003/06/17/testdox-release-01/
#
# Author: Martin Moene, http://www.eld.leidenuniv.nl/~moene/
#
# This tool is provided under the Boost license.  Please read
# http://www.boost.org/users/license.html for the original text.
#
# $Id: testdox.py 235 2010-09-05 20:43:26Z moene $
#

#
# See also Kodos - The Python Regex Debugger, http://kodos.sourceforge.net/.
#

"""Create test documentation from testsuite files based on testdox format.

See also: http://blog.dannorth.net/introducing-bdd/
"""

from __future__ import print_function

__version_info__ = ( 0, 1, 4, 'alpha', 0 )
__version_date__ = '$Date: 2010-09-05 22:43:26 +0200 (Sun, 05 Sep 2010) $'
__version__      = '$Revision: 235 $'
__author__       = 'Martin Moene <m.j.moene@eld.physics.LeidenUniv.nl>'
__url__          = 'http://www.eld.leidenuniv.nl/~moene/Home/projects/testdox/'

import doctest
import glob
import os
import re
import string
import sys

from optparse import OptionParser, OptionGroup


def versionString():
   """Version string such as '1.2.3'"""
   return '.'.join(map(str, __version_info__[0:3]))


def versionState():
   """Version state such as 'alpha', 'beta', 'final'"""
   return __version_info__[3]


def versionDate():
   """Version date such as 'Thu, 10 Jun 2010'"""
   return __version_date__[34:-3]


class Context:
   """Processing context."""
   def __init__( self, title=None, htmlbodyonly=None ):
      self.title = title
      self.htmlbodyonly = htmlbodyonly

   def wrapup( self ):
      pass


class Scanner:
   """Base class for unit test scanners."""
   tokenEof = 0
   tokenEnterSuite = 1
   tokenLeaveSuite = 2
   tokenTestCase = 3


class CppUnitKindScanner( Scanner ):
   """Scanner for CppUnit-like C++ unit tests.
   """
   def __init__( self, f, re_framework, re_testcase, re_beginsuite, re_endsuite ):
      """Construct from file."""
      self.f = f
      self.mo_framework  = re.compile( re_framework )
      self.mo_testcase   = re.compile( re_testcase )
      self.mo_beginsuite = re.compile( re_beginsuite )
      self.mo_endsuite   = re.compile( re_endsuite )

   def tokens( self ):
      """Return tokens with testsuite and testcase names found as (token, name)
      tuple.
      """
      for line in self.f.readlines():

         # ignore lines that do not contain framework instructions:
         if not self.mo_framework.search( line ):
            continue;

#         print( line, end='' )

         # check for a fixture, or auto test case (most likely case first):
         mo = self.mo_testcase.search( line )
         if mo:
            (yield (self.tokenTestCase, mo.group('name') ) )

         # check for a new test suite level:
         mo = self.mo_beginsuite.search( line )
         if mo:
            (yield (self.tokenEnterSuite, mo.group('name') ) )

         # check for the end of a test suite level:
         mo = self.mo_endsuite.search( line )
         if mo:
            (yield (self.tokenLeaveSuite, None ) )


class CppUnitScanner( CppUnitKindScanner ):
   """Scanner for CppUnit C++ unit tests.

   URL: http://cppunit.sourceforge.net/

   CPPUNIT_TEST_SUITE (suite_name)
   CPPUNIT_TEST_SUITE_END ()
   CPPUNIT_TEST (test_case_name)

   xxx with open( 'test.txt', 'r' ) as f:
   ...   scanner = CppBoostTestScanner( f )
   """
   def __init__( self, f ):
      """Construct from file."""
      CppUnitKindScanner.__init__( self, f,
          re_framework=r'CPPUNIT_',
           re_testcase=r'CPPUNIT_TEST\s*\(\s*(?P<name>\w+)',
         re_beginsuite=r'CPPUNIT_TEST_SUITE\s*\(\s*(?P<name>\w+)',
           re_endsuite=r'CPPUNIT_TEST_SUITE_END' )


class CppBoostTestScanner( CppUnitKindScanner ):
   """Scanner for Boost.Test C++ unit tests.

   URL: http://www.boost.org/doc/libs/release/libs/test/

   BOOST_AUTO_TEST_SUITE( suite_name )
   BOOST_AUTO_TEST_SUITE_END()
   BOOST_AUTO_TEST_CASE( test_case_name )
   BOOST_AUTO_TEST_CASE_TEMPLATE( test_case_name, formal_type_parameter_name, collection_of_types )
   BOOST_TEST_CASE( test_case_name )
   BOOST_TEST_CASE_TEMPLATE( test_case_name, collection_of_types )
   BOOST_TEST_CASE_TEMPLATE_FUNCTION( test_case_name, type_name)
   BOOST_FIXTURE_TEST_CASE( test_case_name, fixture_name )

   xxx with open( 'test.txt', 'r' ) as f:
   ...   scanner = CppBoostTestScanner( f )
   """
   def __init__( self, f ):
      """Construct from file."""
      CppUnitKindScanner.__init__( self, f,
          re_framework=r'BOOST_',
           re_testcase=r'TEST_CASE(_TEMPLATE(_FUNCTION)?)?\s*\(\s*(?P<name>\w+)',
#           re_testcase=r'(BOOST_TEST_CASE_TEMPLATE(_FUNCTION)?|BOOST_FIXTURE_TEST_CASE|BOOST(_AUTO)?_TEST_CASE)\s*\(\s*(?P<name>\w+)',
         re_beginsuite=r'BOOST_AUTO_TEST_SUITE\s*\(\s*(?P<name>\w+)',
           re_endsuite=r'BOOST_AUTO_TEST_SUITE_END' )


class CppGoogleTestScanner( Scanner ):
   """Scanner for Google Test C++ unit tests.

   URL: http://code.google.com/p/googletest/

   TEST(test_case_name, test_name), e.g. TEST(FactorialTest, HandlesZeroInput),
   TEST_F(test_case_name, test_name), e.g. TEST_F(QueueTest, IsEmptyInitially).
   """
   pass

class Parser:
   """Parser for testsuites. This one works with Boost.Test testsuite,
   testcase hierarchy, for example:

   BOOST_AUTO_TEST_SUITE( Suite1 )
   BOOST_AUTO_TEST_SUITE( SubSuite1 )
   BOOST_AUTO_TEST_CASE( testThatThingHasBehaviour )
   BOOST_FIXTURE_TEST_CASE( testThatThingHasOtherBehaviour, Fixture )
   BOOST_AUTO_TEST_SUITE_END() // SubSuite1
   BOOST_AUTO_TEST_SUITE( SubSuite2 )
   BOOST_AUTO_TEST_SUITE_END() // SubSuite2
   BOOST_AUTO_TEST_SUITE_END() // Suite1

   Usage:
      Scanner scanner( file );
      Builder builder();
      Context context()
      Parser  parser( scanner, builder, context );
      parser.parse();
   """
   def __init__( self, scanner, builder, context ):
      """Construct from scanner, builder and context."""
      self.scanner = scanner
      self.builder = builder
      self.context = context

   def parse( self ):
      """Constructor."""
      s_entering_suite = 1
      s_scanning_cases = 2
      s_leaving_suite = 3
      state = s_entering_suite

      for (token, name) in self.scanner.tokens():
#         print ( 'token:{t} name:{n}'.format(t=token, n=name) )

         while True:
            if state == s_entering_suite:
               if token == Scanner.tokenEnterSuite:
                  self.builder.enterSuite( name )
                  break;
               else:
                  state = s_scanning_cases

            elif state == s_scanning_cases:
               if token == Scanner.tokenTestCase:
                  self.builder.addTestCase( name )
                  break;
               else:
                  state = s_leaving_suite

            elif state == s_leaving_suite:
               if token == Scanner.tokenLeaveSuite:
                  self.builder.leaveSuite( name )
                  break;
               else:
                  state = s_entering_suite


class Builder:
   """Base class for output generators."""
   def __init__( self, f, context=Context() ):
      """Constructor."""
      self.f = f
      self.context = context
      self.caseCount = 0
      self.suiteCount = 0
      self.suites = []
      self.writeLeader()

   def __del__( self ):
      """Destructor."""
      self.writeTrailer()

   def writeLeader( self ):
      """Write the report's leader."""
      pass

   def writeTrailer( self ):
      """Write the report's trailer."""
      pass

   def writeSuiteName( self ):
      """Write the collected suite name."""
      pass

   def writeTestCaseName( self, text ):
      """Write the given test case name."""
      pass

   def enterSuite( self, name ):
      """Enter a new test suite level."""
      self.caseCount = 0
      self.suiteCount += 1
      self.suites.append( name )

   def leaveSuite( self, name=None ):
      """Leave a test suite level."""
      self.suites = self.suites[:-1]

   def testSuiteLevel( self ):
      """"Level of test suite: outermost is 1."""
      return len( self.suites )

   def testSuiteCount( self ):
      """"Number of test suite so far."""
      return self.suiteCount

   def testCaseCount( self ):
      """"Number of test cases in (sub)suite so far."""
      return self.caseCount

   def addTestCase( self, name ):
      """Add a test case name. If it's the first of a suite, first write
      suite name terminated with newline.
      """
      self.caseCount += 1
      if self.caseCount == 1:
         self.writeSuiteName()
      self.writeTestCaseName( name )

   def formatTitle( self ):
      """Return title as is."""
      return self.context.title

   def formatTestSuiteName( self ):
      """Return suite name as Suite.Subsuite."""
      count = 0
      result = ''
      for name in self.suites:
         count += 1
         result += '{dot}{name}'.format(name=name, dot=(count > 1 and '.' or '') )
      return result

   def formatTestCaseName( self, testCaseName ):
      """Return '[prefix_]testThatThingShowsBehaviour' as 'thing shows behaviour'.

      >>> builder = Builder( sys.stdout )
      >>> builder.formatTestCaseName( 'testThingShowsBehaviour' )
      'Thing shows behaviour.'
      >>> builder.formatTestCaseName( 'testThatThingShowsBehaviour' )
      'Thing shows behaviour.'
      >>> builder.formatTestCaseName( 'myPrefix_testThatThingShowsBehaviour' )
      'myPrefix: Thing shows behaviour.'
      """
      match_obj = re.search( r'(?P<prefix>\w*?)[tT]est(That)?(?P<name>\w+)', testCaseName )
      name = match_obj.group('name')
      prefix = match_obj.group('prefix').rstrip('_')
      if len(prefix):
         fmt = '{prefix}: {name}.'
      else:
         fmt = '{name}.'
      return fmt.format( name=self.splitCamelCaseWord( name ), prefix=prefix )

   def splitCamelCaseWord( self, text ):
      """Return text 'ThingShowsBehaviour' as 'Thing shows behaviour'.

      >>> builder = Builder( sys.stdout )
      >>> builder.splitCamelCaseWord( 'thingShowsBehaviour' )
      'Thing shows behaviour'
      """
      return re.sub( r'([A-Z]|\d+)', r' \1',text  ).lstrip().capitalize()


class PlainTextWriter( Builder ):
   """Output presented (sub)suites and testcases as plain text in the following
   format:

   Suite1.Subsuite1
   - thing has behaviour
   - thing has other behaviour

   Suite1.Subsuite2
   - thing has behaviour

   Tests:
   ------
   >>> builder = PlainTextWriter( sys.stdout, Context( title='My Title' ) )
   My Title
   >>> builder.enterSuite( 'Suite' )
   >>> builder.enterSuite( 'Subsuite' )
   >>> builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )
   <BLANKLINE>
   Suite.Subsuite
   - Add test case behaves as expected.
   >>> builder.leaveSuite()
   >>> builder.enterSuite( 'OtherSubsuite' )
   >>> builder.addTestCase( 'testThatThingShowsBehaviour' )
   <BLANKLINE>
   Suite.OtherSubsuite
   - Thing shows behaviour.
   >>> builder.leaveSuite()
   """
   def __init__( self, f, context=Context()  ):
      """Constructor."""
      Builder.__init__( self, f, context )

   def enterSuite( self, name ):
      """Enter a new test suite level.
      Allow for doctest code.
      """
      Builder.enterSuite( self, name )

   def leaveSuite( self, name=None ):
      """Leave a test suite level.
      Allow for doctest code."""
      Builder.leaveSuite( self, name )

   def addTestCase( self, name ):
      """Add a test case name. If it's the first of a suite, first write
      suite name terminated with newline.

      >>> builder = PlainTextWriter( sys.stdout )
      >>> builder.enterSuite( 'Suite' )
      >>> builder.enterSuite( 'Subsuite' )
      >>> builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )
      <BLANKLINE>
      Suite.Subsuite
      - Add test case behaves as expected.
      """
      Builder.addTestCase( self, name )

   def writeLeader( self ):
      """Print the report's leader: title."""
      title = self.formatTitle()
      if title:
         print( '{title}'.format( title=title ), file=self.f )

   def writeTrailer( self ):
      """Print the report's trailer: none."""
      pass

   def writeSuiteName( self ):
      """Print newline followed by hierarchical suite name.

      >>> builder = PlainTextWriter( sys.stdout )
      >>> builder.enterSuite( 'Suite' )
      >>> builder.enterSuite( 'Subsuite' )
      >>> builder.writeSuiteName()
      <BLANKLINE>
      Suite.Subsuite
      """
      print( '\n{name}'.format( name=self.formatTestSuiteName() ), file=self.f )

   def writeTestCaseName( self, text ):
      """Print testThatThingShowsBehaviour as '- thing shows behaviour'

      >>> builder = PlainTextWriter( sys.stdout )
      >>> builder.writeTestCaseName( 'testThatThingShowsBehaviour' )
      - Thing shows behaviour.
      """
      print( '- {text}'.format( text=self.formatTestCaseName(text) ), file=self.f )



class SimpleHtmlWriter( Builder ):
   """Output results as HTML.

   Tests:
   ------
   >>> builder = SimpleHtmlWriter( sys.stdout, Context( title='My Title' ) )
   <html>
   <head>
   <title>My Title</title>
   </head>
   <body>
   <h1 class="tdx_title">My Title</h1>
   >>> builder.enterSuite( 'Suite' )
   >>> builder.enterSuite( 'Subsuite' )
   >>> builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )
   </ul>
   <h2 class="tdx_testsuite">Suite.Subsuite</h2><ul class="tdx_testcase">
   <li>Add test case behaves as expected.</li>
   >>> del builder
   </ul>
   </body>
   </html>
   """
   css_title_class = 'tdx_title'
   css_testsuite_class = 'tdx_testsuite'
   css_testcase_class = 'tdx_testcase'

   def __init__( self, f, context=Context() ):
      """Constructor."""
      Builder.__init__( self, f, context )

   def __del__( self ):
      """Destructor."""
      Builder.__del__( self )

   def enterSuite( self, name ):
      """Enter a new test suite level.
      Allow for doctest code.
      """
      Builder.enterSuite( self, name )

   def leaveSuite( self, name=None ):
      """Leave a test suite level.
      Allow for doctest code."""
      Builder.leaveSuite( self, name )

   def addTestCase( self, name ):
      """Add a test case name. If it's the first of a suite, first print
      suite name terminated with newline.
      """
      Builder.addTestCase( self, name )

   def writeLeader( self ):
      """Print the report's leader: HTML structure with title.
      """
      if not self.context.htmlbodyonly:
         title = self.formatTitle()
         print( '<html>\n<head>', file=self.f )
         if title:
            print( '<title>{title}</title>'.format( title=title ), file=self.f )
         print( '</head>\n<body>', file=self.f )
         if title:
            print( '<h1 class="{css_title}">{title}</h1>'.format(
               css_title=SimpleHtmlWriter.css_title_class, title=title ), file=self.f )

   def writeTrailer( self ):
      """Print the report's trailer: finish HTML document.
      """
      if self.testSuiteCount() > 0:
         print( '</ul>', file=self.f )
      if not self.context.htmlbodyonly:
         print( '</body>\n</html>', file=self.f )

   def writeSuiteName( self ):
      """Print newline followed by hierarchical suite name.
      """
      if self.testSuiteCount() > 1:
         print( '</ul>', file=self.f )
      print( '<h2 class="{css_suite}">{suite_name}</h2><ul class="{css_testcase}">'.format(
         css_suite=SimpleHtmlWriter.css_testsuite_class,
         css_testcase=SimpleHtmlWriter.css_testcase_class,
         suite_name=self.formatTestSuiteName() ), file=self.f )

   def writeTestCaseName( self, text ):
      """Print testThatThingShowsBehaviour as '- thing shows behaviour'
      """
      print( '<li>{text}</li>'.format( text=self.formatTestCaseName(text) ), file=self.f )


def processFileByPath( path, ScannerType, builder, context ):
   """Open file given by path and create scanner on the file, parse the file and build the output."""
   with open( path, 'r' ) as f:
      scanner = ScannerType( f )
      parser = Parser( scanner, builder, context )
      parser.parse()


def main():
   """Handle options and process given files.
   """
   global progname
   progname = os.path.basename( sys.argv[0] )

   parser = OptionParser(
      usage="Usage: %prog [options] [directory | file...]",
      version="%prog  {ver} {state}  ({date})".format( ver=versionString(), state=versionState(), date=versionDate() ),
      description=__doc__  )

   parser.add_option(   "-d"   , "--debug"    ,  action="store_true" , dest="debug"    , help="show debug messages" )
   parser.add_option(   "-v"   , "--verbose"  ,  action="store_true" , dest="verbose"  , help="show more messages" )
   parser.add_option(   "-q"   , "--quiet"    ,  action="store_true" , dest="quiet"    , help="show less messages" )
#   parser.add_option(           "--logging"  , metavar="LEVEL"      , dest="logging"  , default="warning", help="logging level: debug,info,error,critical [warning]" )
   parser.add_option(   "-t"   , "--selftest" ,  action="store_true" , dest="selftest" , help="perform selftest; can also use option -v" )

   parser.add_option(         "--title"       , metavar="title"      , dest="title"    , help="specify title for report [none]" )
   parser.add_option(         "--framework"   , metavar="fw"         , dest="framework", help="select test framework: Boost.Test, CppUnit [Boost.Test]" )
   parser.add_option(         "--format"      , metavar="format"     , dest="format"   , help="select output format: html, text [text]" )
   parser.add_option(         "--glob"        , metavar="pattern"    , dest="glob"     , default="*.cpp|*.h", help="filename pattern to use with directories [*.cpp|*.h]" )
   parser.add_option(         "--depth"       , metavar="n"          , dest="depth", type='int', help="directory recursion depth, norecurse is 1 [recurse]" )
   parser.add_option(         "--norecurse"   ,  action="store_const", dest="depth", const=1   , help="prevent visiting subdirectories [no]" )
   parser.add_option(         "--htmlbodyonly",  action="store_true" , dest="htmlbodyonly"     , help="only generate contents of body tag fragment [no]" )

   (options, args) = parser.parse_args()

   if options.selftest:
      exit( doctest.testmod( verbose=options.verbose ) )

   if options.depth <> None and options.depth < 1:
      parser.error( "expecting 1 or higher for option --depth, got '{depth}'; try option --help".format( depth=options.depth) )

   if options.htmlbodyonly:
       options.format = 'html'

   if len( args ) < 1:
      parser.error( "expecting testsuite filename; try option --help" )

   if options.verbose:
      pass

   try:
      maxdepth = 0
      dircount = 0
      filecount = 0

      # select scanner for test framework:
      if options.framework:
         if options.framework == 'Boost.Test':
            ScannerType = CppBoostTestScanner
         elif options.framework == 'CppUnit':
            ScannerType = CppUnitScanner
         elif options.framework == 'GoogleTest':
            ScannerType = CppGoogleTestScanner
         else:
            parser.error( "invalid framework '{fw}' for option --framework, expecting 'Boost.Test', CppUnit, or GoogleTest; try option --help".format( fw=options.framework) )
      else:
         ScannerType = CppBoostTestScanner

      # select output format:
      if options.format:
         if options.format == 'html':
            BuilderType = SimpleHtmlWriter
         elif options.format == 'text':
            BuilderType = PlainTextWriter
         else:
            parser.error( "invalid format '{fmt}' for option --format, expecting 'html' or 'text'; try option --help".format( fmt=options.format) )
      else:
         BuilderType = PlainTextWriter

      context = Context( title=options.title, htmlbodyonly=options.htmlbodyonly )
      builder = BuilderType( sys.stdout, context )

      for arg in args:
         # directory:
         if os.path.isdir( arg ):
            argroot = arg
            for dirpath, dirs, files in os.walk( argroot ):
               recdepth = computeSubDirectoryDistance( argroot, dirpath )
               maxdepth = max( maxdepth, recdepth )
#               print( 'depth:{d} top:{ar} dirpath:{dp}'.format( d=recdepth, ar=argroot, dp=dirpath) )
               # handle --depth=n:
               if options.depth and recdepth > options.depth:
                  continue
               if options.debug:
                  message( 'at recursion depth:{d}'.format(d=recdepth) )
               dircount += 1
               for pattern in options.glob.split('|'):
                  for path in glob.glob( os.path.join(dirpath, pattern ) ):
                     if options.verbose:
                        message( '{path}:'.format( path=path ) )
                     processFileByPath( path, ScannerType, builder, context )
                     filecount += 1
               # --norecurse (--depth=1):
               if options.depth and options.depth <= 1:
                  break

         # filename or wildcard:
         else:
            dircount += 1  # filter out duplicate dirs from args ?
            for path in glob.glob( arg ):
               if not os.path.isfile( path ):
                  continue
               if options.verbose:
                  message( '{path}:'.format( path=path ) )
               processFileByPath( path, ScannerType, builder, context )
               filecount += 1

      # make sure trailer is written now:
      # replace with builder.finish(), terminate(), ... ?
      del builder

      if not options.quiet:
         if filecount <= 0:
            message( "no files matched the given file specification(s)." )
         else:
            message( "processed {dcount} {dirs}, {fcount} {files}.".format(
               dcount=dircount, dirs=makePlural('directory', dircount),
               fcount=filecount, files=makePlural('file', filecount) ) )

   except IOError as detail:
      message( "cannot process file '{filename}', {strerror}".format(
                                      filename=path, strerror=detail ) )
      return 2
   except Exception as detail:
      message( '{0}'.format( detail ) )
      return 2
   finally:
      pass

   return 0


def computeSubDirectoryDistance( fromdir, todir ):
   """Compute the subdirectory level of subdir with respect to topdir."""
   return 1 + string.count( todir, os.sep ) - string.count( fromdir, os.sep )


def makePlural( text, count ):
   """Return text's pural if appropriate: directory (directories), file (files)."""
   if count == 1:
      return text
   else:
      if 'y' == text[-1]:
         return text[:-1] + 'ies'
      else:
         return text + 's'


def message( msg ):
   """Issue message."""
   print( '{prog}: {msg}'.format( prog=progname, msg=msg) )

# ---------------------------------------------------------------------------

if __name__ == "__main__":
   main()

#
# end of file
#
```
