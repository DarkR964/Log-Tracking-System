# 🛡️ Log Tracking System

Bu proje, bir CMD uygulaması üzerinden kullanıcı bilgilerini loglayan, bu logları web paneline gönderen ve admin tarafından yönetilebilen bir takip sistemidir.

---

## 🚀 Özellikler

- ✅ EXE dosyası açıldığı anda sistem bilgilerini otomatik loglar  
- 🔁 Aynı kullanıcı tekrar giriş yaparsa sadece `giris_sayisi` arttırılır  
- 👤 Admin paneli:
  - Yeni kullanıcı ekleyebilir
  - Logları görüntüleyebilir
- 🔐 Admin girişi 3 haklı güvenlik sistemine sahiptir
- ↩ Her işlem sonrası menüye geri dönüş
- 🌐 PHP + MySQL web panel desteği
- 📂 Modüler klasör yapısı: `logs`, `login`

---


### 🧩 Gereksinimler

- Python 3.x  
- PHP 7+ (XAMPP önerilir)  
- MySQL / MariaDB  
- `pyinstaller` (EXE yapmak için)

---

## 💻 Kurulum
### 🗃️ Veritabanını .sql dosyasından yükleme

Proje içinde `jcp.sql` dosyası mevcuttur.

1. phpMyAdmin’e git
2. Yeni bir veritabanı oluştur: `jcp`
3. Üst menüden “İçe Aktar (Import)” sekmesine tıkla
4. `database/jcp.sql` dosyasını seç ve yükle

### 🌍 Web Panel
Log kayıtları ve kullanıcı yönetimi için PHP tabanlı admin paneli kullanılır.

log-kaydet.php → logları veritabanına ekler veya günceller

admin-panel.php → admin arayüzünden logları listeler

add-user.php → yeni kullanıcıyı users tablosuna ekler

### 🧪 Test ve Geliştirme
XAMPP gibi bir yerel sunucu ile çalıştırabilirsin

Tarayıcıdan http://localhost/jcp/logs/admin-panel.php adresine girerek logları görebilirsin

EXE dosyasını başka bilgisayarda test etmek için xampp üzerinden sunucuyu açık bırakman gerekir


