# 🚀 Step-by-Step Deploy ke Render

## 📋 Persiapan (5 menit)

### ✅ Checklist Sebelum Mulai
- [ ] Punya akun GitHub (repository sudah ada)
- [ ] Database MySQL Railway sudah jalan
- [ ] WorkOS credentials sudah ada di `.env`
- [ ] Git sudah terinstall

---

## 🎯 STEP 1: Push Code ke GitHub (2 menit)

### 1.1 Buka Terminal/PowerShell
```powershell
cd "C:\Users\ahmad\source\repos\Binus Projects\EyeOne-FTE-Monitoring"
```

### 1.2 Cek Status Git
```powershell
git status
```

### 1.3 Add & Commit Files
```powershell
git add .
git commit -m "Add Render deployment files"
```

### 1.4 Push ke GitHub
```powershell
git push origin main
```

**✅ Tunggu sampai selesai push**

---

## 🎯 STEP 2: Daftar/Login Render (3 menit)

### 2.1 Buka Browser
Ketik: `https://dashboard.render.com/register`

### 2.2 Pilih Sign Up Method
Klik: **"Sign Up with GitHub"**

### 2.3 Authorize Render
- Klik **"Authorize Render"**
- Login GitHub kalau diminta
- Approve access ke repositories

**✅ Sekarang Anda masuk Render Dashboard**

---

## 🎯 STEP 3: Buat Web Service (5 menit)

### 3.1 Create New Service
Klik tombol besar: **"New +"** (pojok kanan atas)

### 3.2 Pilih Jenis Service
Klik: **"Web Service"**

### 3.3 Connect Repository
- Pilih: **"Build and deploy from a Git repository"**
- Klik: **"Next"**

### 3.4 Pilih Repository
- Cari: **"EyeOne-FTE-Monitoring"**
- Klik: **"Connect"** di sebelah kanan repository tersebut

### 3.5 Configure Service - Basic Info
Isi form berikut:

**Name:**
```
eyeone-fte-monitoring
```

**Region:**
```
Singapore
```

**Branch:**
```
main
```

**Root Directory:**
```
(kosongkan - leave empty)
```

### 3.6 Configure Service - Build Settings

**Runtime:**
Pilih dropdown → **"Native Environment"**

**Build Command:**
```
./build.sh
```

**Start Command:**
```
php artisan serve --host=0.0.0.0 --port=$PORT
```

### 3.7 Pilih Plan
Scroll ke bawah, pilih: **"Free"**

**⚠️ JANGAN KLIK "Create Web Service" DULU!**

---

## 🎯 STEP 4: Setup Environment Variables (10 menit)

### 4.1 Scroll ke Bagian Environment
Cari section: **"Environment Variables"**

### 4.2 Tambah Variable Satu-Satu
Klik tombol: **"Add Environment Variable"**

Masukkan satu per satu (copy-paste dari bawah):

#### Variable 1: APP_NAME
- **Key:** `APP_NAME`
- **Value:** `EyeOne`
- Klik **"Save"**

#### Variable 2: APP_ENV
- **Key:** `APP_ENV`
- **Value:** `production`
- Klik **"Save"**

#### Variable 3: APP_KEY
- **Key:** `APP_KEY`
- **Value:** `base64:ipky3xO/FpLTTHpMjj3palavPTBQ2j65TMl13qZYw14=`
- Klik **"Save"**

#### Variable 4: APP_DEBUG
- **Key:** `APP_DEBUG`
- **Value:** `false`
- Klik **"Save"**

#### Variable 5: APP_URL
- **Key:** `APP_URL`
- **Value:** `https://eyeone-fte-monitoring.onrender.com`
- Klik **"Save"**

#### Variable 6: DB_CONNECTION
- **Key:** `DB_CONNECTION`
- **Value:** `mysql`
- Klik **"Save"**

#### Variable 7: DB_HOST
- **Key:** `DB_HOST`
- **Value:** `switchback.proxy.rlwy.net`
- Klik **"Save"**

#### Variable 8: DB_PORT
- **Key:** `DB_PORT`
- **Value:** `51075`
- Klik **"Save"**

#### Variable 9: DB_DATABASE
- **Key:** `DB_DATABASE`
- **Value:** `fte`
- Klik **"Save"**

