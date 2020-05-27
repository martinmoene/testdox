<h2>UnitTest++ TestDox reporter customization</h2>  
<h3>main.cpp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="preproc">#include</span><span class="normal"> </span><span class="string">"unittestpp.h"</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">"TestReporterTestDoxStdout.h"</span>

<span class="type">int</span><span class="normal"> </span><span class="function">main</span><span class="symbol">(</span><span class="type">int</span><span class="symbol">,</span><span class="normal"> </span><span class="type">char</span><span class="normal"> </span><span class="keyword">const</span><span class="normal"> </span><span class="symbol">*</span><span class="symbol">[</span><span class="symbol">]</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="keyword">using</span><span class="normal"> </span><span class="keyword">namespace</span><span class="normal"> UnitTest</span><span class="symbol">;</span>

<span class="normal">   TestReporterTestDoxStdout reporter</span><span class="symbol">;</span>
<span class="normal">   TestRunner </span><span class="function">runner</span><span class="symbol">(</span><span class="normal">reporter</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> runner</span><span class="symbol">.</span><span class="function">RunTestsIf</span><span class="symbol">(</span><span class="normal">Test</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">GetTestList</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> NULL</span><span class="symbol">,</span><span class="normal"> </span><span class="function">True</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">,</span><span class="normal"> </span><span class="number">0</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>
</tt></pre>
<h3>TestReporterTestDoxStdout.h:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="preproc">#ifndef</span><span class="normal"> UNITTEST_TESTREPORTERTESTDOXSTDOUT_H</span>
<span class="preproc">#define</span><span class="normal"> UNITTEST_TESTREPORTERTESTDOXSTDOUT_H</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">"TestReporter.h"</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;string&gt;</span>

<span class="keyword">namespace</span><span class="normal"> UnitTest </span><span class="cbracket">{</span>

<span class="keyword">class</span><span class="normal"> TestReporterTestDoxStdout </span><span class="symbol">:</span><span class="normal"> </span><span class="keyword">public</span><span class="normal"> TestReporter</span>
<span class="cbracket">{</span>
<span class="keyword">private</span><span class="symbol">:</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> </span><span class="type">void</span><span class="normal"> </span><span class="function">ReportTestStart</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> test</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> </span><span class="type">void</span><span class="normal"> </span><span class="function">ReportFailure</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">char</span><span class="normal"> </span><span class="keyword">const</span><span class="symbol">*</span><span class="normal"> failure</span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> </span><span class="type">void</span><span class="normal"> </span><span class="function">ReportTestFinish</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">float</span><span class="normal"> secondsElapsed</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">    </span><span class="keyword">virtual</span><span class="normal"> </span><span class="type">void</span><span class="normal"> </span><span class="function">ReportSummary</span><span class="symbol">(</span><span class="type">int</span><span class="normal"> totalTestCount</span><span class="symbol">,</span><span class="normal"> </span><span class="type">int</span><span class="normal"> failedTestCount</span><span class="symbol">,</span><span class="normal"> </span><span class="type">int</span><span class="normal"> failureCount</span><span class="symbol">,</span><span class="normal"> </span><span class="type">float</span><span class="normal"> secondsElapsed</span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    </span><span class="type">void</span><span class="normal"> </span><span class="function">ReportTestResult</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="normal"> </span><span class="symbol">&amp;</span><span class="normal">test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">bool</span><span class="normal"> success</span><span class="symbol">)</span><span class="symbol">;</span>

<span class="normal">    std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string m_suiteName</span><span class="symbol">;</span>
<span class="cbracket">}</span><span class="symbol">;</span>

<span class="cbracket">}</span>

<span class="preproc">#endif</span>
</tt></pre>
<h3>TestReporterTestDoxStdout.cpp:</h3>  
<!-- Generator: GNU source-highlight 2.1.2
by Lorenzo Bettini
http://www.lorenzobettini.it
http://www.gnu.org/software/src-highlite -->
<pre><tt><span class="preproc">#include</span><span class="normal"> </span><span class="string">"TestReporterTestDoxStdout.h"</span>
<span class="preproc">#include</span><span class="normal"> </span><span class="string">&lt;cstdio&gt;</span>

<span class="preproc">#include</span><span class="normal"> </span><span class="string">"TestDetails.h"</span>

<span class="keyword">namespace</span><span class="normal"> UnitTest </span><span class="cbracket">{</span>

<span class="keyword">const</span><span class="normal"> </span><span class="type">char</span><span class="normal"> </span><span class="keyword">const</span><span class="symbol">*</span><span class="normal"> </span><span class="function">to_cstr</span><span class="symbol">(</span><span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">c_str</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="function">splitCamelCaseWord</span><span class="symbol">(</span><span class="normal">std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> text</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string sentence</span><span class="symbol">;</span>
<span class="normal">   </span><span class="keyword">for</span><span class="normal"> </span><span class="symbol">(</span><span class="normal"> std</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">string</span><span class="symbol">:</span><span class="symbol">:</span><span class="normal">const_iterator pos </span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span><span class="normal"> pos </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">end</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">;</span><span class="normal"> </span><span class="symbol">+</span><span class="symbol">+</span><span class="normal">pos</span><span class="symbol">)</span>
<span class="normal">   </span><span class="cbracket">{</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="function">isupper</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="normal"> </span><span class="symbol">&amp;</span><span class="symbol">&amp;</span><span class="normal"> pos </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">)</span>
<span class="normal">      </span><span class="cbracket">{</span>
<span class="normal">         sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="string">' '</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">      </span><span class="cbracket">}</span>
<span class="normal">      </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal">pos </span><span class="symbol">=</span><span class="symbol">=</span><span class="normal"> text</span><span class="symbol">.</span><span class="function">begin</span><span class="symbol">(</span><span class="symbol">)</span><span class="symbol">)</span>
<span class="normal">      </span><span class="cbracket">{</span>
<span class="normal">         sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="function">toupper</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">      </span><span class="cbracket">}</span>
<span class="normal">      </span><span class="keyword">else</span>
<span class="normal">      </span><span class="cbracket">{</span>
<span class="normal">         sentence</span><span class="symbol">.</span><span class="function">append</span><span class="symbol">(</span><span class="number">1</span><span class="symbol">,</span><span class="normal"> </span><span class="function">tolower</span><span class="symbol">(</span><span class="symbol">*</span><span class="normal">pos</span><span class="symbol">)</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">      </span><span class="cbracket">}</span>
<span class="normal">   </span><span class="cbracket">}</span>
<span class="normal">   </span><span class="keyword">return</span><span class="normal"> sentence</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="type">void</span><span class="normal"> TestReporterTestDoxStdout</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">ReportTestResult</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="normal"> </span><span class="symbol">&amp;</span><span class="normal">test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">bool</span><span class="normal"> success</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="keyword">if</span><span class="normal"> </span><span class="symbol">(</span><span class="normal">test</span><span class="symbol">.</span><span class="normal">suiteName </span><span class="symbol">!</span><span class="symbol">=</span><span class="normal"> m_suiteName</span><span class="symbol">)</span>
<span class="normal">   </span><span class="cbracket">{</span>
<span class="normal">      m_suiteName </span><span class="symbol">=</span><span class="normal"> test</span><span class="symbol">.</span><span class="normal">suiteName</span><span class="symbol">;</span>
<span class="normal">      </span><span class="function">printf</span><span class="symbol">(</span><span class="string">"\n%s\n"</span><span class="symbol">,</span><span class="normal"> </span><span class="function">to_cstr</span><span class="symbol">(</span><span class="normal">m_suiteName</span><span class="symbol">)</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="normal">   </span><span class="cbracket">}</span>
<span class="normal">   </span><span class="function">printf</span><span class="symbol">(</span><span class="string">" [%c] %s\n"</span><span class="symbol">,</span><span class="normal"> success </span><span class="symbol">?</span><span class="normal"> </span><span class="string">'x'</span><span class="symbol">:</span><span class="string">' '</span><span class="symbol">,</span><span class="normal"> </span><span class="function">to_cstr</span><span class="symbol">(</span><span class="function">splitCamelCaseWord</span><span class="symbol">(</span><span class="normal">test</span><span class="symbol">.</span><span class="normal">testName</span><span class="symbol">)</span><span class="symbol">)</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="type">void</span><span class="normal"> TestReporterTestDoxStdout</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">ReportFailure</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">char</span><span class="normal"> </span><span class="keyword">const</span><span class="symbol">*</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">failure</span><span class="comment">*/</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="function">ReportTestResult</span><span class="symbol">(</span><span class="normal">test</span><span class="symbol">,</span><span class="normal"> </span><span class="keyword">false</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="type">void</span><span class="normal"> TestReporterTestDoxStdout</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">ReportTestStart</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">test</span><span class="comment">*/</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="cbracket">}</span>

<span class="type">void</span><span class="normal"> TestReporterTestDoxStdout</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">ReportTestFinish</span><span class="symbol">(</span><span class="normal">TestDetails </span><span class="keyword">const</span><span class="symbol">&amp;</span><span class="normal"> test</span><span class="symbol">,</span><span class="normal"> </span><span class="type">float</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="function">ReportTestResult</span><span class="symbol">(</span><span class="normal">test</span><span class="symbol">,</span><span class="normal"> </span><span class="keyword">true</span><span class="symbol">)</span><span class="symbol">;</span>
<span class="cbracket">}</span>

<span class="type">void</span><span class="normal"> TestReporterTestDoxStdout</span><span class="symbol">:</span><span class="symbol">:</span><span class="function">ReportSummary</span><span class="symbol">(</span><span class="type">int</span><span class="normal"> </span><span class="keyword">const</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">totalTestCount</span><span class="comment">*/</span><span class="symbol">,</span><span class="normal"> </span><span class="type">int</span><span class="normal"> </span><span class="keyword">const</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">failedTestCount</span><span class="comment">*/</span><span class="symbol">,</span>
<span class="normal">                                       </span><span class="type">int</span><span class="normal"> </span><span class="keyword">const</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">failureCount</span><span class="comment">*/</span><span class="symbol">,</span><span class="normal"> </span><span class="type">float</span><span class="normal"> </span><span class="comment">/*</span><span class="comment">secondsElapsed</span><span class="comment">*/</span><span class="symbol">)</span>
<span class="cbracket">{</span>
<span class="normal">   </span><span class="comment">//</span><span class="comment"> e.g. as in TestReporterStdout</span>
<span class="cbracket">}</span>

<span class="cbracket">}</span>
</tt></pre>
