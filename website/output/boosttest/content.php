<h2 id="testdox">TestDox: example of testdox.py output for Boost.Test</h2>

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
