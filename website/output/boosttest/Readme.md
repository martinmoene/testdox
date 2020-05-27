TestDox: example of testdox.py output for Boost.Test
----------------------------------------------------

Relevant input:

```Text
prompt>grep BOOST_.*TEST Exception.cpp ScopeGuard.cpp String.cpp
Exception.cpp:BOOST_AUTO_TEST_SUITE( Core )
Exception.cpp:BOOST_AUTO_TEST_SUITE( Exception )
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatSystemExceptionIsCatchedWithCorrectReason, Fixture )
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatSpmNeverGetHereExceptionIsCatchedWithCorrectReason, Fixture )
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatSystemExceptionIsCatchedWithCorrectReasonAndUserErrorCode, Fixture )
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatSystemExceptionIsCatchedWithCorrectArbitraryData, Fixture)
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatSystemExceptionCopyIsCatchedWithCorrectArbitraryData, Fixture )
Exception.cpp:BOOST_FIXTURE_TEST_CASE( testThatExceptionConvertedFromBoostIsCatchedWithCorrectArbitraryData, Fixture )
Exception.cpp:BOOST_AUTO_TEST_SUITE_END() // ExceptionScopeGuard.cpp:BOOST_AUTO_TEST_SUITE( Core )
ScopeGuard.cpp:BOOST_AUTO_TEST_SUITE( ScopeGuard )
ScopeGuard.cpp:BOOST_AUTO_TEST_CASE( testThatGlobalVariableIsClearedOnBlockExit )
ScopeGuard.cpp:BOOST_AUTO_TEST_CASE( testThatLocalVariableIsClearedOnBlockExit )
ScopeGuard.cpp:BOOST_AUTO_TEST_CASE( testThatMemberVariableIsClearedOnBlockExit)
ScopeGuard.cpp:BOOST_AUTO_TEST_SUITE_END() // ScopeGuard
ScopeGuard.cpp:BOOST_AUTO_TEST_SUITE_END() // Core
String.cpp:BOOST_AUTO_TEST_SUITE( Core )
String.cpp:BOOST_AUTO_TEST_SUITE( String )
String.cpp:BOOST_AUTO_TEST_CASE( format_testThatIntIsCorrectlyFormatted )
String.cpp:BOOST_AUTO_TEST_CASE( format_testThatStringIsCorrectlyFormatted )
String.cpp:BOOST_AUTO_TEST_SUITE_END() // String
String.cpp:BOOST_AUTO_TEST_SUITE_END() // Core
```

Result in plain text format:

```Text
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
```