#### Variable 10: DB_USERNAME
- **Key:** `DB_USERNAME`
- **Value:** `root`
- Klik **"Save"**

#### Variable 11: DB_PASSWORD
- **Key:** `DB_PASSWORD`
- **Value:** `SyLJdSQAashvRAJSEtXNGNgexWNJUqLf`
- Klik **"Save"**

#### Variable 12: CACHE_STORE
- **Key:** `CACHE_STORE`
- **Value:** `database`
- Klik **"Save"**

#### Variable 13: SESSION_DRIVER
- **Key:** `SESSION_DRIVER`
- **Value:** `database`
- Klik **"Save"**

#### Variable 14: QUEUE_CONNECTION
- **Key:** `QUEUE_CONNECTION`
- **Value:** `database`
- Klik **"Save"**

#### Variable 15: WORKOS_CLIENT_ID
- **Key:** `WORKOS_CLIENT_ID`
- **Value:** `your_workos_client_id_here`
- Klik **"Save"**

#### Variable 16: WORKOS_API_KEY
- **Key:** `WORKOS_API_KEY`
- **Value:** `your_workos_api_key_here`
- Klik **"Save"**

#### Variable 17: WORKOS_REDIRECT_URL
- **Key:** `WORKOS_REDIRECT_URL`
- **Value:** `https://eyeone-fte-monitoring.onrender.com/authenticate`
- Klik **"Save"**

#### Variable 18: LOG_CHANNEL
- **Key:** `LOG_CHANNEL`
- **Value:** `stack`
- Klik **"Save"**

#### Variable 19: LOG_LEVEL
- **Key:** `LOG_LEVEL`
- **Value:** `error`
- Klik **"Save"**

#### Variable 20: MAIL_MAILER
- **Key:** `MAIL_MAILER`
- **Value:** `log`
- Klik **"Save"**

**✅ Total 20 environment variables sudah ditambahkan**

---

## 🎯 STEP 5: Deploy! (10 menit)

### 5.1 Create Service
Scroll ke paling bawah, klik tombol besar: **"Create Web Service"**

### 5.2 Tunggu Build Process
Anda akan masuk ke halaman service. Perhatikan:

**Tab "Logs"** akan menampilkan:
```
==> Cloning from GitHub...
==> Running build command './build.sh'...
==> 🚀 Starting build process...
==> 📦 Installing PHP dependencies...
==> 📦 Installing Node.js dependencies...
==> 🏗️ Building frontend assets...
==> 🔧 Optimizing Laravel...
==> ✅ Build completed successfully!
==> 🗄️ Running database migrations...
==> 🎉 Deployment ready!
```

**Tunggu 5-10 menit** sampai status berubah:
- 🟡 **Building...** → sedang build
- 🟢 **Live** → sudah jadi! ✅

### 5.3 Catat URL Aplikasi
Setelah **Live**, akan muncul URL:
```
https://eyeone-fte-monitoring.onrender.com
```

**✅ Aplikasi sudah online!**

---

## 🎯 STEP 6: Update WorkOS Redirect URL (3 menit)

### 6.1 Buka WorkOS Dashboard
Buka tab baru: `https://dashboard.workos.com/`

### 6.2 Login WorkOS
Login dengan akun WorkOS Anda

### 6.3 Pilih Application
- Klik **"Applications"** di sidebar
- Pilih aplikasi Anda (yang sesuai dengan Client ID)

### 6.4 Tambah Redirect URI
- Scroll ke section **"Redirect URIs"**
- Klik **"Add Redirect URI"**
- Masukkan:
  ```
  https://eyeone-fte-monitoring.onrender.com/authenticate
  ```
- Klik **"Save"**

**✅ WorkOS sudah dikonfigurasi!**

---

## 🎯 STEP 7: Test Aplikasi (5 menit)

### 7.1 Buka Aplikasi
Buka browser, ketik:
```
https://eyeone-fte-monitoring.onrender.com
```

**⚠️ Note:** Request pertama bisa lambat (30-60 detik) karena cold start - ini normal!

### 7.2 Test Homepage
- [ ] Homepage loading tanpa error
- [ ] CSS & styling muncul dengan benar
- [ ] Logo & navigation terlihat

