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

//____________________________________________________________________________//

inline std::string
strip_right( std::string text, std::string to_strip )
{
    std::size_t pos = text.rfind( to_strip );

    if ( std::string::npos != pos && pos + to_strip.length() == text.length() )
    {
       text.erase( pos, to_strip.length() );
    }

    return text;
}

//____________________________________________________________________________//

typedef std::string (*strip_function_t)( std::string, std::string );

template < strip_function_t strip >
struct strip_first_match
{
    std::string m_text;
    bool m_done;

    strip_first_match( std::string text )
    : m_text( text )
    , m_done( false )
    {
    }

    void operator()( std::string const& prefix )
    {
      if ( !m_done )
      {
         std::string stripped = strip( m_text, prefix );
         if ( ( m_done = (stripped != m_text) ) )
         {
            m_text = stripped;
         }
      }
    }

    operator std::string() const
    {
       return m_text;
    }
};

typedef strip_first_match< strip_left  > strip_left_first_match;
typedef strip_first_match< strip_right > strip_right_first_match;

} // local, anonymous namespace

// ************************************************************************** //
// **************            testdox_log_formatter             ************** //
// ************************************************************************** //

testdox_log_formatter::testdox_log_formatter()
{
    set_name_prefixes ( "test|testThat|itShould" );
    set_name_postfixes( "Test|Tests" );
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
        output << std::endl << strip_postfix( tu.p_name ) << std::endl;
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
    output << " [ ] " << to_sentence( framework::current_test_case().p_name ) << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::log_entry_start( std::ostream& output, log_entry_data const& entry_data, log_entry_types let )
{
    std::string sentence = to_sentence( framework::current_test_case().p_name );

    switch( let )
    {
        case BOOST_UTL_ET_INFO:
            output << " [x] " << sentence << std::endl;
            break;
        case BOOST_UTL_ET_MESSAGE:
            break;
        case BOOST_UTL_ET_WARNING:
            output << " [?] " << sentence << std::endl;
            break;
        case BOOST_UTL_ET_ERROR:
        case BOOST_UTL_ET_FATAL_ERROR:
            output << " [ ] " << sentence << std::endl;
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
//    output << std::endl;
}

//____________________________________________________________________________//

void
testdox_log_formatter::print_prefix( std::ostream& output, const_string file, std::size_t line )
{
//    output << " ";
}

//____________________________________________________________________________//

void
testdox_log_formatter::set_name_prefixes( std::string text )
{
// TODO (moene#1#): Implement string-to-vector transformation
    m_prefixes.clear();
    m_prefixes.push_back( "test" );
    m_prefixes.push_back( "testThat" );
    m_prefixes.push_back( "itShould" );

    // reverse sort to first use longest prefixes that have a common begin
    std::sort( m_prefixes.rbegin(), m_prefixes.rend() );
}

//____________________________________________________________________________//

void
testdox_log_formatter::set_name_postfixes( std::string text )
{
// TODO (moene#1#): Implement string-to-vector transformation
    m_postfixes.clear();
    m_postfixes.push_back( "Test" );
    m_postfixes.push_back( "Tests" );

    // reverse sort to first use longest postfixes that have a common begin
    std::sort( m_postfixes.rbegin(), m_postfixes.rend() );
}

//____________________________________________________________________________//

std::string
testdox_log_formatter::strip_prefix( std::string const& text )
{
// TODO (moene#1#): Weakness: This visits all prefixes even if a match was already found
// TODO (moene#1#): Future: use std::(tr1::)regex (non-header-only!) ?

    return std::for_each(
        m_prefixes.begin(), m_prefixes.end(),
        strip_left_first_match( text ) );
}

//____________________________________________________________________________//

std::string
testdox_log_formatter::strip_postfix( std::string const& text )
{
// TODO (moene#1#): Weakness: This visits all postfixes even if a match was already found
// TODO (moene#1#): Future: use std::(tr1::)regex (non-header-only!) ?
    return std::for_each(
        m_postfixes.begin(), m_postfixes.end(),
        strip_right_first_match( text ) );
}

//____________________________________________________________________________//

std::string
testdox_log_formatter::camelcase_to_sentence( std::string const& text )
{
// TODO (moene#1#): Use std::copy() with insert iterator ?
// TODO (moene#1#): Handle _: a123_bcde, a123_Bcde; produce single space

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

std::string
testdox_log_formatter::to_sentence( std::string const& text )
{
    return camelcase_to_sentence( strip_prefix( strip_postfix( text ) ) );
}

//____________________________________________________________________________//

} // namespace output

} // namespace unit_test

} // namespace boost

//____________________________________________________________________________//

#include <boost/test/detail/enable_warnings.hpp>

#endif // BOOST_TEST_TESTDOX_LOG_FORMATTER_IPP_trailer
