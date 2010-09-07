<h2 id="testdox">TestDox: create simple documentation from test case names in C++</h2>

<div class="floater">
<h3 id="downloads">Downloads</h3>
<ul style="padding-left:1.4em;">
<li><a href="src/testdox.py">testdox.py</a> (<a href="src/">view highlighted</a>)</li>
<li><a href="src/Readme.txt">Readme</a></li>
<li><a href="src/ChangeLog.txt">ChangeLog</a></li>
<li><a href="src/ToDo.txt">ToDo</a></li>
<li><a href="src/TestDox-0.1.4-alpha.zip">TestDox-0.1.4-alpha.zip</a></li>
<li><a href="src/testdox.exe">testdox.exe</a> packed executable</li>
</ul></div>

<p>Simple ideas can be powerful. TestDox is based on such an idea: <em>Test method
names should be sentences</em>. Using this convention, TestDox can generate a readable overview of
your <a title="Unit testing at Wikipedia" href="http://en.wikipedia.org/wiki/Unit_test">tests</a>, as in:</p>
<span style="font-family:Consolas"><p>CustomerLookup<br>
&emsp;&ndash;&nbsp;finds customer by id<br>
&emsp;&ndash;&nbsp;fails for duplicate customers<br>
</span>

<p>It was Chris Stevenson's idea to present the
<a title="Camel case at Wikipedia" href="http://en.wikipedia.org/wiki/Camel_case">camel case</a> method names in
<a title="JUnit at Wikipedia" href="http://en.wikipedia.org/wiki/Junit">JUnit</a>
test cases as
<a title="Sentence at Wikipedia" href="http://en.wikipedia.org/wiki/Sentence_%28linguistics%29">sentences</a>
and in <a title="The year 2003 at Wikipedia" href="http://en.wikipedia.org/wiki/2003">2003</a> he created the
<a title="Java at Wikipedia" href="http://en.wikipedia.org/wiki/Java_%28programming_language%29">Java</a> program
<a title="Chris Stevenson's Blog mentioning TestDox" href="http://skizz.biz/blog/2003/06/17/testdox-release-01/">TestDox</a>.
The idea has spread to several other
<a title="Programming language at Wikipedia" href="http://en.wikipedia.org/wiki/Programming_language">programming languages</a>
(or their <a title="Unit testing frameworks at Wikipedia" href="http://en.wikipedia.org/wiki/Unit_test#Unit_testing_frameworks">test frameworks</a>),
such as
<a title="C# at Wikipedia" href="http://en.wikipedia.org/wiki/C%2B%2B">C#</a>
(<a title=".net at Wikipedia" href="http://en.wikipedia.org/wiki/C%2B%2B">.net</a>),
<a title="PHP at Wikipedia" href="http://en.wikipedia.org/wiki/C%2B%2B">PHP</a> and
<a title="Ruby at Wikipedia" href="http://en.wikipedia.org/wiki/C%2B%2B">Ruby</a>,
but apparently not yet to
<a title="C++ at Wikipedia" href="http://en.wikipedia.org/wiki/C%2B%2B">C++</a>.
</p>

