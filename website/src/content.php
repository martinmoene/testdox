<h2 id="testdox">TestDox: create simple documentation from test case names</h2>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="comment">#</span><span class="comment">!/usr/bin/env python</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> testdox.py (Python 2.6, 3.0)</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> Generate a readable overview of test case names from the specified files.</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> Inspired on TestDox by Chris Stevenson, see</span>
<span class="comment">#</span><span class="comment"> http://skizz.biz/blog/2003/06/17/testdox-release-01/</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> Author: Martin Moene, http://www.eld.leidenuniv.nl/~moene/</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> This tool is provided under the Boost license.  Please read</span>
<span class="comment">#</span><span class="comment"> http://www.boost.org/users/license.html for the original text.</span>
<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> $Id: testdox.py 235 2010-09-05 20:43:26Z moene $</span>
<span class="comment">#</span>

<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> See also Kodos - The Python Regex Debugger, http://kodos.sourceforge.net/.</span>
<span class="comment">#</span>

<span class="comment">"""</span><span class="comment">Create test documentation from testsuite files based on testdox format.</span>

<span class="comment">See also: http://blog.dannorth.net/introducing-bdd/</span>
<span class="comment">"""</span>

<span class="preproc">from</span><span class="normal"> </span><span class="variable">_</span><span class="variable">_</span><span class="normal">future</span><span class="variable">_</span><span class="variable">_</span><span class="normal"> </span><span class="preproc">import</span><span class="normal"> print</span><span class="variable">_</span><span class="normal">function</span>

<span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="normal">info</span><span class="variable">_</span><span class="variable">_</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> </span><span class="number">0</span><span class="symbol">,</span><span class="normal"> </span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="number">4</span><span class="symbol">,</span><span class="normal"> </span><span class="string">'alpha'</span><span class="symbol">,</span><span class="normal"> </span><span class="number">0</span><span class="normal"> </span><span class="symbol">)</span>
<span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="normal">date</span><span class="variable">_</span><span class="variable">_</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'$Date: 2010-09-05 22:43:26 +0200 (Sun, 05 Sep 2010) $'</span>
<span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="variable">_</span><span class="normal">      </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'$Revision: 235 $'</span>
<span class="variable">_</span><span class="variable">_</span><span class="normal">author</span><span class="variable">_</span><span class="variable">_</span><span class="normal">       </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'Martin Moene &lt;m.j.moene@eld.physics.LeidenUniv.nl&gt;'</span>
<span class="variable">_</span><span class="variable">_</span><span class="normal">url</span><span class="variable">_</span><span class="variable">_</span><span class="normal">          </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'http://www.eld.leidenuniv.nl/~moene/Home/projects/testdox/'</span>

<span class="preproc">import</span><span class="normal"> doctest</span>
<span class="preproc">import</span><span class="normal"> glob</span>
<span class="preproc">import</span><span class="normal"> os</span>
<span class="preproc">import</span><span class="normal"> re</span>
<span class="preproc">import</span><span class="normal"> string</span>
<span class="preproc">import</span><span class="normal"> sys</span>

<span class="preproc">from</span><span class="normal"> optparse </span><span class="preproc">import</span><span class="normal"> </span><span class="variable">OptionParser</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">OptionGroup</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">versionString</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Version string such as '1.2.3'</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> </span><span class="string">'.'</span><span class="symbol">.</span><span class="function">join</span><span class="symbol">(</span><span class="function">map</span><span class="symbol">(</span><span class="normal">str</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="normal">info</span><span class="variable">_</span><span class="variable">_</span><span class="symbol">[</span><span class="number">0</span><span class="symbol">:</span><span class="number">3</span><span class="symbol">]</span><span class="symbol">)</span><span class="symbol">)</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">versionState</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Version state such as 'alpha', 'beta', 'final'</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> </span><span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="normal">info</span><span class="variable">_</span><span class="variable">_</span><span class="symbol">[</span><span class="number">3</span><span class="symbol">]</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">versionDate</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Version date such as 'Thu, 10 Jun 2010'</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> </span><span class="variable">_</span><span class="variable">_</span><span class="normal">version</span><span class="variable">_</span><span class="normal">date</span><span class="variable">_</span><span class="variable">_</span><span class="symbol">[</span><span class="number">34</span><span class="symbol">:</span><span class="symbol">-</span><span class="number">3</span><span class="symbol">]</span>


<span class="keyword">class</span><span class="normal"> </span><span class="variable">Context</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Processing context.</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> title</span><span class="symbol">=</span><span class="variable">None</span><span class="symbol">,</span><span class="normal"> htmlbodyonly</span><span class="symbol">=</span><span class="variable">None</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">title </span><span class="symbol">=</span><span class="normal"> title</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">htmlbodyonly </span><span class="symbol">=</span><span class="normal"> htmlbodyonly</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">wrapup</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">      </span><span class="keyword">pass</span>


