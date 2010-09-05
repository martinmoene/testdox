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

call :Highlight %testdox_py% %testdox_hpy%
call :HighlightCpp website\unittestpp
call :CopyToWeb
endlocal & goto :EOF

:Highlight
set input=%1
set output=%2
echo Creating highlighted source in subdirectory %localsrc%.
echo Creating highlighted source in subdirectory %localsrc% >>%logfile%
echo ^<h2 id="testdox"^>TestDox: create simple documentation from test case names^</h2^>  >%output%
%highlight_py% %input% >>%output%
endlocal & goto :EOF

:HighlightCpp
set dir=%1
echo Creating highlighted source in subdirectory %dir%.
echo Creating highlighted source in subdirectory %dir% >>%logfile%
echo ^<h2 id="unittest"^>UnitTest++ TestDox reporter customizatin^</h2^>  >%dir%\content.php
for %%f in (%dir%\*.h %dir%\*.cpp) do %highlight_cpp% %%f >>%dir%\content.php
endlocal & goto :EOF

:CopyToWeb
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
xcopy /p website\*.php %webroot%
xcopy /p website\*.css %webroot%
endlocal & goto :EOF

::
:: end of file
::
