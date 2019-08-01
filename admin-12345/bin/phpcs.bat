@echo off

set ADMIN_DIR=%~dp0%..\
set VENDOR_DIR=%ADMIN_DIR%..\vendor\

: Run Codesniffer
call %VENDOR_DIR%bin\phpcs -p --colors --standard=%VENDOR_DIR%\cakephp\cakephp-codesniffer\CakePHP %ADMIN_DIR%\src %ADMIN_DIR%\tests