<span class="keyword">class</span><span class="normal"> </span><span class="variable">Scanner</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Base class for unit test scanners.</span><span class="comment">"""</span>
<span class="normal">   token</span><span class="variable">Eof</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">   token</span><span class="variable">EnterSuite</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">   token</span><span class="variable">LeaveSuite</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">2</span>
<span class="normal">   token</span><span class="variable">TestCase</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">3</span>


<span class="keyword">class</span><span class="normal"> </span><span class="function">CppUnitKindScanner</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">Scanner</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Scanner for CppUnit-like C++ unit tests.</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">framework</span><span class="symbol">,</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">testcase</span><span class="symbol">,</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">beginsuite</span><span class="symbol">,</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">endsuite </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Construct from file.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">=</span><span class="normal"> f</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">framework  </span><span class="symbol">=</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">compile</span><span class="symbol">(</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">framework </span><span class="symbol">)</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">testcase   </span><span class="symbol">=</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">compile</span><span class="symbol">(</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">testcase </span><span class="symbol">)</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">beginsuite </span><span class="symbol">=</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">compile</span><span class="symbol">(</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">beginsuite </span><span class="symbol">)</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">endsuite   </span><span class="symbol">=</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">compile</span><span class="symbol">(</span><span class="normal"> re</span><span class="variable">_</span><span class="normal">endsuite </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">tokens</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Return tokens with testsuite and testcase names found as (token, name)</span>
<span class="comment">      tuple.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">for</span><span class="normal"> line </span><span class="keyword">in</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">f</span><span class="symbol">.</span><span class="function">readlines</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>

<span class="normal">         </span><span class="comment">#</span><span class="comment"> ignore lines that do not contain framework instructions:</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> </span><span class="keyword">not</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">framework</span><span class="symbol">.</span><span class="function">search</span><span class="symbol">(</span><span class="normal"> line </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">            </span><span class="keyword">continue</span><span class="symbol">;</span>

<span class="comment">#</span><span class="comment">         print( line, end='' )</span>

<span class="normal">         </span><span class="comment">#</span><span class="comment"> check for a fixture, or auto test case (most likely case first):</span>
<span class="normal">         mo </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">testcase</span><span class="symbol">.</span><span class="function">search</span><span class="symbol">(</span><span class="normal"> line </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> mo</span><span class="symbol">:</span>
<span class="normal">            </span><span class="symbol">(</span><span class="function">yield </span><span class="symbol">(</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">TestCase</span><span class="symbol">,</span><span class="normal"> mo</span><span class="symbol">.</span><span class="function">group</span><span class="symbol">(</span><span class="string">'name'</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">         </span><span class="comment">#</span><span class="comment"> check for a new test suite level:</span>
<span class="normal">         mo </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">beginsuite</span><span class="symbol">.</span><span class="function">search</span><span class="symbol">(</span><span class="normal"> line </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> mo</span><span class="symbol">:</span>
<span class="normal">            </span><span class="symbol">(</span><span class="function">yield </span><span class="symbol">(</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">EnterSuite</span><span class="symbol">,</span><span class="normal"> mo</span><span class="symbol">.</span><span class="function">group</span><span class="symbol">(</span><span class="string">'name'</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">         </span><span class="comment">#</span><span class="comment"> check for the end of a test suite level:</span>
<span class="normal">         mo </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">mo</span><span class="variable">_</span><span class="normal">endsuite</span><span class="symbol">.</span><span class="function">search</span><span class="symbol">(</span><span class="normal"> line </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> mo</span><span class="symbol">:</span>
<span class="normal">            </span><span class="symbol">(</span><span class="function">yield </span><span class="symbol">(</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">LeaveSuite</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">None</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>


<span class="keyword">class</span><span class="normal"> </span><span class="function">CppUnitScanner</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">CppUnitKindScanner</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Scanner for CppUnit C++ unit tests.</span>

<span class="comment">   URL: http://cppunit.sourceforge.net/</span>

<span class="comment">   CPPUNIT_TEST_SUITE (suite_name)</span>
<span class="comment">   CPPUNIT_TEST_SUITE_END ()</span>
<span class="comment">   CPPUNIT_TEST (test_case_name)</span>

<span class="comment">   xxx with open( 'test.txt', 'r' ) as f:</span>
<span class="comment">   ...   scanner = CppBoostTestScanner( f )</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Construct from file.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">CppUnitKindScanner</span><span class="symbol">.</span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span>
<span class="normal">          re</span><span class="variable">_</span><span class="normal">framework</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'CPPUNIT_'</span><span class="symbol">,</span>
<span class="normal">           re</span><span class="variable">_</span><span class="normal">testcase</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'CPPUNIT_TEST\s*\(\s*(?P&lt;name&gt;\w+)'</span><span class="symbol">,</span>
<span class="normal">         re</span><span class="variable">_</span><span class="normal">beginsuite</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'CPPUNIT_TEST_SUITE\s*\(\s*(?P&lt;name&gt;\w+)'</span><span class="symbol">,</span>
<span class="normal">           re</span><span class="variable">_</span><span class="normal">endsuite</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'CPPUNIT_TEST_SUITE_END'</span><span class="normal"> </span><span class="symbol">)</span>


<span class="keyword">class</span><span class="normal"> </span><span class="function">CppBoostTestScanner</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">CppUnitKindScanner</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Scanner for Boost.Test C++ unit tests.</span>

<span class="comment">   URL: http://www.boost.org/doc/libs/release/libs/test/</span>

<span class="comment">   BOOST_AUTO_TEST_SUITE( suite_name )</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE_END()</span>
<span class="comment">   BOOST_AUTO_TEST_CASE( test_case_name )</span>
<span class="comment">   BOOST_AUTO_TEST_CASE_TEMPLATE( test_case_name, formal_type_parameter_name, collection_of_types )</span>
<span class="comment">   BOOST_TEST_CASE( test_case_name )</span>
<span class="comment">   BOOST_TEST_CASE_TEMPLATE( test_case_name, collection_of_types )</span>
<span class="comment">   BOOST_TEST_CASE_TEMPLATE_FUNCTION( test_case_name, type_name)</span>
<span class="comment">   BOOST_FIXTURE_TEST_CASE( test_case_name, fixture_name )</span>

<span class="comment">   xxx with open( 'test.txt', 'r' ) as f:</span>
<span class="comment">   ...   scanner = CppBoostTestScanner( f )</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Construct from file.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">CppUnitKindScanner</span><span class="symbol">.</span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span>
<span class="normal">          re</span><span class="variable">_</span><span class="normal">framework</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'BOOST_'</span><span class="symbol">,</span>
<span class="normal">           re</span><span class="variable">_</span><span class="normal">testcase</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'TEST_CASE(_TEMPLATE(_FUNCTION)?)?\s*\(\s*(?P&lt;name&gt;\w+)'</span><span class="symbol">,</span>
<span class="comment">#</span><span class="comment">           re_testcase=r'(BOOST_TEST_CASE_TEMPLATE(_FUNCTION)?|BOOST_FIXTURE_TEST_CASE|BOOST(_AUTO)?_TEST_CASE)\s*\(\s*(?P&lt;name&gt;\w+)',</span>
<span class="normal">         re</span><span class="variable">_</span><span class="normal">beginsuite</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'BOOST_AUTO_TEST_SUITE\s*\(\s*(?P&lt;name&gt;\w+)'</span><span class="symbol">,</span>
<span class="normal">           re</span><span class="variable">_</span><span class="normal">endsuite</span><span class="symbol">=</span><span class="normal">r</span><span class="string">'BOOST_AUTO_TEST_SUITE_END'</span><span class="normal"> </span><span class="symbol">)</span>


<span class="keyword">class</span><span class="normal"> </span><span class="function">CppGoogleTestScanner</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">Scanner</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Scanner for Google Test C++ unit tests.</span>

<span class="comment">   URL: http://code.google.com/p/googletest/</span>

<span class="comment">   TEST(test_case_name, test_name), e.g. TEST(FactorialTest, HandlesZeroInput),</span>
<span class="comment">   TEST_F(test_case_name, test_name), e.g. TEST_F(QueueTest, IsEmptyInitially).</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">pass</span>

<span class="keyword">class</span><span class="normal"> </span><span class="variable">Parser</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Parser for testsuites. This one works with Boost.Test testsuite,</span>
<span class="comment">   testcase hierarchy, for example:</span>

<span class="comment">   BOOST_AUTO_TEST_SUITE( Suite1 )</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE( SubSuite1 )</span>
<span class="comment">   BOOST_AUTO_TEST_CASE( testThatThingHasBehaviour )</span>
<span class="comment">   BOOST_FIXTURE_TEST_CASE( testThatThingHasOtherBehaviour, Fixture )</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE_END() // SubSuite1</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE( SubSuite2 )</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE_END() // SubSuite2</span>
<span class="comment">   BOOST_AUTO_TEST_SUITE_END() // Suite1</span>

<span class="comment">   Usage:</span>
<span class="comment">      Scanner scanner( file );</span>
<span class="comment">      Builder builder();</span>
<span class="comment">      Context context()</span>
<span class="comment">      Parser  parser( scanner, builder, context );</span>
<span class="comment">      parser.parse();</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> scanner</span><span class="symbol">,</span><span class="normal"> builder</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Construct from scanner, builder and context.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">scanner </span><span class="symbol">=</span><span class="normal"> scanner</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">builder </span><span class="symbol">=</span><span class="normal"> builder</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">context </span><span class="symbol">=</span><span class="normal"> context</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">parse</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Constructor.</span><span class="comment">"""</span>
<span class="normal">      s</span><span class="variable">_</span><span class="normal">entering</span><span class="variable">_</span><span class="normal">suite </span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">      s</span><span class="variable">_</span><span class="normal">scanning</span><span class="variable">_</span><span class="normal">cases </span><span class="symbol">=</span><span class="normal"> </span><span class="number">2</span>
<span class="normal">      s</span><span class="variable">_</span><span class="normal">leaving</span><span class="variable">_</span><span class="normal">suite </span><span class="symbol">=</span><span class="normal"> </span><span class="number">3</span>
<span class="normal">      state </span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">entering</span><span class="variable">_</span><span class="normal">suite</span>

