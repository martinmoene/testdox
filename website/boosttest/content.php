<h2>Boost.Test TestDox reporter customization</h2>  
<h3>output:</h3>  
<pre>    
prompt>main.exe --log_level=all

Running 5 test cases...

example
 [x] Passing test reports x
 [ ] Failing test reports space
 [?] Warning test reports question mark
 [ ] Report space when it throws

MySuite
 [x] Passing test in my suite reports x

*** 2 failures detected in test suite "example"
</pre>   
<h3>main.cpp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="comment">//</span>
<span class="comment">//</span><span class="comment"> cl -EHsc -I%BOOST_ROOT%\include\boost-1_40  main.cpp  testdox_log_formatter.cpp</span>
<span class="comment">//</span>
<span class="preproc">#define</span><span class="normal"> BOOST_TEST_MODULE example</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/included/unit_test.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">"testdox_log_formatter.hpp"</span>
<span class="keyword">using</span><span class="normal"> </span><span class="keyword">namespace</span><span class="normal"> boost</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">unit_test</span><span class="symbol">;</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="keyword">struct</span><span class="normal"> MyConfig </span><span class="cbracket">{</span>

<span class="normal">    </span><span class="function">MyConfig</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">       unit_test_log</span><span class="symbol">.</span><span class="function">set_formatter</span><span class="symbol">(</span><span class="normal"> </span><span class="symbol">&amp;</span><span class="normal">formatter </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">    </span><span class="symbol">~</span><span class="function">MyConfig</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">    </span><span class="keyword">static</span><span class="normal"> output</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">testdox_log_formatter formatter</span><span class="symbol">;</span>
<span class="cbracket">}</span><span class="symbol">;</span>

<span class="normal">output</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">testdox_log_formatter MyConfig</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">formatter</span><span class="symbol">;</span>

