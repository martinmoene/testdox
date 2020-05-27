<h2 id="testdox">TestDox: example of testdox.py output for CppUnit</h2>

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
