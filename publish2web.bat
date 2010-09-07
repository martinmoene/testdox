@echo off & setlocal
::
:: publish2web.bat - create highlighted python source and copy files to website.
::

set    progname=%0
set     logfile=%progname%.log

set     webroot=H:\public_html\Home\projects\testdox
set      websrc=%webroot%\src
set   weboutput=%webroot%\output

set    localsrc=website\src
set localoutput=website\output

set   testdox_py=testdox.py
set  testdox_exe=dist\testdox.exe
set  testdox_zip=TestDox-*.zip
set  testdox_hpy=%localsrc%\content.php

set    highlight_py=call website\source-highlight-py.bat
set   highlight_cpp=call website\source-highlight-cpp.bat

if exist %logfile% del %logfile%

if not exist %testdox_exe% (
   echo %progname%: Please first create binary distribution with 'mk dist'.
   goto :EOF
)

if not exist MANIFEST (
   echo %progname%: Please first create source distribution 'mk sdist'.
   goto :EOF
)

call :HighlightPy  website\src %testdox_py%
call :HighlightCpp UnitTest++  website\unittestpp  main.cpp TestReporterTestDoxStdout.h TestReporterTestDoxStdout.cpp
call :HighlightCpp Boost.Test  website\boosttest   output.bat main.cpp testdox_log_formatter.hpp testdox_log_formatter.cpp testdox_log_formatter.ipp
call :CopyToWeb
endlocal & goto :EOF

:HighlightPy
set dir=%1
set files=%2 %3 %4 %5 %6
echo Creating highlighted source in subdirectory %dir%.
echo Creating highlighted source in subdirectory %dir% >>%logfile%
echo ^<h2 id="testdox"^>TestDox: create simple documentation from test case names^</h2^>  >%dir%\content.php
for %%f in ( %files% ) do (
::   echo ^<h3^>%%~nxf:^</h3^>  >>%dir%\content.php
   %highlight_py% %%f   >>%dir%\content.php
)
endlocal & goto :EOF

:HighlightCpp
set fw=%1
set dir=%2
set files=%3 %4 %5 %6 %7 %8 %9
echo Creating highlighted source in subdirectory %dir%.
echo Creating highlighted source in subdirectory %dir% >>%logfile%
echo ^<h2^>%fw% TestDox reporter customization^</h2^>  >%dir%\content.php
for %%f in ( %files% ) do (
   if [%%~nxf] == [output.bat] (
      echo ^<h3^>%%~nf:^</h3^>  >>%dir%\content.php
      echo ^<pre^>    >>%dir%\content.php
      call %dir%\%%f  >>%dir%\content.php  2>&1
      echo ^</pre^>   >>%dir%\content.php
   ) else (
      echo ^<h3^>%%~nxf:^</h3^>  >>%dir%\content.php
      %highlight_cpp% %dir%\%%f  >>%dir%\content.php
   )
)
endlocal & goto :EOF

:CopyToWeb
echo Copying files to subdirectory %webroot%
echo Copying files to subdirectory %webroot% >>%logfile%
xcopy /y website\*.php %webroot%  >>%logfile%
xcopy /y website\*.css %webroot%  >>%logfile%

echo Copying files to subdirectory %websrc%
echo Copying files to subdirectory %websrc% >>%logfile%
xcopy /y/s %localsrc%   %websrc%\ >>%logfile%
copy Readme.txt     %websrc%  >>%logfile%
copy ChangeLog.txt  %websrc%  >>%logfile%
copy ToDo.txt       %websrc%  >>%logfile%
copy %testdox_py%   %websrc%  >>%logfile%
copy %testdox_hpy%  %websrc%  >>%logfile%
copy %testdox_exe%  %websrc%  >>%logfile%
copy %testdox_zip%  %websrc%  >>%logfile%

echo Copying files to subdirectory %weboutput%
echo Copying files to subdirectory %weboutput% >>%logfile%
xcopy /y/s %localoutput%   %weboutput%\ >>%logfile%

echo Copying files to subdirectory %webroot%\unittestpp\
echo Copying files to subdirectory %webroot%\unittestpp\  >>%logfile%
xcopy /y website\unittestpp\*.php  %webroot%\unittestpp\  >>%logfile%
xcopy /y website\unittestpp\*.css  %webroot%\unittestpp\  >>%logfile%

echo Copying files to subdirectory %webroot%\boosttest\
echo Copying files to subdirectory %webroot%\boosttest\  >>%logfile%
xcopy /y website\boosttest\*.php   %webroot%\boosttest\  >>%logfile%
xcopy /y website\boosttest\*.css   %webroot%\boosttest\  >>%logfile%

endlocal & goto :EOF

::
:: end of file
::
