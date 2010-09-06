@echo off & setlocal
echo prompt^>main.exe --log_level=all
echo.

%~dp0main --log_level=all & endlocal & goto :EOF

