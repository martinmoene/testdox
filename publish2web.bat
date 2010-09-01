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

set    highlight=call website\source-highlight-py.bat

if exist %logfile% del %logfile%

if not exist %testdox_exe% (
   echo %progname%: Please first create binary distribution with 'mk dist'.
   goto :EOF
)

if not exist MANIFEST (
   echo %progname%: Please first create source distribution 'mk sdist'.
   goto :EOF
)

call :Highlight
call :CopyToWeb
endlocal & goto :EOF

:Highlight
echo Creating highlighted source in in subdirectory %localsrc%.
echo Creating highlighted source in in subdirectory %localsrc% >>%logfile%
echo ^<h2 id="testdox"^>TestDox: create simple documentation from test case names^</h2^>  >%testdox_hpy%
%highlight% %testdox_py% >>%testdox_hpy%
endlocal & goto :EOF

:CopyToWeb
echo Copying files to subdirectory %websrc%
echo Copying files to subdirectory %websrc% >>%logfile%
xcopy /y/s %localsrc%   %websrc%\ >>%logfile%
copy Readme.txt     %websrc%  >>%logfile%
copy ChangeLog.txt  %websrc%  >>%logfile%
copy %testdox_py%   %websrc%  >>%logfile%
copy %testdox_hpy%  %websrc%  >>%logfile%
copy %testdox_exe%  %websrc%  >>%logfile%
copy %testdox_zip%  %websrc%  >>%logfile%
endlocal & goto :EOF

::
:: end of file
::
