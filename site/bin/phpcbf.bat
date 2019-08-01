@echo off

set SITE_DIR=%~dp0%..\
set VENDOR_DIR=%SITE_DIR%..\vendor\

: Run code beautifier & fixer
call %VENDOR_DIR%bin\phpcbf -p --colors --standard=%VENDOR_DIR%\cakephp\cakephp-codesniffer\CakePHP %SITE_DIR%\src %SITE_DIR%\tests
