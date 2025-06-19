@echo off
echo [*] Eski exe temizleniyor...
rmdir /s /q dist
rmdir /s /q build
del cmd_menu.spec
echo [*] .exe oluşturuluyor...
pyinstaller --onefile cmd_menu.py
pause