<span class="normal">      </span><span class="keyword">for</span><span class="normal"> </span><span class="symbol">(</span><span class="normal">token</span><span class="symbol">,</span><span class="normal"> name</span><span class="symbol">)</span><span class="normal"> </span><span class="keyword">in</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">scanner</span><span class="symbol">.</span><span class="function">tokens</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">#</span><span class="comment">         print ( 'token:{t} name:{n}'.format(t=token, n=name) )</span>

<span class="normal">         </span><span class="keyword">while</span><span class="normal"> </span><span class="variable">True</span><span class="symbol">:</span>
<span class="normal">            </span><span class="keyword">if</span><span class="normal"> state </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">entering</span><span class="variable">_</span><span class="normal">suite</span><span class="symbol">:</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> token </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="variable">Scanner</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">EnterSuite</span><span class="symbol">:</span>
<span class="normal">                  self</span><span class="symbol">.</span><span class="normal">builder</span><span class="symbol">.</span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span>
<span class="normal">                  </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">               </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">                  state </span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">scanning</span><span class="variable">_</span><span class="normal">cases</span>

<span class="normal">            </span><span class="keyword">elif</span><span class="normal"> state </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">scanning</span><span class="variable">_</span><span class="normal">cases</span><span class="symbol">:</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> token </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="variable">Scanner</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">TestCase</span><span class="symbol">:</span>
<span class="normal">                  self</span><span class="symbol">.</span><span class="normal">builder</span><span class="symbol">.</span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span>
<span class="normal">                  </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">               </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">                  state </span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">leaving</span><span class="variable">_</span><span class="normal">suite</span>

<span class="normal">            </span><span class="keyword">elif</span><span class="normal"> state </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">leaving</span><span class="variable">_</span><span class="normal">suite</span><span class="symbol">:</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> token </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="variable">Scanner</span><span class="symbol">.</span><span class="normal">token</span><span class="variable">LeaveSuite</span><span class="symbol">:</span>
<span class="normal">                  self</span><span class="symbol">.</span><span class="normal">builder</span><span class="symbol">.</span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span>
<span class="normal">                  </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">               </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">                  state </span><span class="symbol">=</span><span class="normal"> s</span><span class="variable">_</span><span class="normal">entering</span><span class="variable">_</span><span class="normal">suite</span>


