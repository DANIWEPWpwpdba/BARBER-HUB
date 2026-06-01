@echo off
echo ==========================================
echo   Actualizando Base de Datos Barber Hub
echo ==========================================
echo.

set MYSQL_PATH="C:\xampp\mysql\bin\mysql.exe"

IF NOT EXIST %MYSQL_PATH% (
    echo Error: No se encontro MySQL en C:\xampp\mysql\bin\mysql.exe
    echo Por favor, asegurate de tener XAMPP instalado en C:\xampp
    pause
    exit /b
)

echo Importando schema_extras.sql (Footer y Desarrolladores)...
%MYSQL_PATH% -u root barber_hub < "%~dp0database\schema_extras.sql"
if %errorlevel% neq 0 (
    echo Error al importar schema_extras.sql
) else (
    echo [OK] Importado correctamente.
)

echo.
echo Importando schema_extras3.sql (Registro de Clientes y Estados)...
%MYSQL_PATH% -u root barber_hub < "%~dp0database\schema_extras3.sql"
if %errorlevel% neq 0 (
    echo Error al importar schema_extras3.sql
) else (
    echo [OK] Importado correctamente.
)

echo.
echo ==========================================
echo   Actualizacion Completada.
echo ==========================================
pause
