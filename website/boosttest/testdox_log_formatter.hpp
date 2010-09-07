//
// testdox_log_formatter.hpp - testdox formatter crafted after compiler_log_formatter
//

#ifndef BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer
#define BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer

// Boost.Test
#include <boost/test/detail/global_typedef.hpp>
#include <boost/test/unit_test_log_formatter.hpp>

#include <boost/test/detail/suppress_warnings.hpp>

// STL
#include <vector>

//____________________________________________________________________________//

namespace boost {

namespace unit_test {

namespace output {

// ************************************************************************** //
// **************             testdox_log_formatter            ************** //
// ************************************************************************** //

class BOOST_TEST_DECL testdox_log_formatter : public unit_test_log_formatter {
public:
    testdox_log_formatter();

    // Formatter interface
    void    log_start( std::ostream&, counter_t test_cases_amount );
    void    log_finish( std::ostream& );
    void    log_build_info( std::ostream& );

    void    test_unit_start( std::ostream&, test_unit const& tu );
    void    test_unit_finish( std::ostream&, test_unit const& tu, unsigned long elapsed );
    void    test_unit_skipped( std::ostream&, test_unit const& tu );

    void    log_exception( std::ostream&, log_checkpoint_data const&, const_string explanation );

    void    log_entry_start( std::ostream&, log_entry_data const&, log_entry_types let );
    void    log_entry_value( std::ostream&, const_string value );
    void    log_entry_value( std::ostream&, lazy_ostream const& value );
    void    log_entry_finish( std::ostream& );

    void    set_testname_prefixes( std::string text );
    void    set_testname_postfixes( std::string text );

protected:
    virtual void    print_prefix( std::ostream&, const_string file, std::size_t line );

/// TODO (Martin#1#): change to const_string / property  ?
    virtual std::string   testdox_log_formatter::to_sentence( std::string text );

private:
/// TODO (Martin#1#): change to const_string / property ?
    typedef std::vector< std::string > prefixes_t;
    typedef prefixes_t postfixes_t;

    prefixes_t m_prefixes;
    postfixes_t m_postfixes;
};

} // namespace output

} // namespace unit_test

} // namespace boost

//____________________________________________________________________________//

#include <boost/test/detail/enable_warnings.hpp>

#endif // BOOST_TEST_TESTDOX_LOG_FORMATTER_HPP_trailer
