@echo off
set "PATH=C:\php82;%PATH%"
cd /d "%~dp0"
echo =======================================================
echo   Sistem Informasi & Pendataan Sekolah Terpadu
echo   Server berjalan di: http://localhost:8000
echo =======================================================
php.exe artisan serve --host=127.0.0.1 --port=8000
pause

