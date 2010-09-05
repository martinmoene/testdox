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
         sentence.append(1, *pos);
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