<span class="function">BOOST_GLOBAL_FIXTURE</span><span class="symbol">(</span><span class="normal"> MyConfig </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testPassingTestReportsX </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">BOOST_CHECK</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">true</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testThatFailingTestReportsSpace </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">BOOST_CHECK</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">false</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> testWarningTestReportsQuestionMark </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">BOOST_WARN</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">false</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="keyword">class</span><span class="normal"> my_exception</span><span class="cbracket">{</span><span class="cbracket">}</span><span class="symbol">;</span>

<span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> itShouldReportSpaceWhenItThrows </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">BOOST_CHECK_NO_THROW</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">throw</span><span class="normal"> </span><span class="function">my_exception</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="function">BOOST_AUTO_TEST_SUITE</span><span class="symbol">(</span><span class="normal"> MySuiteTests </span><span class="symbol">)</span>

<span class="function">BOOST_AUTO_TEST_CASE</span><span class="symbol">(</span><span class="normal"> passingTestInMySuiteReportsXTest </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">BOOST_CHECK</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">true</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="function">BOOST_AUTO_TEST_SUITE_END</span><span class="symbol">(</span><span class="symbol">)</span>

</tt></pre>
<h3>testdox_log_formatter.hpp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="comment">//</span>
<span class="comment">//</span><span class="comment"> testdox_log_formatter.hpp - testdox formatter crafted after compiler_log_formatter</span>
<span class="comment">//</span>

<span class="preproc">#ifndef</span><span class="normal"> BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer</span>
<span class="preproc">#define</span><span class="normal"> BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer</span>

<span class="comment">//</span><span class="comment"> Boost.Test</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/detail/global_typedef.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/unit_test_log_formatter.hpp&gt;</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/detail/suppress_warnings.hpp&gt;</span>

<span class="comment">//</span><span class="comment"> STL</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;vector&gt;</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="keyword">namespace</span><span class="normal"> boost </span><span class="cbracket">{</span>

<span class="keyword">namespace</span><span class="normal"> unit_test </span><span class="cbracket">{</span>

<span class="keyword">namespace</span><span class="normal"> output </span><span class="cbracket">{</span>

<span class="comment">//</span><span class="comment"> ************************************************************************** //</span>
<span class="comment">//</span><span class="comment"> **************             testdox_log_formatter            ************** //</span>
<span class="comment">//</span><span class="comment"> ************************************************************************** //</span>

<span class="keyword">class</span><span class="normal"> BOOST_TEST_DECL testdox_log_formatter </span><span class="symbol">:</span><span class="normal"> </span><span class="keyword">public</span><span class="normal"> unit_test_log_formatter </span><span class="cbracket">{</span>
<span class="keyword">public</span><span class="symbol">:</span>
<span class="normal">    </span><span class="function">testdox_log_formatter</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="comment">//</span><span class="comment"> Formatter interface</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> counter_t test_cases_amount </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_build_info</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">test_unit_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">test_unit_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu</span><span class="symbol">,</span><span class="normal"> </span><span class="type">unsigned</span><span class="normal"> </span><span class="type">long</span><span class="normal"> elapsed </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">test_unit_skipped</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_exception</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> log_checkpoint_data </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> const_string explanation </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_entry_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> log_entry_data </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> log_entry_types let </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_entry_value</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> const_string value </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_entry_value</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> lazy_ostream </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> value </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">log_entry_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">set_name_prefixes</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">void</span><span class="normal">    </span><span class="function">set_name_postfixes</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="keyword">protected</span><span class="symbol">:</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> </span><span class="type">void</span><span class="normal">   </span><span class="function">print_prefix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="symbol">,</span><span class="normal"> const_string file</span><span class="symbol">,</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">size_t line </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="comment">//</span><span class="comment">/ TODO (Martin#1#): change to const_string / property  ?</span>
<span class="normal">    </span><span class="keyword">typedef</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">vector</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="symbol">&gt;</span><span class="normal"> strip_terms_t</span><span class="symbol">;</span>

<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string   </span><span class="function">strip_prefix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string   </span><span class="function">strip_postfix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string   </span><span class="function">camelcase_to_sentence</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string   </span><span class="function">to_sentence</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="keyword">private</span><span class="symbol">:</span>
<span class="comment">//</span><span class="comment">/ TODO (Martin#1#): change to const_string / property ?</span>
<span class="normal">    strip_terms_t m_prefixes</span><span class="symbol">;</span>
<span class="normal">    strip_terms_t m_postfixes</span><span class="symbol">;</span>
<span class="cbracket">}</span><span class="symbol">;</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace output</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace unit_test</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace boost</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/detail/enable_warnings.hpp&gt;</span>

<span class="preproc">#endif</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer</span>
</tt></pre>
<h3>testdox_log_formatter.cpp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="comment">//</span>
<span class="comment">//</span><span class="comment"> testdox_log_formatter.cpp - testdox formatter crafted after compiler_log_formatter</span>
<span class="comment">//</span>

<span class="preproc">#define</span><span class="normal"> BOOST_TEST_SOURCE</span>
<span class="comment">//</span><span class="comment">#include &lt;boost/test/impl/compiler_log_formatter.ipp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">"testdox_log_formatter.ipp"</span>

<span class="comment">//</span><span class="comment"> EOF</span>
</tt></pre>
<h3>testdox_log_formatter.ipp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="comment">//</span>
<span class="comment">//</span><span class="comment"> testdox_log_formatter.ipp - testdox formatter crafted after compiler_log_formatter</span>
<span class="comment">//</span>

<span class="preproc">#ifndef</span><span class="normal"> BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer</span>
<span class="preproc">#define</span><span class="normal"> BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer</span>

<span class="comment">//</span><span class="comment"> Boost.Test</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">"testdox_log_formatter.hpp"</span>
<span class="comment">//</span><span class="comment">#include &lt;boost/test/output/testdox_log_formatter.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/unit_test_suite_impl.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/framework.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/utils/basic_cstring/io.hpp&gt;</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/utils/lazy_ostream.hpp&gt;</span>

<span class="comment">//</span><span class="comment"> Boost</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/version.hpp&gt;</span>

<span class="comment">//</span><span class="comment"> STL</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;iostream&gt;</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/detail/suppress_warnings.hpp&gt;</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="keyword">namespace</span><span class="normal"> boost </span><span class="cbracket">{</span>

<span class="keyword">namespace</span><span class="normal"> unit_test </span><span class="cbracket">{</span>

<span class="keyword">namespace</span><span class="normal"> output </span><span class="cbracket">{</span>

<span class="keyword">namespace</span><span class="normal"> </span><span class="cbracket">{</span>

<span class="keyword">inline</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="function">strip_left</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text</span><span class="symbol">,</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string to_strip </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> </span><span class="number">0</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">find</span><span class="symbol">(</span><span class="normal"> to_strip </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">       text</span><span class="symbol">.</span><span class="function">erase</span><span class="symbol">(</span><span class="normal"> </span><span class="number">0</span><span class="symbol">,</span><span class="normal"> to_strip</span><span class="symbol">.</span><span class="function">length</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">   </span><span class="keyword">return</span><span class="normal"> text</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="keyword">inline</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="function">strip_right</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text</span><span class="symbol">,</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string to_strip </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">size_t pos </span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">rfind</span><span class="symbol">(</span><span class="normal"> to_strip </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">npos </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> pos </span><span class="symbol">&amp;</span><span class="symbol">&amp;</span><span class="normal"> pos </span><span class="symbol">+</span><span class="normal"> to_strip</span><span class="symbol">.</span><span class="function">length</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">length</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">       text</span><span class="symbol">.</span><span class="function">erase</span><span class="symbol">(</span><span class="normal"> pos</span><span class="symbol">,</span><span class="normal"> to_strip</span><span class="symbol">.</span><span class="function">length</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">    </span><span class="keyword">return</span><span class="normal"> text</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="keyword">typedef</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">string </span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">strip_function_t</span><span class="symbol">)</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span><span class="symbol">,</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="keyword">template</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="normal"> strip_function_t strip </span><span class="symbol">&gt;</span>
<span class="keyword">struct</span><span class="normal"> strip_first_match</span>
<span class="cbracket">{</span>
<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string m_text</span><span class="symbol">;</span>
<span class="normal">    </span><span class="type">bool</span><span class="normal"> m_done</span><span class="symbol">;</span>

<span class="normal">    </span><span class="function">strip_first_match</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text </span><span class="symbol">)</span>
<span class="normal">    </span><span class="symbol">:</span><span class="normal"> </span><span class="function">m_text</span><span class="symbol">(</span><span class="normal"> text </span><span class="symbol">)</span>
<span class="normal">    </span><span class="symbol">,</span><span class="normal"> </span><span class="function">m_done</span><span class="symbol">(</span><span class="normal"> </span><span class="keyword">false</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">    </span><span class="type">void</span><span class="normal"> </span><span class="keyword">operator</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> prefix </span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> </span><span class="symbol">!</span><span class="normal">m_done </span><span class="symbol">)</span>
<span class="normal">      </span><span class="cbracket">{</span>
<span class="normal">         std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string stripped </span><span class="symbol">=</span><span class="normal"> </span><span class="function">strip</span><span class="symbol">(</span><span class="normal"> m_text</span><span class="symbol">,</span><span class="normal"> prefix </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">         </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> m_done </span><span class="symbol">=</span><span class="normal"> </span><span class="symbol">(</span><span class="normal">stripped </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> m_text</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">         </span><span class="cbracket">{</span>
<span class="normal">            m_text </span><span class="symbol">=</span><span class="normal"> stripped</span><span class="symbol">;</span>
<span class="normal">         </span><span class="cbracket">}</span>
<span class="normal">      </span><span class="cbracket">}</span>
<span class="normal">    </span><span class="cbracket">}</span>

<span class="normal">    </span><span class="keyword">operator</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">string</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="keyword">const</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">       </span><span class="keyword">return</span><span class="normal"> m_text</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>
<span class="cbracket">}</span><span class="symbol">;</span>

<span class="keyword">typedef</span><span class="normal"> strip_first_match</span><span class="symbol">&lt;</span><span class="normal"> strip_left  </span><span class="symbol">&gt;</span><span class="normal"> strip_left_first_match</span><span class="symbol">;</span>
<span class="keyword">typedef</span><span class="normal"> strip_first_match</span><span class="symbol">&lt;</span><span class="normal"> strip_right </span><span class="symbol">&gt;</span><span class="normal"> strip_right_first_match</span><span class="symbol">;</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> local, anonymous namespace</span>

<span class="comment">//</span><span class="comment"> ************************************************************************** //</span>
<span class="comment">//</span><span class="comment"> **************            testdox_log_formatter             ************** //</span>
<span class="comment">//</span><span class="comment"> ************************************************************************** //</span>

<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">testdox_log_formatter</span><span class="symbol">(</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="function">set_name_prefixes </span><span class="symbol">(</span><span class="normal"> </span><span class="string">"test|testThat|itShould"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="function">set_name_postfixes</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"Test|Tests"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> counter_t test_cases_amount </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="keyword">if</span><span class="symbol">(</span><span class="normal"> test_cases_amount </span><span class="symbol">&gt;</span><span class="normal"> </span><span class="number">0</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">        output  </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"Running "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> test_cases_amount </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" test "</span>
<span class="normal">                </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="symbol">(</span><span class="normal">test_cases_amount </span><span class="symbol">&gt;</span><span class="normal"> </span><span class="number">1</span><span class="normal"> </span><span class="symbol">?</span><span class="normal"> </span><span class="string">"cases"</span><span class="normal"> </span><span class="symbol">:</span><span class="normal"> </span><span class="string">"case"</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"...\n"</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> ostr </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    ostr</span><span class="symbol">.</span><span class="function">flush</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_build_info</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    output  </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"Platform: "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_PLATFORM            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">'\n'</span>
<span class="normal">            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"Compiler: "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_COMPILER            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">'\n'</span>
<span class="normal">            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"STL     : "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_STDLIB              </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">'\n'</span>
<span class="normal">            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"Boost   : "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_VERSION</span><span class="symbol">/</span><span class="number">100000</span><span class="normal">      </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"."</span>
<span class="normal">                            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_VERSION</span><span class="symbol">/</span><span class="number">100</span><span class="normal"> </span><span class="symbol">%</span><span class="normal"> </span><span class="number">1000</span><span class="normal">  </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"."</span>
<span class="normal">                            </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> BOOST_VERSION </span><span class="symbol">%</span><span class="normal"> </span><span class="number">100</span><span class="normal">       </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">test_unit_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> tu</span><span class="symbol">.</span><span class="normal">p_type_name</span><span class="symbol">.</span><span class="function">get</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> </span><span class="string">"suite"</span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">        output </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="function">strip_postfix</span><span class="symbol">(</span><span class="normal"> tu</span><span class="symbol">.</span><span class="normal">p_name </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">test_unit_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu</span><span class="symbol">,</span><span class="normal"> </span><span class="type">unsigned</span><span class="normal"> </span><span class="type">long</span><span class="normal"> elapsed </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">test_unit_skipped</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> test_unit </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> tu </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    output  </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"Test "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> tu</span><span class="symbol">.</span><span class="normal">p_type_name </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" \""</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> tu</span><span class="symbol">.</span><span class="normal">p_name </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"\""</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">"is skipped"</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_exception</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> log_checkpoint_data </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> checkpoint_data</span><span class="symbol">,</span><span class="normal"> const_string explanation </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    output </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" [ ] "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="function">to_sentence</span><span class="symbol">(</span><span class="normal"> framework</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">current_test_case</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">.</span><span class="normal">p_name </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_entry_start</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> log_entry_data </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> entry_data</span><span class="symbol">,</span><span class="normal"> log_entry_types let </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string sentence </span><span class="symbol">=</span><span class="normal"> </span><span class="function">to_sentence</span><span class="symbol">(</span><span class="normal"> framework</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">current_test_case</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">.</span><span class="normal">p_name </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="keyword">switch</span><span class="symbol">(</span><span class="normal"> let </span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">        </span><span class="keyword">case</span><span class="normal"> BOOST_UTL_ET_INFO</span><span class="symbol">:</span>
<span class="normal">            output </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" [x] "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> sentence </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="normal">            </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">        </span><span class="keyword">case</span><span class="normal"> BOOST_UTL_ET_MESSAGE</span><span class="symbol">:</span>
<span class="normal">            </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">        </span><span class="keyword">case</span><span class="normal"> BOOST_UTL_ET_WARNING</span><span class="symbol">:</span>
<span class="normal">            output </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" [?] "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> sentence </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="normal">            </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">        </span><span class="keyword">case</span><span class="normal"> BOOST_UTL_ET_ERROR</span><span class="symbol">:</span>
<span class="normal">        </span><span class="keyword">case</span><span class="normal"> BOOST_UTL_ET_FATAL_ERROR</span><span class="symbol">:</span>
<span class="normal">            output </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> </span><span class="string">" [ ] "</span><span class="normal"> </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> sentence </span><span class="symbol">&lt;</span><span class="symbol">&lt;</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">endl</span><span class="symbol">;</span>
<span class="normal">            </span><span class="keyword">break</span><span class="symbol">;</span>
<span class="normal">    </span><span class="cbracket">}</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_entry_value</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> const_string value </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment">    output &lt;&lt; value;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_entry_value</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> lazy_ostream </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> value </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment">    output &lt;&lt; value;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">log_entry_finish</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment">    output &lt;&lt; std::endl;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">print_prefix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">ostream</span><span class="symbol">&amp;</span><span class="normal"> output</span><span class="symbol">,</span><span class="normal"> const_string file</span><span class="symbol">,</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">size_t line </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment">    output &lt;&lt; " ";</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">set_name_prefixes</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Implement string-to-vector transformation</span>
<span class="normal">    m_prefixes</span><span class="symbol">.</span><span class="function">clear</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    m_prefixes</span><span class="symbol">.</span><span class="function">push_back</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"test"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    m_prefixes</span><span class="symbol">.</span><span class="function">push_back</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"testThat"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    m_prefixes</span><span class="symbol">.</span><span class="function">push_back</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"itShould"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="comment">//</span><span class="comment"> reverse sort to first use longest prefixes that have a common begin</span>
<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">sort</span><span class="symbol">(</span><span class="normal"> m_prefixes</span><span class="symbol">.</span><span class="function">rbegin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> m_prefixes</span><span class="symbol">.</span><span class="function">rend</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="type">void</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">set_name_postfixes</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Implement string-to-vector transformation</span>
<span class="normal">    m_postfixes</span><span class="symbol">.</span><span class="function">clear</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    m_postfixes</span><span class="symbol">.</span><span class="function">push_back</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"Test"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    m_postfixes</span><span class="symbol">.</span><span class="function">push_back</span><span class="symbol">(</span><span class="normal"> </span><span class="string">"Tests"</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="comment">//</span><span class="comment"> reverse sort to first use longest postfixes that have a common begin</span>
<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">sort</span><span class="symbol">(</span><span class="normal"> m_postfixes</span><span class="symbol">.</span><span class="function">rbegin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> m_postfixes</span><span class="symbol">.</span><span class="function">rend</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">strip_prefix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Weakness: This visits all prefixes even if a match was already found</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Future: use std::(tr1::)regex (non-header-only!) ?</span>

<span class="normal">    </span><span class="keyword">return</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">for_each</span><span class="symbol">(</span>
<span class="normal">        m_prefixes</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> m_prefixes</span><span class="symbol">.</span><span class="function">end</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span>
<span class="normal">        </span><span class="function">strip_left_first_match</span><span class="symbol">(</span><span class="normal"> text </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">strip_postfix</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Weakness: This visits all postfixes even if a match was already found</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Future: use std::(tr1::)regex (non-header-only!) ?</span>
<span class="normal">    </span><span class="keyword">return</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">for_each</span><span class="symbol">(</span>
<span class="normal">        m_postfixes</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> m_postfixes</span><span class="symbol">.</span><span class="function">end</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span>
<span class="normal">        </span><span class="function">strip_right_first_match</span><span class="symbol">(</span><span class="normal"> text </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">camelcase_to_sentence</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Use std::copy() with insert iterator ?</span>
<span class="comment">//</span><span class="comment"> TODO (moene#1#): Handle _: a123_bcde, a123_Bcde; produce single space</span>

<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string sentence</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">for</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">const_iterator pos </span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span><span class="normal"> pos </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">end</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span><span class="normal"> </span><span class="symbol">+</span><span class="symbol">+</span><span class="normal">pos</span><span class="symbol">)</span>
<span class="normal">    </span><span class="cbracket">{</span>
<span class="normal">        </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> </span><span class="function">isupper</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&amp;</span><span class="symbol">&amp;</span><span class="normal"> pos </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">        </span><span class="cbracket">{</span>
<span class="normal">            sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="normal"> </span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="string">' '</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">        </span><span class="cbracket">}</span>

<span class="normal">        </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> pos </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span>
<span class="normal">        </span><span class="cbracket">{</span>
<span class="normal">            sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="normal"> </span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="function">toupper</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">        </span><span class="cbracket">}</span>
<span class="normal">        </span><span class="keyword">else</span>
<span class="normal">        </span><span class="cbracket">{</span>
<span class="normal">            sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="normal"> </span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="function">tolower</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">        </span><span class="cbracket">}</span>
<span class="normal">    </span><span class="cbracket">}</span>
<span class="normal">    </span><span class="keyword">return</span><span class="normal"> sentence</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span>
<span class="normal">testdox_log_formatter</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">to_sentence</span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text </span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">    </span><span class="keyword">return</span><span class="normal"> </span><span class="function">camelcase_to_sentence</span><span class="symbol">(</span><span class="normal"> </span><span class="function">strip_prefix</span><span class="symbol">(</span><span class="normal"> </span><span class="function">strip_postfix</span><span class="symbol">(</span><span class="normal"> text </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace output</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace unit_test</span>

<span class="cbracket">}</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> namespace boost</span>

<span class="comment">//</span><span class="comment">____________________________________________________________________________//</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;boost/test/detail/enable_warnings.hpp&gt;</span>

<span class="preproc">#endif</span><span class="normal"> </span><span class="comment">//</span><span class="comment"> BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer</span>
</tt></pre>
