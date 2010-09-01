@echo off & setlocal
::
:: mk.bat - create TestDox binary or source distribution.
::
:: TestDox generates a readable overview of test case names from the specified files.
::
:: Author: Martin Moene, http://www.eld.leidenuniv.nl/~moene/
::
:: This tool is provided under the Boost license.  Please read
:: http://www.boost.org/users/license.html for the original text.
::
:: $Id$
::

set programName=%0
set logfile=%programName%.log
set basename=testdox

:ProcessArgs
if [%1] == [dist] (
   call :DoDist
) else (
if [%1] == [sdist] (
   call :DoSdist
) else (
   echo Usage: %0 [dist ^| sdist]
   echo.
   echo - mk dist  creates a single-file executable %basename%.exe
   echo - mk sdist  creates a Python source distribution of %basename%.py
) )

:EndProcessArgs
endlocal & goto :EOF

::
:: Subroutines
::

:DoDist
if [] == [%PYINSTALLERPATH%] (
   echo Please set PYINSTALLERPATH to the directory with pyInstaller.
   echo You can download a version of pyInstaller for Python 2.6 from:
   echo - http://www.pyinstaller.org/wiki/Python26Win
) else (
   echo Creating single-file executable %basename%.exe in subdirectory dist.
   echo Be patient...
   echo Creating single-file executable %basename%.exe in subdirectory dist. >%logfile%
   set PYTHONPATH=../Packages
   python "%PYINSTALLERPATH%\Configure.py" >>%logfile%
   python "%PYINSTALLERPATH%\Makespec.py" --onefile %basename%.py >>%logfile%
   python "%PYINSTALLERPATH%\Build.py" %basename%.spec >>%logfile%
   echo Done.
   echo.
   dist\%basename% --version
)
endlocal & goto :EOF

:DoSdist
python Setup.py sdist --dist-dir=.
endlocal & goto :EOF

::
:: end of file
::
