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