<span class="keyword">class</span><span class="normal"> </span><span class="variable">Builder</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Base class for output generators.</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> context</span><span class="symbol">=</span><span class="function">Context</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Constructor.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">=</span><span class="normal"> f</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">context </span><span class="symbol">=</span><span class="normal"> context</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">case</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">suite</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">suites </span><span class="symbol">=</span><span class="normal"> </span><span class="symbol">[</span><span class="symbol">]</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="function">writeLeader</span><span class="symbol">(</span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__del__</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Destructor.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="function">writeTrailer</span><span class="symbol">(</span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeLeader</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Write the report's leader.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTrailer</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Write the report's trailer.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeSuiteName</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Write the collected suite name.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTestCaseName</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Write the given test case name.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Enter a new test suite level.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">case</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">suite</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">suites</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name</span><span class="symbol">=</span><span class="variable">None</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Leave a test suite level.</span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">suites </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">suites</span><span class="symbol">[</span><span class="symbol">:</span><span class="symbol">-</span><span class="number">1</span><span class="symbol">]</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">testSuiteLevel</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">"Level of test suite: outermost is 1.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> </span><span class="function">len</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">suites </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">testSuiteCount</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">"Number of test suite so far.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">suite</span><span class="variable">Count</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">testCaseCount</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">"Number of test cases in (sub)suite so far.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">case</span><span class="variable">Count</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Add a test case name. If it's the first of a suite, first write</span>
<span class="comment">      suite name terminated with newline.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="normal">case</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">case</span><span class="variable">Count</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">         self</span><span class="symbol">.</span><span class="function">writeSuiteName</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="normal">      self</span><span class="symbol">.</span><span class="function">writeTestCaseName</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">formatTitle</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Return title as is.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">context</span><span class="symbol">.</span><span class="normal">title</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">formatTestSuiteName</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Return suite name as Suite.Subsuite.</span><span class="comment">"""</span>
<span class="normal">      count </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      result </span><span class="symbol">=</span><span class="normal"> </span><span class="string">''</span>
<span class="normal">      </span><span class="keyword">for</span><span class="normal"> name </span><span class="keyword">in</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">suites</span><span class="symbol">:</span>
<span class="normal">         count </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">         result </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'{dot}{name}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal">name</span><span class="symbol">=</span><span class="normal">name</span><span class="symbol">,</span><span class="normal"> dot</span><span class="symbol">=</span><span class="symbol">(</span><span class="normal">count </span><span class="symbol">&gt;</span><span class="normal"> </span><span class="number">1</span><span class="normal"> </span><span class="keyword">and</span><span class="normal"> </span><span class="string">'.'</span><span class="normal"> </span><span class="keyword">or</span><span class="normal"> </span><span class="string">''</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> result</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">formatTestCaseName</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> test</span><span class="variable">CaseName</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Return '[prefix_]testThatThingShowsBehaviour' as 'thing shows behaviour'.</span>

<span class="comment">      &gt;&gt;&gt; builder = Builder( sys.stdout )</span>
<span class="comment">      &gt;&gt;&gt; builder.formatTestCaseName( 'testThingShowsBehaviour' )</span>
<span class="comment">      'Thing shows behaviour.'</span>
<span class="comment">      &gt;&gt;&gt; builder.formatTestCaseName( 'testThatThingShowsBehaviour' )</span>
<span class="comment">      'Thing shows behaviour.'</span>
<span class="comment">      &gt;&gt;&gt; builder.formatTestCaseName( 'myPrefix_testThatThingShowsBehaviour' )</span>
<span class="comment">      'myPrefix: Thing shows behaviour.'</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      match</span><span class="variable">_</span><span class="normal">obj </span><span class="symbol">=</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">search</span><span class="symbol">(</span><span class="normal"> r</span><span class="string">'(?P&lt;prefix&gt;\w*?)[tT]est(That)?(?P&lt;name&gt;\w+)'</span><span class="symbol">,</span><span class="normal"> test</span><span class="variable">CaseName</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      name </span><span class="symbol">=</span><span class="normal"> match</span><span class="variable">_</span><span class="normal">obj</span><span class="symbol">.</span><span class="function">group</span><span class="symbol">(</span><span class="string">'name'</span><span class="symbol">)</span>
<span class="normal">      prefix </span><span class="symbol">=</span><span class="normal"> match</span><span class="variable">_</span><span class="normal">obj</span><span class="symbol">.</span><span class="function">group</span><span class="symbol">(</span><span class="string">'prefix'</span><span class="symbol">)</span><span class="symbol">.</span><span class="function">rstrip</span><span class="symbol">(</span><span class="string">'_'</span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="function">len</span><span class="symbol">(</span><span class="normal">prefix</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">         fmt </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'{prefix}: {name}.'</span>
<span class="normal">      </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">         fmt </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'{name}.'</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> fmt</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> name</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="function">splitCamelCaseWord</span><span class="symbol">(</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> prefix</span><span class="symbol">=</span><span class="normal">prefix </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">splitCamelCaseWord</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Return text 'ThingShowsBehaviour' as 'Thing shows behaviour'.</span>

<span class="comment">      &gt;&gt;&gt; builder = Builder( sys.stdout )</span>
<span class="comment">      &gt;&gt;&gt; builder.splitCamelCaseWord( 'thingShowsBehaviour' )</span>
<span class="comment">      'Thing shows behaviour'</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> re</span><span class="symbol">.</span><span class="function">sub</span><span class="symbol">(</span><span class="normal"> r</span><span class="string">'([A-Z]|\d+)'</span><span class="symbol">,</span><span class="normal"> r</span><span class="string">' \1'</span><span class="symbol">,</span><span class="normal">text  </span><span class="symbol">)</span><span class="symbol">.</span><span class="function">lstrip</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">.</span><span class="function">capitalize</span><span class="symbol">(</span><span class="symbol">)</span>


<span class="keyword">class</span><span class="normal"> </span><span class="function">PlainTextWriter</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">Builder</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Output presented (sub)suites and testcases as plain text in the following</span>
<span class="comment">   format:</span>

<span class="comment">   Suite1.Subsuite1</span>
<span class="comment">   - thing has behaviour</span>
<span class="comment">   - thing has other behaviour</span>

<span class="comment">   Suite1.Subsuite2</span>
<span class="comment">   - thing has behaviour</span>

<span class="comment">   Tests:</span>
<span class="comment">   ------</span>
<span class="comment">   &gt;&gt;&gt; builder = PlainTextWriter( sys.stdout, Context( title='My Title' ) )</span>
<span class="comment">   My Title</span>
<span class="comment">   &gt;&gt;&gt; builder.enterSuite( 'Suite' )</span>
<span class="comment">   &gt;&gt;&gt; builder.enterSuite( 'Subsuite' )</span>
<span class="comment">   &gt;&gt;&gt; builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )</span>
<span class="comment">   &lt;BLANKLINE&gt;</span>
<span class="comment">   Suite.Subsuite</span>
<span class="comment">   - Add test case behaves as expected.</span>
<span class="comment">   &gt;&gt;&gt; builder.leaveSuite()</span>
<span class="comment">   &gt;&gt;&gt; builder.enterSuite( 'OtherSubsuite' )</span>
<span class="comment">   &gt;&gt;&gt; builder.addTestCase( 'testThatThingShowsBehaviour' )</span>
<span class="comment">   &lt;BLANKLINE&gt;</span>
<span class="comment">   Suite.OtherSubsuite</span>
<span class="comment">   - Thing shows behaviour.</span>
<span class="comment">   &gt;&gt;&gt; builder.leaveSuite()</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> context</span><span class="symbol">=</span><span class="function">Context</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal">  </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Constructor.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Enter a new test suite level.</span>
<span class="comment">      Allow for doctest code.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name</span><span class="symbol">=</span><span class="variable">None</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Leave a test suite level.</span>
<span class="comment">      Allow for doctest code.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Add a test case name. If it's the first of a suite, first write</span>
<span class="comment">      suite name terminated with newline.</span>

<span class="comment">      &gt;&gt;&gt; builder = PlainTextWriter( sys.stdout )</span>
<span class="comment">      &gt;&gt;&gt; builder.enterSuite( 'Suite' )</span>
<span class="comment">      &gt;&gt;&gt; builder.enterSuite( 'Subsuite' )</span>
<span class="comment">      &gt;&gt;&gt; builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )</span>
<span class="comment">      &lt;BLANKLINE&gt;</span>
<span class="comment">      Suite.Subsuite</span>
<span class="comment">      - Add test case behaves as expected.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeLeader</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print the report's leader: title.</span><span class="comment">"""</span>
<span class="normal">      title </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="function">formatTitle</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> title</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'{title}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> title</span><span class="symbol">=</span><span class="normal">title </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTrailer</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print the report's trailer: none.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeSuiteName</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print newline followed by hierarchical suite name.</span>

<span class="comment">      &gt;&gt;&gt; builder = PlainTextWriter( sys.stdout )</span>
<span class="comment">      &gt;&gt;&gt; builder.enterSuite( 'Suite' )</span>
<span class="comment">      &gt;&gt;&gt; builder.enterSuite( 'Subsuite' )</span>
<span class="comment">      &gt;&gt;&gt; builder.writeSuiteName()</span>
<span class="comment">      &lt;BLANKLINE&gt;</span>
<span class="comment">      Suite.Subsuite</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'\n{name}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> name</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="function">formatTestSuiteName</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTestCaseName</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print testThatThingShowsBehaviour as '- thing shows behaviour'</span>

<span class="comment">      &gt;&gt;&gt; builder = PlainTextWriter( sys.stdout )</span>
<span class="comment">      &gt;&gt;&gt; builder.writeTestCaseName( 'testThatThingShowsBehaviour' )</span>
<span class="comment">      - Thing shows behaviour.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'- {text}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> text</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="function">formatTestCaseName</span><span class="symbol">(</span><span class="normal">text</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>



<span class="keyword">class</span><span class="normal"> </span><span class="function">SimpleHtmlWriter</span><span class="symbol">(</span><span class="normal"> </span><span class="variable">Builder</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Output results as HTML.</span>

<span class="comment">   Tests:</span>
<span class="comment">   ------</span>
<span class="comment">   &gt;&gt;&gt; builder = SimpleHtmlWriter( sys.stdout, Context( title='My Title' ) )</span>
<span class="comment">   &lt;html&gt;</span>
<span class="comment">   &lt;head&gt;</span>
<span class="comment">   &lt;title&gt;My Title&lt;/title&gt;</span>
<span class="comment">   &lt;/head&gt;</span>
<span class="comment">   &lt;body&gt;</span>
<span class="comment">   &lt;h1 class="tdx_title"&gt;My Title&lt;/h1&gt;</span>
<span class="comment">   &gt;&gt;&gt; builder.enterSuite( 'Suite' )</span>
<span class="comment">   &gt;&gt;&gt; builder.enterSuite( 'Subsuite' )</span>
<span class="comment">   &gt;&gt;&gt; builder.addTestCase( 'testThatAddTestCaseBehavesAsExpected' )</span>
<span class="comment">   &lt;/ul&gt;</span>
<span class="comment">   &lt;h2 class="tdx_testsuite"&gt;Suite.Subsuite&lt;/h2&gt;&lt;ul class="tdx_testcase"&gt;</span>
<span class="comment">   &lt;li&gt;Add test case behaves as expected.&lt;/li&gt;</span>
<span class="comment">   &gt;&gt;&gt; del builder</span>
<span class="comment">   &lt;/ul&gt;</span>
<span class="comment">   &lt;/body&gt;</span>
<span class="comment">   &lt;/html&gt;</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   css</span><span class="variable">_</span><span class="normal">title</span><span class="variable">_</span><span class="keyword">class</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'tdx_title'</span>
<span class="normal">   css</span><span class="variable">_</span><span class="normal">testsuite</span><span class="variable">_</span><span class="keyword">class</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'tdx_testsuite'</span>
<span class="normal">   css</span><span class="variable">_</span><span class="normal">testcase</span><span class="variable">_</span><span class="keyword">class</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'tdx_testcase'</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> context</span><span class="symbol">=</span><span class="function">Context</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Constructor.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">__init__</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> f</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">__del__</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Destructor.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">__del__</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Enter a new test suite level.</span>
<span class="comment">      Allow for doctest code.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">enterSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name</span><span class="symbol">=</span><span class="variable">None</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Leave a test suite level.</span>
<span class="comment">      Allow for doctest code.</span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">leaveSuite</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Add a test case name. If it's the first of a suite, first print</span>
<span class="comment">      suite name terminated with newline.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="variable">Builder</span><span class="symbol">.</span><span class="function">addTestCase</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> name </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeLeader</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print the report's leader: HTML structure with title.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="keyword">not</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">context</span><span class="symbol">.</span><span class="normal">htmlbodyonly</span><span class="symbol">:</span>
<span class="normal">         title </span><span class="symbol">=</span><span class="normal"> self</span><span class="symbol">.</span><span class="function">formatTitle</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;html&gt;\n&lt;head&gt;'</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> title</span><span class="symbol">:</span>
<span class="normal">            </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;title&gt;{title}&lt;/title&gt;'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> title</span><span class="symbol">=</span><span class="normal">title </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;/head&gt;\n&lt;body&gt;'</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> title</span><span class="symbol">:</span>
<span class="normal">            </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;h1 class="{css_title}"&gt;{title}&lt;/h1&gt;'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span>
<span class="normal">               css</span><span class="variable">_</span><span class="normal">title</span><span class="symbol">=</span><span class="variable">SimpleHtmlWriter</span><span class="symbol">.</span><span class="normal">css</span><span class="variable">_</span><span class="normal">title</span><span class="variable">_</span><span class="keyword">class</span><span class="symbol">,</span><span class="normal"> title</span><span class="symbol">=</span><span class="normal">title </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTrailer</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print the report's trailer: finish HTML document.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> self</span><span class="symbol">.</span><span class="function">testSuiteCount</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&gt;</span><span class="normal"> </span><span class="number">0</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;/ul&gt;'</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="keyword">not</span><span class="normal"> self</span><span class="symbol">.</span><span class="normal">context</span><span class="symbol">.</span><span class="normal">htmlbodyonly</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;/body&gt;\n&lt;/html&gt;'</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeSuiteName</span><span class="symbol">(</span><span class="normal"> self </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print newline followed by hierarchical suite name.</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> self</span><span class="symbol">.</span><span class="function">testSuiteCount</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&gt;</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;/ul&gt;'</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;h2 class="{css_suite}"&gt;{suite_name}&lt;/h2&gt;&lt;ul class="{css_testcase}"&gt;'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span>
<span class="normal">         css</span><span class="variable">_</span><span class="normal">suite</span><span class="symbol">=</span><span class="variable">SimpleHtmlWriter</span><span class="symbol">.</span><span class="normal">css</span><span class="variable">_</span><span class="normal">testsuite</span><span class="variable">_</span><span class="keyword">class</span><span class="symbol">,</span>
<span class="normal">         css</span><span class="variable">_</span><span class="normal">testcase</span><span class="symbol">=</span><span class="variable">SimpleHtmlWriter</span><span class="symbol">.</span><span class="normal">css</span><span class="variable">_</span><span class="normal">testcase</span><span class="variable">_</span><span class="keyword">class</span><span class="symbol">,</span>
<span class="normal">         suite</span><span class="variable">_</span><span class="normal">name</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="function">formatTestSuiteName</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">def</span><span class="normal"> </span><span class="function">writeTestCaseName</span><span class="symbol">(</span><span class="normal"> self</span><span class="symbol">,</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">      """</span><span class="comment">Print testThatThingShowsBehaviour as '- thing shows behaviour'</span>
<span class="comment">      </span><span class="comment">"""</span>
<span class="normal">      </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'&lt;li&gt;{text}&lt;/li&gt;'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> text</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="function">formatTestCaseName</span><span class="symbol">(</span><span class="normal">text</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> file</span><span class="symbol">=</span><span class="normal">self</span><span class="symbol">.</span><span class="normal">f </span><span class="symbol">)</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">processFileByPath</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">ScannerType</span><span class="symbol">,</span><span class="normal"> builder</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Open file given by path and create scanner on the file, parse the file and build the output.</span><span class="comment">"""</span>
<span class="normal">   with </span><span class="function">open</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">,</span><span class="normal"> </span><span class="string">'r'</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> as f</span><span class="symbol">:</span>
<span class="normal">      scanner </span><span class="symbol">=</span><span class="normal"> </span><span class="function">ScannerType</span><span class="symbol">(</span><span class="normal"> f </span><span class="symbol">)</span>
<span class="normal">      parser </span><span class="symbol">=</span><span class="normal"> </span><span class="function">Parser</span><span class="symbol">(</span><span class="normal"> scanner</span><span class="symbol">,</span><span class="normal"> builder</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>
<span class="normal">      parser</span><span class="symbol">.</span><span class="function">parse</span><span class="symbol">(</span><span class="symbol">)</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">main</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Handle options and process given files.</span>
<span class="comment">   </span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">global</span><span class="normal"> progname</span>
<span class="normal">   progname </span><span class="symbol">=</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">path</span><span class="symbol">.</span><span class="function">basename</span><span class="symbol">(</span><span class="normal"> sys</span><span class="symbol">.</span><span class="normal">argv</span><span class="symbol">[</span><span class="number">0</span><span class="symbol">]</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   parser </span><span class="symbol">=</span><span class="normal"> </span><span class="function">OptionParser</span><span class="symbol">(</span>
<span class="normal">      usage</span><span class="symbol">=</span><span class="string">"Usage: %prog [options] [directory | file...]"</span><span class="symbol">,</span>
<span class="normal">      version</span><span class="symbol">=</span><span class="string">"%prog  {ver} {state}  ({date})"</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> ver</span><span class="symbol">=</span><span class="function">versionString</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> state</span><span class="symbol">=</span><span class="function">versionState</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> date</span><span class="symbol">=</span><span class="function">versionDate</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">,</span>
<span class="normal">      description</span><span class="symbol">=</span><span class="variable">_</span><span class="variable">_</span><span class="normal">doc</span><span class="variable">_</span><span class="variable">_</span><span class="normal">  </span><span class="symbol">)</span>

<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">   </span><span class="string">"-d"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> </span><span class="string">"--debug"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_true"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"debug"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"show debug messages"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">   </span><span class="string">"-v"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> </span><span class="string">"--verbose"</span><span class="normal">  </span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_true"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"verbose"</span><span class="normal">  </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"show more messages"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">   </span><span class="string">"-q"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> </span><span class="string">"--quiet"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_true"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"quiet"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"show less messages"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="comment">#</span><span class="comment">   parser.add_option(           "--logging"  , metavar="LEVEL"      , dest="logging"  , default="warning", help="logging level: debug,info,error,critical [warning]" )</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">   </span><span class="string">"-t"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> </span><span class="string">"--selftest"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_true"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"selftest"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"perform selftest; can also use option -v"</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--title"</span><span class="normal">       </span><span class="symbol">,</span><span class="normal"> metavar</span><span class="symbol">=</span><span class="string">"title"</span><span class="normal">      </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"title"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"specify title for report [none]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--framework"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> metavar</span><span class="symbol">=</span><span class="string">"fw"</span><span class="normal">         </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"framework"</span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"select test framework: Boost.Test, CppUnit [Boost.Test]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--format"</span><span class="normal">      </span><span class="symbol">,</span><span class="normal"> metavar</span><span class="symbol">=</span><span class="string">"format"</span><span class="normal">     </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"format"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"select output format: html, text [text]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--glob"</span><span class="normal">        </span><span class="symbol">,</span><span class="normal"> metavar</span><span class="symbol">=</span><span class="string">"pattern"</span><span class="normal">    </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"glob"</span><span class="normal">     </span><span class="symbol">,</span><span class="normal"> default</span><span class="symbol">=</span><span class="string">"*.cpp|*.h"</span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"filename pattern to use with directories [*.cpp|*.h]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--depth"</span><span class="normal">       </span><span class="symbol">,</span><span class="normal"> metavar</span><span class="symbol">=</span><span class="string">"n"</span><span class="normal">          </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"depth"</span><span class="symbol">,</span><span class="normal"> type</span><span class="symbol">=</span><span class="string">'int'</span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"directory recursion depth, norecurse is 1 [recurse]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--norecurse"</span><span class="normal">   </span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_const"</span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"depth"</span><span class="symbol">,</span><span class="normal"> const</span><span class="symbol">=</span><span class="number">1</span><span class="normal">   </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"prevent visiting subdirectories [no]"</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">   parser</span><span class="symbol">.</span><span class="function">add_option</span><span class="symbol">(</span><span class="normal">         </span><span class="string">"--htmlbodyonly"</span><span class="symbol">,</span><span class="normal">  action</span><span class="symbol">=</span><span class="string">"store_true"</span><span class="normal"> </span><span class="symbol">,</span><span class="normal"> dest</span><span class="symbol">=</span><span class="string">"htmlbodyonly"</span><span class="normal">     </span><span class="symbol">,</span><span class="normal"> help</span><span class="symbol">=</span><span class="string">"only generate contents of body tag fragment [no]"</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   </span><span class="symbol">(</span><span class="normal">options</span><span class="symbol">,</span><span class="normal"> args</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> parser</span><span class="symbol">.</span><span class="function">parse_args</span><span class="symbol">(</span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">selftest</span><span class="symbol">:</span>
<span class="normal">      </span><span class="function">exit</span><span class="symbol">(</span><span class="normal"> doctest</span><span class="symbol">.</span><span class="function">testmod</span><span class="symbol">(</span><span class="normal"> verbose</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">verbose </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth </span><span class="symbol">&lt;</span><span class="symbol">&gt;</span><span class="normal"> </span><span class="variable">None</span><span class="normal"> </span><span class="keyword">and</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth </span><span class="symbol">&lt;</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">      parser</span><span class="symbol">.</span><span class="function">error</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"expecting 1 or higher for option --depth, got '{depth}'; try option --help"</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> depth</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">depth</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">htmlbodyonly</span><span class="symbol">:</span>
<span class="normal">       options</span><span class="symbol">.</span><span class="normal">format </span><span class="symbol">=</span><span class="normal"> </span><span class="string">'html'</span>

<span class="normal">   </span><span class="keyword">if</span><span class="normal"> </span><span class="function">len</span><span class="symbol">(</span><span class="normal"> args </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">      parser</span><span class="symbol">.</span><span class="function">error</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"expecting testsuite filename; try option --help"</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">verbose</span><span class="symbol">:</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">try</span><span class="symbol">:</span>
<span class="normal">      maxdepth </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      dircount </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>
<span class="normal">      filecount </span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span>

<span class="normal">      </span><span class="comment">#</span><span class="comment"> select scanner for test framework:</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">framework</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">framework </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'Boost.Test'</span><span class="symbol">:</span>
<span class="normal">            </span><span class="variable">ScannerType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">CppBoostTestScanner</span>
<span class="normal">         </span><span class="keyword">elif</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">framework </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'CppUnit'</span><span class="symbol">:</span>
<span class="normal">            </span><span class="variable">ScannerType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">CppUnitScanner</span>
<span class="normal">         </span><span class="keyword">elif</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">framework </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'GoogleTest'</span><span class="symbol">:</span>
<span class="normal">            </span><span class="variable">ScannerType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">CppGoogleTestScanner</span>
<span class="normal">         </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">            parser</span><span class="symbol">.</span><span class="function">error</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"invalid framework '{fw}' for option --framework, expecting 'Boost.Test', CppUnit, or GoogleTest; try option --help"</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> fw</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">framework</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">         </span><span class="variable">ScannerType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">CppBoostTestScanner</span>

<span class="normal">      </span><span class="comment">#</span><span class="comment"> select output format:</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">format</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">format </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'html'</span><span class="symbol">:</span>
<span class="normal">            </span><span class="variable">BuilderType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">SimpleHtmlWriter</span>
<span class="normal">         </span><span class="keyword">elif</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">format </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">'text'</span><span class="symbol">:</span>
<span class="normal">            </span><span class="variable">BuilderType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">PlainTextWriter</span>
<span class="normal">         </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">            parser</span><span class="symbol">.</span><span class="function">error</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"invalid format '{fmt}' for option --format, expecting 'html' or 'text'; try option --help"</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> fmt</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">format</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">         </span><span class="variable">BuilderType</span><span class="normal"> </span><span class="symbol">=</span><span class="normal"> </span><span class="variable">PlainTextWriter</span>

<span class="normal">      context </span><span class="symbol">=</span><span class="normal"> </span><span class="function">Context</span><span class="symbol">(</span><span class="normal"> title</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">title</span><span class="symbol">,</span><span class="normal"> htmlbodyonly</span><span class="symbol">=</span><span class="normal">options</span><span class="symbol">.</span><span class="normal">htmlbodyonly </span><span class="symbol">)</span>
<span class="normal">      builder </span><span class="symbol">=</span><span class="normal"> </span><span class="function">BuilderType</span><span class="symbol">(</span><span class="normal"> sys</span><span class="symbol">.</span><span class="normal">stdout</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>

<span class="normal">      </span><span class="keyword">for</span><span class="normal"> arg </span><span class="keyword">in</span><span class="normal"> args</span><span class="symbol">:</span>
<span class="normal">         </span><span class="comment">#</span><span class="comment"> directory:</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">path</span><span class="symbol">.</span><span class="function">isdir</span><span class="symbol">(</span><span class="normal"> arg </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">            argroot </span><span class="symbol">=</span><span class="normal"> arg</span>
<span class="normal">            </span><span class="keyword">for</span><span class="normal"> dirpath</span><span class="symbol">,</span><span class="normal"> dirs</span><span class="symbol">,</span><span class="normal"> files </span><span class="keyword">in</span><span class="normal"> os</span><span class="symbol">.</span><span class="function">walk</span><span class="symbol">(</span><span class="normal"> argroot </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">               recdepth </span><span class="symbol">=</span><span class="normal"> </span><span class="function">computeSubDirectoryDistance</span><span class="symbol">(</span><span class="normal"> argroot</span><span class="symbol">,</span><span class="normal"> dirpath </span><span class="symbol">)</span>
<span class="normal">               maxdepth </span><span class="symbol">=</span><span class="normal"> </span><span class="function">max</span><span class="symbol">(</span><span class="normal"> maxdepth</span><span class="symbol">,</span><span class="normal"> recdepth </span><span class="symbol">)</span>
<span class="comment">#</span><span class="comment">               print( 'depth:{d} top:{ar} dirpath:{dp}'.format( d=recdepth, ar=argroot, dp=dirpath) )</span>
<span class="normal">               </span><span class="comment">#</span><span class="comment"> handle --depth=n:</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth </span><span class="keyword">and</span><span class="normal"> recdepth </span><span class="symbol">&gt;</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="keyword">continue</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">debug</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'at recursion depth:{d}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal">d</span><span class="symbol">=</span><span class="normal">recdepth</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">               dircount </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">               </span><span class="keyword">for</span><span class="normal"> pattern </span><span class="keyword">in</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">glob</span><span class="symbol">.</span><span class="function">split</span><span class="symbol">(</span><span class="string">'|'</span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="keyword">for</span><span class="normal"> path </span><span class="keyword">in</span><span class="normal"> glob</span><span class="symbol">.</span><span class="function">glob</span><span class="symbol">(</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">path</span><span class="symbol">.</span><span class="function">join</span><span class="symbol">(</span><span class="normal">dirpath</span><span class="symbol">,</span><span class="normal"> pattern </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">                     </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">verbose</span><span class="symbol">:</span>
<span class="normal">                        </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'{path}:'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">=</span><span class="normal">path </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">                     </span><span class="function">processFileByPath</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">ScannerType</span><span class="symbol">,</span><span class="normal"> builder</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>
<span class="normal">                     filecount </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>
<span class="normal">               </span><span class="comment">#</span><span class="comment"> --norecurse (--depth=1):</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth </span><span class="keyword">and</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">depth </span><span class="symbol">&lt;</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="keyword">break</span>

<span class="normal">         </span><span class="comment">#</span><span class="comment"> filename or wildcard:</span>
<span class="normal">         </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">            dircount </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span><span class="normal">  </span><span class="comment">#</span><span class="comment"> filter out duplicate dirs from args ?</span>
<span class="normal">            </span><span class="keyword">for</span><span class="normal"> path </span><span class="keyword">in</span><span class="normal"> glob</span><span class="symbol">.</span><span class="function">glob</span><span class="symbol">(</span><span class="normal"> arg </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> </span><span class="keyword">not</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">path</span><span class="symbol">.</span><span class="function">isfile</span><span class="symbol">(</span><span class="normal"> path </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="keyword">continue</span>
<span class="normal">               </span><span class="keyword">if</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">verbose</span><span class="symbol">:</span>
<span class="normal">                  </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'{path}:'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">=</span><span class="normal">path </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">               </span><span class="function">processFileByPath</span><span class="symbol">(</span><span class="normal"> path</span><span class="symbol">,</span><span class="normal"> </span><span class="variable">ScannerType</span><span class="symbol">,</span><span class="normal"> builder</span><span class="symbol">,</span><span class="normal"> context </span><span class="symbol">)</span>
<span class="normal">               filecount </span><span class="symbol">+</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span>

<span class="normal">      </span><span class="comment">#</span><span class="comment"> make sure trailer is written now:</span>
<span class="normal">      </span><span class="comment">#</span><span class="comment"> replace with builder.finish(), terminate(), ... ?</span>
<span class="normal">      </span><span class="keyword">del</span><span class="normal"> builder</span>

<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="keyword">not</span><span class="normal"> options</span><span class="symbol">.</span><span class="normal">quiet</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> filecount </span><span class="symbol">&lt;</span><span class="symbol">=</span><span class="normal"> </span><span class="number">0</span><span class="symbol">:</span>
<span class="normal">            </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"no files matched the given file specification(s)."</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">         </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">            </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"processed {dcount} {dirs}, {fcount} {files}."</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span>
<span class="normal">               dcount</span><span class="symbol">=</span><span class="normal">dircount</span><span class="symbol">,</span><span class="normal"> dirs</span><span class="symbol">=</span><span class="function">makePlural</span><span class="symbol">(</span><span class="string">'directory'</span><span class="symbol">,</span><span class="normal"> dircount</span><span class="symbol">)</span><span class="symbol">,</span>
<span class="normal">               fcount</span><span class="symbol">=</span><span class="normal">filecount</span><span class="symbol">,</span><span class="normal"> files</span><span class="symbol">=</span><span class="function">makePlural</span><span class="symbol">(</span><span class="string">'file'</span><span class="symbol">,</span><span class="normal"> filecount</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="normal">   </span><span class="keyword">except</span><span class="normal"> </span><span class="variable">IOError</span><span class="normal"> as detail</span><span class="symbol">:</span>
<span class="normal">      </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"cannot process file '{filename}', {strerror}"</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span>
<span class="normal">                                      filename</span><span class="symbol">=</span><span class="normal">path</span><span class="symbol">,</span><span class="normal"> strerror</span><span class="symbol">=</span><span class="normal">detail </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> </span><span class="number">2</span>
<span class="normal">   </span><span class="keyword">except</span><span class="normal"> </span><span class="variable">Exception</span><span class="normal"> as detail</span><span class="symbol">:</span>
<span class="normal">      </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'{0}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> detail </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> </span><span class="number">2</span>
<span class="normal">   </span><span class="keyword">finally</span><span class="symbol">:</span>
<span class="normal">      </span><span class="keyword">pass</span>

<span class="normal">   </span><span class="keyword">return</span><span class="normal"> </span><span class="number">0</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">computeSubDirectoryDistance</span><span class="symbol">(</span><span class="normal"> fromdir</span><span class="symbol">,</span><span class="normal"> todir </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Compute the subdirectory level of subdir with respect to topdir.</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> </span><span class="number">1</span><span class="normal"> </span><span class="symbol">+</span><span class="normal"> string</span><span class="symbol">.</span><span class="function">count</span><span class="symbol">(</span><span class="normal"> todir</span><span class="symbol">,</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">sep </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">-</span><span class="normal"> string</span><span class="symbol">.</span><span class="function">count</span><span class="symbol">(</span><span class="normal"> fromdir</span><span class="symbol">,</span><span class="normal"> os</span><span class="symbol">.</span><span class="normal">sep </span><span class="symbol">)</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">makePlural</span><span class="symbol">(</span><span class="normal"> text</span><span class="symbol">,</span><span class="normal"> count </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Return text's pural if appropriate: directory (directories), file (files).</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">if</span><span class="normal"> count </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="number">1</span><span class="symbol">:</span>
<span class="normal">      </span><span class="keyword">return</span><span class="normal"> text</span>
<span class="normal">   </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="string">'y'</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">[</span><span class="symbol">-</span><span class="number">1</span><span class="symbol">]</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">return</span><span class="normal"> text</span><span class="symbol">[</span><span class="symbol">:</span><span class="symbol">-</span><span class="number">1</span><span class="symbol">]</span><span class="normal"> </span><span class="symbol">+</span><span class="normal"> </span><span class="string">'ies'</span>
<span class="normal">      </span><span class="keyword">else</span><span class="symbol">:</span>
<span class="normal">         </span><span class="keyword">return</span><span class="normal"> text </span><span class="symbol">+</span><span class="normal"> </span><span class="string">'s'</span>


<span class="keyword">def</span><span class="normal"> </span><span class="function">message</span><span class="symbol">(</span><span class="normal"> msg </span><span class="symbol">)</span><span class="symbol">:</span>
<span class="comment">   """</span><span class="comment">Issue message.</span><span class="comment">"""</span>
<span class="normal">   </span><span class="keyword">print</span><span class="symbol">(</span><span class="normal"> </span><span class="string">'{prog}: {msg}'</span><span class="symbol">.</span><span class="function">format</span><span class="symbol">(</span><span class="normal"> prog</span><span class="symbol">=</span><span class="normal">progname</span><span class="symbol">,</span><span class="normal"> msg</span><span class="symbol">=</span><span class="normal">msg</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>

<span class="comment">#</span><span class="comment"> ---------------------------------------------------------------------------</span>

<span class="keyword">if</span><span class="normal"> </span><span class="variable">_</span><span class="variable">_</span><span class="normal">name</span><span class="variable">_</span><span class="variable">_</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">"__main__"</span><span class="symbol">:</span>
<span class="normal">   </span><span class="function">main</span><span class="symbol">(</span><span class="symbol">)</span>

<span class="comment">#</span>
<span class="comment">#</span><span class="comment"> end of file</span>
<span class="comment">#</span>
</tt></pre>
