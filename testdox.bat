@echo off & setlocal
::
:: testdox.bat
::
:: Wrapper script for testdox.py.
::
:: Author: Martin Moene, http://www.eld.leidenuniv.nl/~moene/
::
:: This tool is provided under the Boost license.  Please read
:: http://www.boost.org/users/license.html for the original text.
::
:: $Id$
::

set       progname=%~nx0
set     scriptname=%~dpn0.py
set         python=python

::echo %python% %scriptname% %*
%python% %scriptname% %*

endlocal

::
:: end of file
::
