@echo off

set ADMIN_DIR=%~dp0%..\
set VENDOR_DIR=%ADMIN_DIR%..\vendor\

: Run code beautifier & fixer
call %VENDOR_DIR%bin\phpcbf -p --colors --standard=%VENDOR_DIR%\cakephp\cakephp-codesniffer\CakePHP %ADMIN_DIR%\src %ADMIN_DIR%\tests