<div class="floater">
<h3 id="resources">Resources</h3>
<ul style="padding-left:1.4em">
<li><a href="http://en.wikipedia.org/wiki/TestDox">TestDox</a> at Wikipedia</li>
<li><a href="http://blog.dannorth.net/introducing-bdd/">Introducing BDD</a>, by Dan North</li>
<li><a href="http://joe.truemesh.com/blog//000047.html">Agiledox</a>, by Joe Walnes </li>
<li><a href="http://agiledox.sourceforge.net/">AgileDox project (Java)</a>, by <a href="http://skizz.biz/blog/">Chris Stevenson</a></li>
<li>AgileDox project <a href="http://agiledox.cvs.sourceforge.net/viewvc/agiledox/">CVS repository</a> with testdox, nAgileDox</li>
<li><a href="http://skizz.biz/blog/2003/06/17/testdox-release-01/">TestDox release 0.1</a> blog post by <a href="http://skizz.biz/blog/">Chris Stevenson</a></li>
<li><a href="http://testdox.codehaus.org/">TestDox for IntelliJ IDEA</a>, Codehaus</li>
<li><a href="http://www.testdox.com/">TestDox for .NET </a>, by NN</li>
<li><a href="http://www.phpunit.de/manual/3.5/en/other-uses-for-tests.html">TestDox (PHPUnit)</a>, by <a href="http://sebastian-bergmann.de/">Sebastian Bergmann</a></li>
<li><a href="http://www.slideshare.net/sebastian_bergmann/phpunit-best-practices">PHPUnit Best Practices</a>, by <a href="http://sebastian-bergmann.de/">Sebastian Bergmann</a></li>
<li><a href="http://xspecs.sourceforge.net/protest.html">Protest</a> test framework for Python, by <a href="http://www.natpryce.com/">Nat Pryce</a> (Subversion <a title="Subversion trunk at SourceForge" href="https://xspecs.svn.sourceforge.net/svnroot/xspecs/protest-python/trunk">trunk</a>)</li>
<li><a href="http://rspec.info/">rSpec</a>, Behaviour Driven Development framework for Ruby.</li>
<li><a href="http://www.stickyminds.com/pop_print.asp?ObjectId=13833&ObjectType=ART">Programming with GUTs</a> and
<a href="http://www.stickyminds.com/pop_print.asp?ObjectId=14973&ObjectType=ART">GUT Instinct</a>, by <a href="http://www.curbralan.com/">Kevlin Henney</a></li>
</ul></div>

<p>The original Java TestDox just creates an overview of the test
suites and their test cases: it documents the evolving design and code in an
agile way. To date test frameworks may be able to create the overview as part
of the test run and also indicate the test's success or failure as in:</p>
<span style="font-family:Consolas"><p>CustomerLookup<br>
&emsp;[x] finds customer by id<br>
&emsp;[&nbsp;] fails for duplicate customers<br>
</span></p>
<p>See for example PHPUnit,
<a href="http://www.phpunit.de/manual/3.5/en/other-uses-for-tests.html">Other
Uses for Tests: Agile Documentation</a>. Although I don't know of any C++ test
frameworks that provide TestDox reporting off-the-shelf, many frameworks may
support it via customization of their reporting mechanism. Below I intend to
present <a href="index.php#FrameworkCustomization">several examples of such
customization</a>. In case you cannot create the TestDox report from your test
framework, or do not want to do so, the Python TestDox script presented here
may be of help.
</p>

<h3>Python TestDox script</h3>
<p>The
<a title="Python at Wikipedia" href="http://en.wikipedia.org/wiki/Python_%28programming_language%29">Python</a>
TestDox script was initially created for use with the C++ test frameworks
<a title="Test at Boost" href="http://www.boost.org/doc/libs/release/libs/test/">Boost.Test</a> and
<a title="CppUnit at Wikipedia" href="http://en.wikipedia.org/wiki/CppUnit">CppUnit</a>.
It is distributed under the <a title="about the license at Boost.org" href="http://www.boost.org/users/license.html">Boost</a>
<a title="Open-source license at Wikipedia" href="http://en.wikipedia.org/wiki/Open_source_license">open source license</a>.
Feel free to grab the source code and change it to your own needs. Please
<a href="mailto:m.j.moene@eld.physics.LeidenUniv.nl?Subject=TestDox:">let me know</a>
if you made any substantial changes or additions. We then can add those to testdox.py,
so that other users also may benefit from them.
</p>

