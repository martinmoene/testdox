@echo off
::
:: hightlight given C++ file, output to stdout.
::

"C:\Program Files\Src-HighLite\bin\source-highlight.exe" --src-lang=cpp --out-format=html --css=../../styles/codehighlight.css  --no-doc --output=STDOUT %*

::
:: end of file
::
