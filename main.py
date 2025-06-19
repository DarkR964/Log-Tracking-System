import os
import socket
import platform
import requests
import getpass
from datetime import datetime

# Log gönderme fonksiyonu

def send_log():
    data = {
        "tarih": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        "kullanici_adi": getpass.getuser(),
        "bilgisayar_adi": socket.gethostname(),
        "ip_adresi": socket.gethostbyname(socket.gethostname()),
        "sistem": platform.system(),
        "surum": platform.version(),
        "platform": platform.platform()
    }
    try:
        response = requests.post("http://localhost/jcp/Log-Tracking-System/logs/log-kaydet.php", data=data)
        print("🔒", response.text)
    except Exception as e:
        print("❌ Log gönderilemedi:", e)

# Web kullanıcı oluştur

def create_web_user():
    username = input("Yeni kullanıcı adı: ")
    password = input("Yeni kullanıcı şifresi: ")
    try:
        response = requests.post("http://localhost/jcp/Log-Tracking-System/login/add-user.php", data={
            "username": username,
            "password": password
        })
        if "OK" in response.text:
            print("✅ Kullanıcı oluşturuldu.")
        else:
            print("❌ Oluşturulamadı. Cevap:", response.text)
    except Exception as e:
        print("❌ Kullanıcı eklenemedi:", e)

# Logları aç (tarayıcıda)

def view_logs():
    try:
        print("🔍 Log görüntüleyici açılıyor...")
        os.system("start http://localhost/jcp/Log-Tracking-System/logs/admin-panel.php")
    except:
        print("❌ Logları açamadım.")

# Admin girişi ve admin menüsü

def admin_giris():
    max_hak = 3
    dogru_sifre = "jcp123"
    hak = 0

    while hak < max_hak:
        sifre = input("🔐 Admin şifresi: ")
        if sifre == dogru_sifre:
            print("\n✅ Giriş Başarılı")
            while True:
                print("\n--- Admin Paneli ---")
                print("1. Yeni Web Kullanıcısı Oluştur")
                print("2. Logları Görüntüle")
                print("3. Ana Menüye Dön")
                altsecim = input("Seçiminiz: ")
                if altsecim == "1":
                    create_web_user()
                elif altsecim == "2":
                    view_logs()
                elif altsecim == "3":
                    print("↩ Ana menüye dönülüyor...")
                    return
                else:
                    print("❌ Geçersiz seçim.")
            return
        else:
            hak += 1
            print(f"❌ Yanlış şifre. ({hak}/{max_hak})")

    print("🚫 3 kez yanlış şifre girdin. Ana menüye dönülüyor...\n")
    return

# Ana menü (sonsuz döngü)

def main():
    while True:
        os.system("cls" if os.name == "nt" else "clear")
        print("===== GİRİŞ SİSTEMİ =====")
        print("1. Admin Giriş")
        print("2. Normal Giriş")
        print("3. Programdan Çık")

        secim = input("Seçiminiz: ")

        if secim == "1":
            admin_giris()
        elif secim == "2":
            print("👤 Normal giriş yapıldı.")
            send_log()
            input("↩ Ana menüye dönmek için Enter'a bas...")
        elif secim == "3":
            print("👋 Programdan çıkılıyor...")
            break
        else:
            print("❌ Geçersiz seçim.")
            input("↩ Ana menüye dönmek için Enter'a bas...")

if __name__ == "__main__":
    main()