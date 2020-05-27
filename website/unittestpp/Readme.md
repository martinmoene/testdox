UnitTest++ TestDox reporter customization
-----------------------------------------

### main.cpp:

```C++
#include "unittestpp.h"
#include "TestReporterTestDoxStdout.h"

int main(int, char const *[])
{
   using namespace UnitTest;

   TestReporterTestDoxStdout reporter;
   TestRunner runner(reporter);
   return runner.RunTestsIf(Test::GetTestList(), NULL, True(), 0);
}
```

### TestReporterTestDoxStdout.h:

```C++
#ifndef UNITTEST_TESTREPORTERTESTDOXSTDOUT_H
#define UNITTEST_TESTREPORTERTESTDOXSTDOUT_H

#include "TestReporter.h"
#include <string>

namespace UnitTest {

class TestReporterTestDoxStdout : public TestReporter
{
private:
    virtual void ReportTestStart(TestDetails const& test);
    virtual void ReportFailure(TestDetails const& test, char const* failure);

    virtual void ReportTestFinish(TestDetails const& test, float secondsElapsed);
    virtual void ReportSummary(int totalTestCount, int failedTestCount, int failureCount, float secondsElapsed);

    void ReportTestResult(TestDetails const &test, bool success);

    std::string m_suiteName;
};

}

#endif
```

### TestReporterTestDoxStdout.cpp:

```C++
#include "TestReporterTestDoxStdout.h"
#include <cstdio>

#include "TestDetails.h"

namespace UnitTest {

const char const* to_cstr(std::string const& text)
{
   return text.c_str();
}

std::string splitCamelCaseWord(std::string const& text)
{
   std::string sentence;
   for ( std::string::const_iterator pos = text.begin(); pos != text.end(); ++pos)
   {
      if (isupper(*pos) && pos != text.begin())
      {
         sentence.append(1, ' ');
      }
      if (pos == text.begin())
      {
         sentence.append(1, toupper(*pos));
      }
      else
      {
         sentence.append(1, tolower(*pos));
      }
   }
   return sentence;
}

void TestReporterTestDoxStdout::ReportTestResult(TestDetails const &test, bool success)
{
   if (test.suiteName != m_suiteName)
   {
      m_suiteName = test.suiteName;
      printf("\n%s\n", to_cstr(m_suiteName));
   }
   printf(" [%c] %s\n", success ? 'x':' ', to_cstr(splitCamelCaseWord(test.testName)));
}

void TestReporterTestDoxStdout::ReportFailure(TestDetails const& test, char const* /*failure*/)
{
   ReportTestResult(test, false);
}

void TestReporterTestDoxStdout::ReportTestStart(TestDetails const& /*test*/)
{
}

void TestReporterTestDoxStdout::ReportTestFinish(TestDetails const& test, float)
{
   ReportTestResult(test, true);
}

void TestReporterTestDoxStdout::ReportSummary(int const /*totalTestCount*/, int const /*failedTestCount*/,
                                       int const /*failureCount*/, float /*secondsElapsed*/)
{
   // e.g. as in TestReporterStdout
}

}
```
