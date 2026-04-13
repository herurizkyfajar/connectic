@echo off
echo ========================================
echo   Prepare for Production Deployment
echo ========================================
echo.

cd /d c:\laragon\www\simrtik

echo Cleaning up...
echo.

REM Delete development files
if exist .env.backup del .env.backup
if exist database\database.sqlite del database\database.sqlite

REM Clean storage
del /Q storage\logs\*.log 2>nul
del /Q storage\framework\cache\data\* 2>nul
del /Q storage\framework\views\*.php 2>nul
del /Q storage\framework\sessions\* 2>nul
del /Q bootstrap\cache\*.php 2>nul

REM Clean test & fix files
del /Q test_*.php 2>nul
del /Q fix_*.php 2>nul
del /Q clear_*.php 2>nul
del /Q *_SAFE.php 2>nul
del /Q find_*.php 2>nul

echo.
echo ✅ Cleanup complete!
echo.
echo Now create ZIP with these folders/files:
echo   - app/
echo   - bootstrap/
echo   - config/
echo   - database/
echo   - public/
echo   - resources/
echo   - routes/
echo   - storage/
echo   - vendor/
echo   - artisan
echo   - composer.json
echo   - composer.lock
echo.
echo ⚠️  DO NOT include:
echo   - .env
echo   - database\database.sqlite
echo   - node_modules/
echo   - .git/
echo.
pause

