@echo off & setlocal
::
:: publish2web.bat - create highlighted python source and copy files to website.
::

set    progname=%0
set     logfile=%progname%.log

set     webroot=H:\public_html\Home\projects\testdox
set      websrc=%webroot%\src
set    localsrc=website\src

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

call :HighlightPy  website\src         %testdox_py%
call :HighlightCpp website\unittestpp  main.cpp TestReporterTestDoxStdout.h TestReporterTestDoxStdout.cpp
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
set dir=%1
set files=%2 %3 %4 %5 %6
echo Creating highlighted source in subdirectory %dir%.
echo Creating highlighted source in subdirectory %dir% >>%logfile%
echo ^<h2 id="unittest"^>UnitTest++ TestDox reporter customization^</h2^>  >%dir%\content.php
for %%f in ( %files% ) do (
   echo ^<h3^>%%~nxf:^</h3^>  >>%dir%\content.php
   %highlight_cpp% %dir%\%%f  >>%dir%\content.php
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

echo Copying files to subdirectory %webroot%\website\unittestpp\
echo Copying files to subdirectory %webroot%\website\unittestpp\ >>%logfile%
xcopy /y website\unittestpp\*.php %webroot%\unittestpp\  >>%logfile%
xcopy /y website\unittestpp\*.css %webroot%\unittestpp\  >>%logfile%
endlocal & goto :EOF

::
:: end of file
::
