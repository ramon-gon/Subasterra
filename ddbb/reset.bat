@echo off
setlocal

set "FOLDER=C:\Users\%USERNAME%\VirtualBox VMs"

vagrant destroy -f

for /d %%i in ("%FOLDER%\*subasterra*") do (
    echo Borrant carpeta: %%i
    rd /s /q "%%i"
)

for /d %%i in ("%FOLDER%\*ddbb*") do (
    echo Borrant carpeta: %%i
    rd /s /q "%%i"
)

for /d %%i in (".\.vagrant") do (
    echo Borrant carpeta: %%i
    rd /s /q "%%i"
)

for %%i in (".\*.log") do (
    echo Borrant fitxer: %%i
    del /q "%%i"
)

echo Cleanup completat.
endlocal