<h3>Recognized test name patterns</h3>
<p>TestDox recognizes test names that start with <em>test</em>,
<em>testThat</em>, or with <em>prefix_test[That]</em>, such as:</p>
<ul>
<li><span style="font-family:Consolas">testSystemExceptionIsCatchedWithCorrectReason</span></li>
<li><span style="font-family:Consolas">testThatSystemExceptionIsCatchedWithCorrectReason</span></li>
<li><span style="font-family:Consolas">format_testThatStringIsCorrectlyFormatted</span></li>
</ul>
<p>In its report, TestDox presents these names as follows:</p>
<ul>
<li><span style="font-family:Consolas">System exception is catched with correct reason.</span></li>
<li><span style="font-family:Consolas">format: String is correctly formatted.</span></li>
</ul>

<h3 id="help">TestDox help screen</h3>
<pre>
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
</pre>

<h3 id="cppunit">CppUnit example</h3>
<p>Relevant input:<p>
<pre><tt><span class="linenum">01:</span> <span class="comment">//</span><span class="comment"> file: cppunit-fractiontest.h</span>
<span class="linenum">02:</span> <span class="preproc">#ifndef</span><span class="normal"> FRACTIONTEST_H</span>
<span class="linenum">03:</span> <span class="preproc">#define</span><span class="normal"> FRACTIONTEST_H</span>
<span class="linenum">04:</span>
<span class="linenum">05:</span> <span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;cppunit/TestFixture.h&gt;</span>
<span class="linenum">06:</span> <span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;cppunit/extensions/HelperMacros.h&gt;</span>
<span class="linenum">07:</span> <span class="preproc">#include</span><span class="normal"> </span><span class="string">"Fraction.h"</span>
<span class="linenum">08:</span>
<span class="linenum">09:</span> <span class="keyword">using</span><span class="normal"> </span><span class="keyword">namespace</span><span class="normal"> std</span><span class="symbol">;</span>
<span class="linenum">10:</span>
<span class="linenum">11:</span> <span class="keyword">class</span><span class="normal"> Fractiontest </span><span class="symbol">:</span><span class="normal"> </span><span class="keyword">public</span><span class="normal"> CPPUNIT_NS </span><span class="symbol">:</span><span class="symbol">:</span><span class="normal"> TestFixture</span>
<span class="linenum">12:</span> <span class="cbracket">{</span>
<span class="linenum">13:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST_SUITE </span><span class="symbol">(</span><span class="normal">Fractiontest</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">14:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST </span><span class="symbol">(</span><span class="normal">testThatFractionsAddCorrectly</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">15:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST </span><span class="symbol">(</span><span class="normal">testThatFractionsSubtractCorrectly</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">16:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST </span><span class="symbol">(</span><span class="normal">testThatExceptionIsThrownForCondition</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">17:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST </span><span class="symbol">(</span><span class="normal">testThatFractionsCompareCorreclty</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">18:</span> <span class="normal">    </span><span class="function">CPPUNIT_TEST_SUITE_END </span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">19:</span>
<span class="linenum">20:</span> <span class="normal">    </span><span class="keyword">public</span><span class="symbol">:</span>
<span class="linenum">21:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">setUp </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">22:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">tearDown </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">23:</span>
<span class="linenum">24:</span> <span class="normal">    </span><span class="keyword">protected</span><span class="symbol">:</span>
<span class="linenum">25:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">testThatFractionsAddCorrectly </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">26:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">testThatFractionsSubtractCorrectly </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">27:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">testThatExceptionIsThrownForCondition </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">28:</span> <span class="normal">        </span><span class="type">void</span><span class="normal"> </span><span class="function">testThatFractionsCompareCorreclty </span><span class="symbol">(</span><span class="type">void</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="linenum">29:</span>
<span class="linenum">30:</span> <span class="normal">    </span><span class="keyword">private</span><span class="symbol">:</span>
<span class="linenum">31:</span> <span class="normal">        Fraction </span><span class="symbol">*</span><span class="normal">a</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">b</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">c</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">d</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">e</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">f</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">g</span><span class="symbol">,</span><span class="normal"> </span><span class="symbol">*</span><span class="normal">h</span><span class="symbol">;</span>
<span class="linenum">32:</span> <span class="cbracket">}</span><span class="symbol">;</span>
<span class="linenum">33:</span>
<span class="linenum">34:</span> <span class="preproc">#endif</span>
</tt></pre>


<p>Result in plain text format:<p>
<pre>
prompt>python testdox.py --quiet --framework=CppUnit cppunit-fraction-test.h

Fractiontest
- Fractions add correctly.
- Fractions subtract correctly.
- Exception is thrown for condition.
- Fractions compare correclty.
</pre>

<h3 id="boost_test">Boost.Test example</h3>
<p>Relevant input:<p>
<pre>
prompt>grep BOOST_.*TEST Exception.cpp ScopeGuard.cpp String.cpp
<tt><span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> Core </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> Exception </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatSystemExceptionIsCatchedWithCorrectReason</span><span class="symbol">,</span><span class="normal"> Fixture </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatSpmNeverGetHereExceptionIsCatchedWithCorrectReason</span><span class="symbol">,</span><span class="normal"> Fixture </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatSystemExceptionIsCatchedWithCorrectReasonAndUserErrorCode</span><span class="symbol">,</span><span class="normal"> Fixture </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatSystemExceptionIsCatchedWithCorrectArbitraryData</span><span class="symbol">,</span><span class="normal"> Fixture</span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatSystemExceptionCopyIsCatchedWithCorrectArbitraryData</span><span class="symbol">,</span><span class="normal"> Fixture </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_FIXTURE_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatExceptionConvertedFromBoostIsCatchedWithCorrectArbitraryData</span><span class="symbol">,</span><span class="normal"> Fixture </span><span class="symbol">)</span>
<span class="normal">Exception</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> ExceptionScopeGuard.cpp:BOOST_AUTO_TEST_SUITE( Core )</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> ScopeGuard </span><span class="symbol">)</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatGlobalVariableIsClearedOnBlockExit </span><span class="symbol">)</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatLocalVariableIsClearedOnBlockExit </span><span class="symbol">)</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatMemberVariableIsClearedOnBlockExit</span><span class="symbol">)</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> ScopeGuard</span>
<span class="normal">ScopeGuard</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> Core</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> Core </span><span class="symbol">)</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> String </span><span class="symbol">)</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> format_testThatIntIsCorrectlyFormatted </span><span class="symbol">)</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> format_testThatStringIsCorrectlyFormatted </span><span class="symbol">)</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> String</span>
<span class="normal">String</span><span class="symbol">.</span><span class="normal">cpp</span><span class="symbol">:</span><span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> Core</span>
</tt></pre>


