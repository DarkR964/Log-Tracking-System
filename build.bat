@echo off
echo [*] Eski exe temizleniyor...
rmdir /s /q dist
rmdir /s /q build
del main.spec
echo [*] .exe oluşturuluyor...
pyinstaller --onefile main.py
pause
