//
// cl -EHsc -I%BOOST_ROOT%\include\boost-1_40  main.cpp  testdox_log_formatter.cpp
//
#define BOOST_TEST_MODULE example
#include <boost/test/included/unit_test.hpp>
#include "testdox_log_formatter.hpp"
using namespace boost::unit_test;

//____________________________________________________________________________//

struct MyConfig {

    MyConfig()
    {
       unit_test_log.set_formatter( &formatter );
    }

    ~MyConfig()
    {
    }

    static output::testdox_log_formatter formatter;
};

output::testdox_log_formatter MyConfig::formatter;

BOOST_GLOBAL_FIXTURE( MyConfig );

//____________________________________________________________________________//

BOOST_AUTO_TEST_CASE( testPassingTestReportsX )
{
    BOOST_CHECK( true );
}

BOOST_AUTO_TEST_CASE( testThatFailingTestReportsSpace )
{
    BOOST_CHECK( false );
}

BOOST_AUTO_TEST_CASE( testWarningTestReportsQuestionMarkAndX )
{
    BOOST_WARN( false );
}

class my_exception{};

BOOST_AUTO_TEST_CASE( itShouldReportSpaceWhenItThrows )
{
    BOOST_CHECK_NO_THROW( throw my_exception() );
}

//____________________________________________________________________________//

BOOST_AUTO_TEST_SUITE( MySuiteTest )

BOOST_AUTO_TEST_CASE( passingTestInMySuiteReportsXTest )
{
    BOOST_CHECK( true );
}

BOOST_AUTO_TEST_SUITE_END()