<p>Result in plain text format:<p>
<pre>
prompt>python testdox.py --quiet --framework=Boost.Test Exception.cpp ScopeGuard.cpp String.cpp

Core.Exception
- System exception is catched with correct reason.
- Spm never get here exception is catched with correct reason.
- System exception is catched with correct reason and user error code.
- System exception is catched with correct arbitrary data.
- System exception copy is catched with correct arbitrary data.
- Exception converted from boost is catched with correct arbitrary data.

Core.ScopeGuard
- Global variable is cleared on block exit.
- Local variable is cleared on block exit.
- Member variable is cleared on block exit.

Core.String
- format: Int is correctly formatted.
- format: String is correctly formatted.
</pre>

<h3><a name="FrameworkCustomization"></a>Framework customization</h3>

<h4>Boost.Test</h4>
<ul>
<li><a href="boosttest/">View customization</a></li>
<li><a href="http://www.boost.org/doc/libs/release/libs/test/">Boost.Test at Boost</a>
</ul>

<h4>UnitTest++</h4>
<ul>
<li><a href="unittestpp/">View customization</a></li>
<li><a href="http://code.google.com/p/unittestpp/">UnitTest++ on Google Code</a>,
svn <a href="http://unittestpp.googlecode.com/svn/">repository</a></li>
<li><a href="http://unittest-cpp.sourceforge.net//">UnitTest++ on SourceForge</a></li>
</ul>

<p style="color:grey;font-size:80%">Page created 6 September 2010</p>
