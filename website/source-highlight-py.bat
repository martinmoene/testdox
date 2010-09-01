@echo off
::
:: hightlight given python file, output to stdout.
::

"C:\Program Files\Src-HighLite\bin\source-highlight.exe" --src-lang=py --out-format=html --css=../../styles/codehighlight.css  --no-doc --output=STDOUT %*

::
:: end of file
::
