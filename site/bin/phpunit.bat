@echo off

set SITE_DIR=%~dp0%..\
set VENDOR_DIR=%SITE_DIR%..\vendor\

: Set CakePHP coding standard.
call %VENDOR_DIR%bin\phpunit --colors=always -c %SITE_DIR%/phpunit.xml.dist
