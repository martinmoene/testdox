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
# $Id$
#

"""Create test documentation from testsuite files based on testdox format.

See also: http://blog.dannorth.net/introducing-bdd/
"""

from __future__ import print_function

__version_info__ = ( 0, 1, 1, 'alpha', 0 )
__version_date__ = '$Date$'
__version__      = '$Revision$'
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
   pass


class Scanner:
   """Base class for unit test scanners."""
   tokenEof = 0
   tokenEnterSuite = 1
   tokenLeaveSuite = 2
   tokenTestCase = 3


class CppUnitScanner( Scanner ):
   """Scanner for CppUnit C++ unit tests.
   See also Kodos - The Python Regex Debugger, http://kodos.sourceforge.net/.

   CPPUNIT_TEST_SUITE (suitename)
   CPPUNIT_TEST_SUITE_END ()
   CPPUNIT_TEST (testcasename)

   xxx with open( 'test.txt', 'r' ) as f:
   ...   scanner = CppBoostTestScanner( f )
   """
   def __init__( self, f ):
      """Construct from file."""
      self.f = f

   def tokens( self ):
      """Return tokens with testsuite and testcase names found as (token, name)
      tuple.
      """
      for line in self.f.readlines():

         # ignore lines that do not contain CPPUNIT_:
         if not re.search( r'CPPUNIT_', line ):
            continue;

#         print( line, end='' )

         # check for a fixture, or auto test case (most likely case first):
         mo = re.search( r'CPPUNIT_TEST\s*\(\s*(?P<name>\w+)', line )
         if mo:
            (yield (self.tokenTestCase, mo.group('name') ) )

         # check for a new test suite level:
         mo = re.search( r'CPPUNIT_TEST_SUITE\s*\(\s*(?P<name>\w+)', line )
         if mo:
            (yield (self.tokenEnterSuite, mo.group('name') ) )

         # check for the end of a test suite level:
         mo = re.search( r'CPPUNIT_TEST_SUITE_END', line )
         if mo:
            (yield (self.tokenLeaveSuite, None ) )


class CppBoostTestScanner( Scanner ):
   """Scanner for Boost.Test C++ unit tests.
   See also Kodos - The Python Regex Debugger, http://kodos.sourceforge.net/.

   BOOST_AUTO_TEST_SUITE( suitename )
   BOOST_AUTO_TEST_SUITE_END()
   BOOST_AUTO_TEST_CASE( testcasename )
   BOOST_FIXTURE_TEST_CASE( testcasename, fixturename )

   xxx with open( 'test.txt', 'r' ) as f:
   ...   scanner = CppBoostTestScanner( f )
   """
   def __init__( self, f ):
      """Construct from file."""
      self.f = f

   def tokens( self ):
      """Return tokens with testsuite and testcase names found as (token, name)
      tuple.
      """
      for line in self.f.readlines():

         # ignore lines that do not contain BOOST_:
         if not re.search( r'BOOST_', line ):
            continue;

#         print( line, end='' )

         # check for a fixture, or auto test case (most likely case first):
         mo = re.search( r'(BOOST_FIXTURE_TEST_CASE|BOOST_AUTO_TEST_CASE)\s*\(\s*(?P<name>\w+)', line )
         if mo:
            (yield (self.tokenTestCase, mo.group('name') ) )

         # check for a new test suite level:
         mo = re.search( r'BOOST_AUTO_TEST_SUITE\s*\(\s*(?P<name>\w+)', line )
         if mo:
            (yield (self.tokenEnterSuite, mo.group('name') ) )

         # check for the end of a test suite level:
         mo = re.search( r'BOOST_AUTO_TEST_SUITE_END', line )
         if mo:
            (yield (self.tokenLeaveSuite, None ) )


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
   def __init__( self, f ):
      """Constructor."""
      self.f = f
      self.cases = 0
      self.suites = []

   def __del__( self ):
      """Destructor."""
      pass

   def enterSuite( self, name ):
      """Enter a new test suite level."""
      self.cases = 0
      self.suites.append( name )

   def leaveSuite( self, name=None ):
      """Leave a test suite level."""
      self.suites = self.suites[:-1]

   def testsuiteLevel( self ):
      """"Level of test suite: outermost is 1."""
      return len( self.suites )

   def testcaseCount( self ):
      """"Number of test cases in (sub)suite."""
      return self.cases

   def addTestCase( self, name ):
      """Add a test case name. If it's the first of a suite, first print
      suite name terminated with newline.
      """
