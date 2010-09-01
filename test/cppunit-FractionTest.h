// file: cppunit-fractiontest.h
#ifndef FRACTIONTEST_H
#define FRACTIONTEST_H

#include <cppunit/TestFixture.h>
#include <cppunit/extensions/HelperMacros.h>
#include "Fraction.h"

using namespace std;

class Fractiontest : public CPPUNIT_NS :: TestFixture
{
    CPPUNIT_TEST_SUITE (Fractiontest);
    CPPUNIT_TEST (testThatFractionsAddCorrectly);
    CPPUNIT_TEST (testThatFractionsSubtractCorrectly);
    CPPUNIT_TEST (testThatExceptionIsThrownForCondition);
    CPPUNIT_TEST (testThatFractionsCompareCorrectly);
    CPPUNIT_TEST_SUITE_END ();

    public:
        void setUp (void);
        void tearDown (void);

    protected:
        void testThatFractionsAddCorrectly (void);
        void testThatFractionsSubtractCorrectly (void);
        void testThatExceptionIsThrownForCondition (void);
        void testThatFractionsCompareCorrectly (void);

    private:
        Fraction *a, *b, *c, *d, *e, *f, *g, *h;
};

#endif
