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

std::string to_sentence( std::string text )
{
   if ( 0 == text.find( "testThat" ) )
   {
      text.erase( 0, 8 );
   }
   else if ( 0 == text.find( "test" ) )
   {
      text.erase( 0, 4 );
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

} // local, anonymous namespace

// ************************************************************************** //
// **************            testdox_log_formatter            ************** //
// ************************************************************************** //

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

} // namespace output

} // namespace unit_test

} // namespace boost

//____________________________________________________________________________//

#include <boost/test/detail/enable_warnings.hpp>

#endif // BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer
