@echo off

set ADMIN_DIR=%~dp0%..\
set VENDOR_DIR=%ADMIN_DIR%..\vendor\

: Set CakePHP coding standard.
call %VENDOR_DIR%bin\phpunit --colors=always -c %ADMIN_DIR%/phpunit.xml.dist