# TODO (moene#1#): better name for print
      self.cases += 1
      if self.cases == 1:
         self.printSuiteName()
      self.printTestCaseName( name )

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

      >>> builder = TextFormatter( sys.stdout )
      >>> builder.splitCamelCaseWord( 'thingShowsBehaviour' )
      'Thing shows behaviour'
      """
      return re.sub( r'([A-Z]|\d+)', r' \1',text  ).lstrip().capitalize()


class TextFormatter( Builder ):
   """Output presented (sub)suites and testcases as plain text in the following
   format:

   Suite1.Subsuite1
   - thing has behaviour
   - thing has other behaviour

   Suite1.Subsuite2
   - thing has behaviour

   Tests:
   ------
   >>> builder = TextFormatter( sys.stdout )
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
   def __init__( self, f ):
      """Constructor."""
      Builder.__init__( self, f )

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

      >>> builder = TextFormatter( sys.stdout )
      >>> builder.enterSuite( 'Suite' )
      >>> builder.enterSuite( 'Subsuite' )
      >>> builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )
      <BLANKLINE>
      Suite.Subsuite
      - Add test case behaves as expected.
      """
      Builder.addTestCase( self, name )

   def printSuiteName( self ):
      """Print newline followed by hierarchical suite name.

      >>> builder = TextFormatter( sys.stdout )
      >>> builder.enterSuite( 'Suite' )
      >>> builder.enterSuite( 'Subsuite' )
      >>> builder.printSuiteName()
      <BLANKLINE>
      Suite.Subsuite
      """
      print( '\n{name}'.format( name=self.formatTestSuiteName() ), file=self.f )

   def printTestCaseName( self, text ):
      """Print testThatThingShowsBehaviour as '- thing shows behaviour'

      >>> builder = TextFormatter( sys.stdout )
      >>> builder.printTestCaseName( 'testThatThingShowsBehaviour' )
      - Thing shows behaviour.
      """
      print( '- {text}'.format( text=self.formatTestCaseName(text) ), file=self.f )



class HtmlFormatter( Builder ):
   """Output results as HTML.

   Tests:
   ------
   >>> builder = HtmlFormatter( sys.stdout )
   <html>
   <head>
   <style>
   body {  font-family: Consolas,"Bitstream Vera Sans Mono","Courier New",Courier,monospace; }
   .suite { color:navy; font-size: 120%; font-weight: bold; margin-bottom: 0.3em; }
   .testcase { margin-top: 0px; }
   </style>
   </head>
   <body>
   >>> builder.enterSuite( 'Suite' )
   >>> builder.enterSuite( 'Subsuite' )
   >>> builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )
   </ul><p class="suite">Suite.Subsuite</p><ul class="testcase">
   <li>Add test case behaves as expected.</li>
   >>> del builder
   </body>
   </html>
   """
# TODO (moene#1#): correct <ul>...</ul> balance.
   def __init__( self, f ):
      """Constructor."""
      Builder.__init__( self, f )
      print( """<html>
