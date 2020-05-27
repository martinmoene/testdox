TestDox: example of testdox.py output for CppUnit
-------------------------------------------------

Relevant input:

```C++
01: // file: cppunit-fractiontest.h
02: #ifndef FRACTIONTEST_H
03: #define FRACTIONTEST_H
04:
05: #include <cppunit/TestFixture.h>
06: #include <cppunit/extensions/HelperMacros.h>
07: #include "Fraction.h"
08:
09: using namespace std;
10:
11: class Fractiontest : public CPPUNIT_NS :: TestFixture
12: {
13:     CPPUNIT_TEST_SUITE (Fractiontest);
14:     CPPUNIT_TEST (testThatFractionsAddCorrectly);
15:     CPPUNIT_TEST (testThatFractionsSubtractCorrectly);
16:     CPPUNIT_TEST (testThatExceptionIsThrownForCondition);
17:     CPPUNIT_TEST (testThatFractionsCompareCorreclty);
18:     CPPUNIT_TEST_SUITE_END ();
19:
20:     public:
21:         void setUp (void);
22:         void tearDown (void);
23:
24:     protected:
25:         void testThatFractionsAddCorrectly (void);
26:         void testThatFractionsSubtractCorrectly (void);
27:         void testThatExceptionIsThrownForCondition (void);
28:         void testThatFractionsCompareCorreclty (void);
29:
30:     private:
31:         Fraction *a, *b, *c, *d, *e, *f, *g, *h;
32: };
33:
34: #endif
```

Result in plain text format:

```Text
prompt>python testdox.py --quiet --framework=CppUnit cppunit-fraction-test.h

Fractiontest
- Fractions add correctly.
- Fractions subtract correctly.
- Exception is thrown for condition.
- Fractions compare correclty.
```