### 7.3 Test Login
- [ ] Klik tombol **"Login"**
- [ ] Redirect ke WorkOS
- [ ] Login dengan akun test
- [ ] Redirect kembali ke aplikasi

### 7.4 Test Dashboard
- [ ] Dashboard muncul setelah login
- [ ] Data dari database Railway muncul
- [ ] Menu & navigation berfungsi

### 7.5 Test CRUD
- [ ] Buka menu **Vendors**
- [ ] Coba create vendor baru
- [ ] Coba edit vendor
- [ ] Data tersimpan di database Railway

**✅ Semua fungsi berjalan dengan baik!**

---

## 🎉 SELESAI!

### ✅ Aplikasi Berhasil Di-Deploy!

**URL Aplikasi:**
```
https://eyeone-fte-monitoring.onrender.com
```

**Status:**
- 🟢 Web Service: Live di Render
- 🟢 Database: MySQL Railway (sudah ada)
- 🟢 Authentication: WorkOS (configured)
- 🟢 SSL: HTTPS otomatis

---

## 📊 Monitoring & Maintenance

### Cara Lihat Logs
1. Login Render Dashboard
2. Pilih service: **eyeone-fte-monitoring**
3. Klik tab **"Logs"**
4. Lihat real-time logs

### Cara Restart Service
1. Di dashboard service
2. Klik **"Manual Deploy"**
3. Pilih **"Clear build cache & deploy"**

### Auto-Deploy
Setiap kali Anda push ke GitHub:
```powershell
git add .
git commit -m "Update feature X"
git push origin main
```
Render akan **otomatis deploy** dalam ~5-8 menit

---

## 🐛 Troubleshooting

### Masalah 1: Build Failed - Permission Denied
**Error:** `./build.sh: Permission denied`

**Solusi:**
```powershell
git update-index --chmod=+x build.sh
git commit -m "Fix build.sh permissions"
git push origin main
```
Render akan auto-deploy lagi.

### Masalah 2: Database Connection Error
**Error:** `SQLSTATE[HY000] [2002] Connection refused`

**Solusi:**
1. Cek environment variables di Render
2. Pastikan `DB_HOST` = `switchback.proxy.rlwy.net`
3. Pastikan `DB_PASSWORD` benar
4. Restart service

### Masalah 3: WorkOS Redirect Error
**Error:** `Invalid redirect_uri`

**Solusi:**
1. Buka WorkOS Dashboard
2. Cek Redirect URIs sudah ada:
   ```
   https://eyeone-fte-monitoring.onrender.com/authenticate
   ```
3. Save dan coba lagi

### Masalah 4: Cold Start Lambat
**Gejala:** Request pertama sangat lambat (~30-60 detik)

**Solusi:** Ini normal untuk free tier!
- Setup UptimeRobot untuk ping setiap 10 menit
- Atau upgrade ke paid plan ($7/bulan)

---

## 💡 Tips & Tricks

### Prevent Sleep (Free Tier)
Aplikasi sleep setelah 15 menit tidak aktif.

**Setup UptimeRobot:**
1. Daftar: https://uptimerobot.com (gratis)
2. Add monitor
3. URL: `https://eyeone-fte-monitoring.onrender.com`
4. Interval: 10 minutes
5. Done! Aplikasi tidak sleep lagi

### Custom Domain
1. Beli domain (Namecheap, GoDaddy, dll)
2. Di Render: Settings → Custom Domains
3. Add domain Anda
4. Update DNS records sesuai instruksi
5. Done! Domain custom aktif

### Database Backup
```powershell
# Backup dari Railway
# Login Railway dashboard → Database → Backup
# Atau manual export via phpMyAdmin
```

---

## 📞 Butuh Bantuan?

- 📖 **Docs:** [RENDER_DEPLOYMENT.md](RENDER_DEPLOYMENT.md)
- 🐛 **Issues:** [GitHub Issues](https://github.com/ajhadi/EyeOne-FTE-Monitoring/issues)
- 📚 **Render Docs:** https://render.com/docs
- 💬 **Laravel Docs:** https://laravel.com/docs

---

**Total Waktu:** ~20-25 menit
**Total Biaya:** $0 (Gratis!)
**Kesulitan:** ⭐⭐☆☆☆ (Easy)

**Happy Deploying! 🚀**
