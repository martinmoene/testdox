#include "unittestpp.h"
#include "TestReporterTestDoxStdout.h"

int main(int, char const *[])
{
   using namespace UnitTest;

   TestReporterTestDoxStdout reporter;
   TestRunner runner(reporter);
   return runner.RunTestsIf(Test::GetTestList(), NULL, True(), 0);
}
