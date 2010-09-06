//
// testdox_log_formatter.ipp - testdox formatter crafted after compiler_log_formatter
//

#ifndef BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer
#define BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer

// Boost.Test
#include "testdox_log_formatter.hpp"
//#include <boost/test/output/testdox_log_formatter.hpp>
#include <boost/test/unit_test_suite_impl.hpp>
#include <boost/test/framework.hpp>
#include <boost/test/utils/basic_cstring/io.hpp>
#include <boost/test/utils/lazy_ostream.hpp>

// Boost
#include <boost/version.hpp>

// STL
#include <iostream>

#include <boost/test/detail/suppress_warnings.hpp>

//____________________________________________________________________________//

namespace boost {

namespace unit_test {

namespace output {

namespace {

inline std::string
strip_left( std::string text, std::string to_strip )
{
    if ( 0 == text.find( to_strip ) )
    {
       text.erase( 0, to_strip.length() );
    }

   return text;
}

inline std::string
strip_right( std::string text, std::string to_strip )
{
    std::size_t pos = text.find( to_strip );

    if ( pos + to_strip.length() == text.length() )
    {
       text.erase( pos, to_strip.length() );
    }

    return text;
}

} // local, anonymous namespace

// ************************************************************************** //
// **************            testdox_log_formatter             ************** //
// ************************************************************************** //

// weakness: must specify term that is prefix of another term after the latter.

testdox_log_formatter::testdox_log_formatter()
: m_testname_prefixes( "itShould|testThat|test|")
, m_testname_postfixes( "Tests|Test")
{
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_start( std::ostream& output, counter_t test_cases_amount )
{
    if( test_cases_amount > 0 )
        output  << "Running " << test_cases_amount << " test "
                << (test_cases_amount > 1 ? "cases" : "case") << "...\n";
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_finish( std::ostream& ostr )
{
    ostr.flush();
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_build_info( std::ostream& output )
{
    output  << "Platform: " << BOOST_PLATFORM            << '\n'
            << "Compiler: " << BOOST_COMPILER            << '\n'
            << "STL     : " << BOOST_STDLIB              << '\n'
            << "Boost   : " << BOOST_VERSION/100000      << "."
                            << BOOST_VERSION/100 % 1000  << "."
                            << BOOST_VERSION % 100       << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::test_unit_start( std::ostream& output, test_unit const& tu )
{
    if ( tu.p_type_name.get() == "suite")
    {
        output << std::endl << tu.p_name << std::endl;
    }
}

//____________________________________________________________________________//

void
testdox_log_formatter::test_unit_finish( std::ostream& output, test_unit const& tu, unsigned long elapsed )
{
}

//____________________________________________________________________________//

void
testdox_log_formatter::test_unit_skipped( std::ostream& output, test_unit const& tu )
{
    output  << "Test " << tu.p_type_name << " \"" << tu.p_name << "\"" << "is skipped" << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_exception( std::ostream& output, log_checkpoint_data const& checkpoint_data, const_string explanation )
{
    print_prefix( output, checkpoint_data.m_file_name, checkpoint_data.m_line_num );
    output << "[ ] " << to_sentence( framework::current_test_case().p_name) ;

    output << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_entry_start( std::ostream& output, log_entry_data const& entry_data, log_entry_types let )
{
    switch( let ) {
        case BOOST_UTL_ET_INFO:
        case BOOST_UTL_ET_MESSAGE:
            print_prefix( output, entry_data.m_file_name, entry_data.m_line_num );
            output << "[x] " << to_sentence( framework::current_test_case().p_name );
            break;
        case BOOST_UTL_ET_WARNING:
            print_prefix( output, entry_data.m_file_name, entry_data.m_line_num );
            output << "[?] " << to_sentence( framework::current_test_case().p_name );
            break;
        case BOOST_UTL_ET_ERROR:
        case BOOST_UTL_ET_FATAL_ERROR:
            print_prefix( output, entry_data.m_file_name, entry_data.m_line_num );
            output << "[ ] " << to_sentence( framework::current_test_case().p_name );
            break;
    }
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_entry_value( std::ostream& output, const_string value )
{
//    output << value;
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_entry_value( std::ostream& output, lazy_ostream const& value )
{
//    output << value;
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_entry_finish( std::ostream& output )
{
    output << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::print_prefix( std::ostream& output, const_string file, std::size_t line )
{
    output << " ";
}

//____________________________________________________________________________//

void
testdox_log_formatter::set_testname_prefix( std::string text )
{
    m_testname_prefixes = text;
}

//____________________________________________________________________________//

void
testdox_log_formatter::set_testname_postfix( std::string text )
{
    m_testname_postfixes = text;
}

//____________________________________________________________________________//


std::string
testdox_log_formatter::to_sentence( std::string text )
{
//    for each prefix in m_testname_prefixes:
//        if match prefix in text:
//            strip_left( text, prefix )
//            break;  // oly once
//
//    for each postfix in m_testname_postfixes:
//        if match prefix in text:
//            strip_left( text, prefix )
//            break;  // oly once

   if ( 0 == text.find( "testThat" ) )
   {
      text = strip_left( text, "testThat" );
   }
   else if ( 0 == text.find( "test" ) )
   {
      text = strip_left( text, "test" );
   }

   std::string sentence;
   for ( std::string::const_iterator pos = text.begin(); pos != text.end(); ++pos)
   {
      if ( isupper(*pos) && pos != text.begin() )
      {
         sentence.append( 1, ' ');
      }
      if ( pos == text.begin() )
      {
         sentence.append( 1, toupper(*pos) );
      }
      else
      {
         sentence.append( 1, tolower(*pos) );
      }
   }
   return sentence;
}

//____________________________________________________________________________//

} // namespace output

} // namespace unit_test

} // namespace boost

//____________________________________________________________________________//

#include <boost/test/detail/enable_warnings.hpp>

#endif // BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer
