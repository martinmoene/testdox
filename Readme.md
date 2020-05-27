# TestDox: create simple documentation from test case names in C++

Simple ideas can be powerful. TestDox is based on such an idea: *Test method names should be sentences*. Using this convention, TestDox can generate a readable overview of your [tests](http://en.wikipedia.org/wiki/Unit_test "Unit testing at Wikipedia"), as in:

```Text
CustomerLookup
 - finds customer by id
 - fails for duplicate customers
```

It was Chris Stevenson\'s idea to present the [camel case](http://en.wikipedia.org/wiki/Camel_case "Camel case at Wikipedia") method names in [JUnit](http://en.wikipedia.org/wiki/Junit "JUnit at Wikipedia") test cases as [sentences](http://en.wikipedia.org/wiki/Sentence_%28linguistics%29 "Sentence at Wikipedia") and in [2003](http://en.wikipedia.org/wiki/2003 "The year 2003 at Wikipedia") he created the [Java](http://en.wikipedia.org/wiki/Java_%28programming_language%29 "Java at Wikipedia") program [TestDox](http://skizz.biz/blog/2003/06/17/testdox-release-01/ "Chris Stevenson's Blog mentioning TestDox"). The idea has spread to tools or [unit test frameworks](http://en.wikipedia.org/wiki/Unit_test#Unit_testing_frameworks "Unit testing frameworks at Wikipedia") for several [programming languages](http://en.wikipedia.org/wiki/Programming_language "Programming language at Wikipedia") such as [C\#](http://en.wikipedia.org/wiki/C%2B%2B "C# at Wikipedia") ([.net](http://en.wikipedia.org/wiki/C%2B%2B ".net at Wikipedia")) and [PHP](http://en.wikipedia.org/wiki/C%2B%2B "PHP at Wikipedia") and it seems common for frameworks for [Behavior Driven Development (BDD)](http://en.wikipedia.org/wiki/Behavior_driven_development "Behavior Driven Development (BDD) at Wikipedia"). However I haven\'t come across it in conventional [C++](http://en.wikipedia.org/wiki/C%2B%2B "C++ at Wikipedia") unit test frameworks ([check-it](http://www.google.nl/search?q=%2Btestdox+%2Bc%2B%2B "Perform a Google search on +testdox +C++")).

The original Java TestDox just creates an overview of the test suites and their test cases: it documents the evolving design and code in an agile way. To date unit test frameworks may be able to create the overview as part of the test run and also indicate the test\'s success or failure as in:

```Text
CustomerLookup
  [x] finds customer by id
  [ ] fails for duplicate customers
```

See for example PHPUnit, [Other Uses for Tests: Agile Documentation](http://www.phpunit.de/manual/3.5/en/other-uses-for-tests.html). Although I don\'t know of any non-BDD C++ test frameworks that provide TestDox reporting off-the-shelf, many frameworks may support it via customization of their reporting mechanism. Below I intend to present [several examples of such customization](index.php#FrameworkCustomization). In case you cannot create the TestDox report from your test framework, or do not want to do so, the Python TestDox script presented here may be of help.

## Python TestDox script

The [Python](http://en.wikipedia.org/wiki/Python_%28programming_language%29 "Python at Wikipedia") TestDox script was initially created for use with the C++ test frameworks [Boost.Test](http://www.boost.org/doc/libs/release/libs/test/ "Test at Boost") and [CppUnit](http://en.wikipedia.org/wiki/CppUnit "CppUnit at Wikipedia"). It is distributed under the [Boost](http://www.boost.org/users/license.html "about the license at Boost.org") [open source license](http://en.wikipedia.org/wiki/Open_source_license "Open-source license at Wikipedia"). Feel free to grab the source code and change it to your own needs. Please [let me know](mailto:m.j.moene@eld.physics.LeidenUniv.nl?Subject=TestDox:) if you made any substantial changes or additions. We then can add those to testdox.py, so that other users also may benefit from them.

## Recognized test name patterns

TestDox recognizes test names that start with *test*, *testThat*, or
with *prefix\_test\[That\]*, such as:

- `testSystemExceptionIsCatchedWithCorrectReason`
- `testThatSystemExceptionIsCatchedWithCorrectReason`
- `format_testThatStringIsCorrectlyFormatted`

In its report, TestDox presents these names as follows:

- `System exception is catched with correct reason.`
- `format: String is correctly formatted.`

## TestDox help screen

```Text
Usage: testdox.py [options] [directory | file...]

Create test documentation from testsuite files based on testdox format.  See
also: http://blog.dannorth.net/introducing-bdd/

Options:
  --version        show program's version number and exit
  -h, --help       show this help message and exit
  -d, --debug      show debug messages
  -v, --verbose    show more messages
  -q, --quiet      show less messages
  -t, --selftest   perform selftest; can also use option -v
  --title=title    specify title for report [none]
  --framework=fw   select test framework: Boost.Test, CppUnit [Boost.Test]
  --format=format  select output format: html, text [text]
  --glob=pattern   filename pattern to use with directories [*.cpp|*.h]
  --depth=n        directory recursion depth, norecurse is 1 [recurse]
  --norecurse      prevent visiting subdirectories [no]
  --htmlbodyonly   only generate contents of body tag fragment [no]
```

## TestDox output examples

- [CppUnit example](website/output/cppunit/)
- [Boost.Test example](website/output/boosttest/)

## Framework customization

### Boost.Test

- [View customization](website/boosttest/)
- [Boost.Test at Boost](http://www.boost.org/doc/libs/release/libs/test/)

### UnitTest++

- [View customization](website/unittestpp/)
- [UnitTest++ on Google Code](http://code.google.com/p/unittestpp/), svn [repository](http://unittestpp.googlecode.com/svn/)
- [UnitTest++ on SourceForge](http://unittest-cpp.sourceforge.net/)

## Downloads

- [testdox.py](website/src/testdox.py) ([view highlighted](website/src/))
- [Readme.txt](Readme.txt)
- [ChangeLog](ChangeLog.txt)
- [ToDo](ToDo.txt)
- [TestDox-0.1.4-alpha.zip](https://secure.eld.leidenuniv.nl/~moene/Home/projects/testdox/src/TestDox-0.1.4-alpha.zip)
- [testdox.exe](https://secure.eld.leidenuniv.nl/~moene/Home/projects/testdox/src/testdox.exe) packed executable

## Resources

- [TestDox](http://en.wikipedia.org/wiki/TestDox) at Wikipedia
- [Behavior Driven Development (BDD)](http://en.wikipedia.org/wiki/Behavior_driven_development) at Wikipedia
- [Introducing BDD](http://blog.dannorth.net/introducing-bdd/), by Dan North
- [Agiledox](http://joe.truemesh.com/blog//000047.html), by Joe Walnes
- [AgileDox project (Java)](http://agiledox.sourceforge.net/), by [Chris Stevenson](http://skizz.biz/blog/)
- AgileDox project [CVS repository](http://agiledox.cvs.sourceforge.net/viewvc/agiledox/) with testdox, nAgileDox
- [TestDox release 0.1](http://skizz.biz/blog/2003/06/17/testdox-release-01/) blog post by [Chris Stevenson](http://skizz.biz/blog/)
- [TestDox for IntelliJ IDEA](http://testdox.codehaus.org/), Codehaus
- [TestDox for .NET](http://www.testdox.com/) , by NN
- [TestDox (PHPUnit)](http://www.phpunit.de/manual/3.5/en/other-uses-for-tests.html), by [Sebastian Bergmann](http://sebastian-bergmann.de/)
- [PHPUnit Best Practices](http://www.slideshare.net/sebastian_bergmann/phpunit-best-practices), by [Sebastian Bergmann](http://sebastian-bergmann.de/)
- [Protest](http://xspecs.sourceforge.net/protest.html) test framework for Python, by [Nat Pryce](http://www.natpryce.com/) (Subversion [trunk](https://xspecs.svn.sourceforge.net/svnroot/xspecs/protest-python/trunk "Subversion trunk at SourceForge"))
- [Programming with GUTs](http://www.stickyminds.com/pop_print.asp?ObjectId=13833&ObjectType=ART) and [GUT Instinct](http://www.stickyminds.com/pop_print.asp?ObjectId=14973&ObjectType=ART), by [Kevlin Henney](http://www.curbralan.com/)
- [Naming standards for unit tests](http://weblogs.asp.net/rosherove/archive/2005/04/03/TestNamingStandards.aspx), by Roy Osherove