<head>
<style>
body {  font-family: Consolas,"Bitstream Vera Sans Mono","Courier New",Courier,monospace; }
.suite { color:navy; font-size: 120%; font-weight: bold; margin-bottom: 0.3em; }
.testcase { margin-top: 0px; }
</style>
</head>
<body>""", file=self.f )

   def __del__( self ):
      """Destructor."""
      Builder.__del__( self )
      print( '</body>\n</html>', file=self.f )

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

   def printSuiteName( self ):
      """Print newline followed by hierarchical suite name.
      """
      print( '</ul><p class="suite">{name}</p><ul class="testcase">'.format( name=self.formatTestSuiteName() ), file=self.f )

   def printTestCaseName( self, text ):
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

   parser.add_option(   "-d", "--debug"    ,  action="store_true" , dest="debug"    , help="show debug messages" )
   parser.add_option(   "-v", "--verbose"  ,  action="store_true" , dest="verbose"  , help="show more messages" )
   parser.add_option(   "-q", "--quiet"    ,  action="store_true" , dest="quiet"    , help="show less messages" )
#   parser.add_option(        "--logging"  , metavar="LEVEL"      , dest="logging"  , default="warning", help="logging level: debug,info,error,critical [warning]" )
   parser.add_option(   "-t", "--selftest" ,  action="store_true" , dest="selftest" , help="perform selftest; can also use option -v" )

   parser.add_option(         "--framework",  metavar="FW"        , dest="framework", help="select test framework: Boost.Test, CppUnit [Boost.Test]" )
   parser.add_option(         "--format"   ,  metavar="FORMAT"    , dest="format"   , help="select output format: html, text [text]" )
   parser.add_option(         "--glob"    ,  metavar="PATTERN"    , dest="glob"     , default="*.cpp|*.h", help="filename pattern to use with directories [*.cpp|*.h]" )

   (options, args) = parser.parse_args()

   if options.selftest:
      exit( doctest.testmod( verbose=options.verbose ) )

   if len( args ) < 1:
      parser.error( "expecting testsuite filename; try option --help" )

   if options.verbose:
      pass

   try:
      filecount = 0;

      # select scanner for test framework:
      if options.framework:
         if options.framework == 'Boost.Test':
            ScannerType = CppBoostTestScanner
         elif options.framework == 'CppUnit':
            ScannerType = CppUnitScanner
         else:
            parser.error( "invalid framework '{fw}', expecting 'Boost.Test', or CppUnit; try option --help".format( fw=options.framework) )
      else:
         ScannerType = CppBoostTestScanner

      # select output format:
      if options.format:
         if options.format == 'html':
            BuilderType = HtmlFormatter
         elif options.format == 'text':
            BuilderType = TextFormatter
         else:
            parser.error( "invalid format '{fmt}', expecting 'html' or 'text'; try option --help".format( fmt=options.format) )
      else:
         BuilderType = TextFormatter

      builder = BuilderType( sys.stdout )
      context = Context()

      for arg in args:
         # directory:
         if os.path.isdir( arg ):
            for root, dirs, files in os.walk(arg):
               for pattern in options.glob.split('|'):
                  for path in glob.glob( os.path.join(root, pattern ) ):
                     if options.verbose:
                        message( '{path}:'.format( path=path ) )
                     processFileByPath( path, ScannerType, builder, context )
                     filecount += 1

         # filename or wildcard:
         else:
            for path in glob.glob( arg ):
               if not os.path.isfile( path ):
                  continue
               if options.verbose:
                  message( '{path}:'.format( path=path ) )
               processFileByPath( path, ScannerType, builder, context )
               filecount += 1

      if not options.quiet:
         if filecount <= 0:
            message( "no files matched the given file specification(s)." )
         else:
            message( "{count} file{s} processed.".format( count=filecount, s=(filecount != 1 and 's' or '') ) )

   except IOError as detail:
      message( "cannot process file '{filename}', {strerror}".format( filename=path, strerror=detail ) )
      return 2
   except Exception as detail:
      message( '{0}'.format( detail ) )
      return 2
   finally:
      pass

   return 0


def message( msg ):
   """Issue message."""
   print( '{prog}: {msg}'.format( prog=progname, msg=msg) )

# ---------------------------------------------------------------------------

if __name__ == "__main__":
   main()

#
# end of file
#
