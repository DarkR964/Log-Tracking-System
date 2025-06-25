import os
import socket
import platform
import requests
import getpass
from datetime import datetime

# Log gönderme fonksiyonu
def send_log():
    try:
        # IP lokasyon bilgisi al
        ip_info = requests.get("https://ipapi.co/json/").json()
        ulke = ip_info.get("country_name", "Bilinmiyor")
        sehir = ip_info.get("city", "Bilinmiyor")
    except:
        ulke = "Bilinmiyor"
        sehir = "Bilinmiyor"

    # Log verisi hazırla
    data = {
        "tarih": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        "kullanici_adi": getpass.getuser(),
        "bilgisayar_adi": socket.gethostname(),
        "ip_adresi": socket.gethostbyname(socket.gethostname()),
        "sistem": platform.system(),
        "surum": platform.version(),
        "platform": platform.platform(),
        "ulke": ulke,
        "sehir": sehir
    }

    # Veriyi gönder
    try:
        response = requests.post("http://localhost/jcp/Log-Tracking-System/logs/log-kaydet.php", data=data)
        print("🔒", response.text)
    except Exception as e:
        print("❌ Log gönderilemedi:", e)

# Web kullanıcı oluşturma (admin yetkisi seçimi dahil)
def create_web_user():
    username = input("Yeni kullanıcı adı: ")
    password = input("Yeni kullanıcı şifresi: ")
    admin = input("Admin yetkisi verilsin mi? (e/h): ").lower()

    is_admin = "1" if admin == "e" else "0"

    try:
        response = requests.post("http://localhost/jcp/Log-Tracking-System/login/add-user.php", data={
            "username": username,
            "password": password,
            "is_admin": is_admin
        })
        if "OK" in response.text:
            print("✅ Kullanıcı oluşturuldu.")
        else:
            print("❌ Oluşturulamadı. Cevap:", response.text)
    except Exception as e:
        print("❌ Kullanıcı eklenemedi:", e)

# Logları tarayıcıda aç
def view_logs():
    try:
        print("🔍 Log görüntüleyici açılıyor...")
        os.system("start http://localhost/jcp/Log-Tracking-System/logs/admin-panel.php")
    except:
        print("❌ Logları açamadım.")

# Admin girişi ve menüsü
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

# Ana menü
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


def send_discord_notification(log_data):
    webhook_url = "https://discord.com/api/webhooks/1387054094623178893/g44EqtlQ3rReFkDOJKvXWAevTYsW9lAe9B5zPbdUbu-5v6KJw8rBQkDRCyJ8j18wmerF"  # kendi linkinle değiştir
    message = f"""📥 Yeni Log Kaydı

👤 Kullanıcı: {log_data['kullanici_adi']}
💻 Bilgisayar: {log_data['bilgisayar_adi']}
🌐 IP: {log_data['ip_adresi']}
🖥️ Sistem: {log_data['sistem']} {log_data['surum']}
📍 Konum: {log_data.get('ulke', 'Bilinmiyor')} / {log_data.get('sehir', 'Bilinmiyor')}
🕒 Tarih: {log_data['tarih']}
"""
    try:
        requests.post(webhook_url, json={"content": message})
    except Exception as e:
        print("❌ Discord bildirimi başarısız:", e)


def send_log():
    from datetime import datetime
    log_data = {
        "tarih": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        "kullanici_adi": getpass.getuser(),
        "bilgisayar_adi": socket.gethostname(),
        "ip_adresi": socket.gethostbyname(socket.gethostname()),
        "sistem": platform.system(),
        "surum": platform.version(),
        "platform": platform.platform()
    }

    try:
        response = requests.post("http://localhost/jcp/Log-Tracking-System/logs/log-kaydet.php", data=log_data)
        print("🔒", response.text)

        # Eğer log başarılı gönderildiyse Discord bildirimi de gönder
        if "OK" in response.text:
            log_data["ulke"] = "Bilinmiyor"   # PHP geri dönmüyor çünkü
            log_data["sehir"] = "Bilinmiyor"
            send_discord_notification(log_data)

    except Exception as e:
        print("❌ Log gönderilemedi:", e)
