# 🚀 Deploy EyeOne FTE ke Render (Gratis)

> **Aplikasi**: Sistem monitoring FTE (Full Time Equivalent) untuk manajemen proyek & vendor
> **Tech**: Laravel 12 + Livewire 3 + MySQL Railway + WorkOS
> **Waktu**: 15 menit | **Biaya**: $0

## ✅ Yang Sudah Siap
- Database MySQL Railway (switchback.proxy.rlwy.net)
- WorkOS credentials
- APP_KEY (base64:ipky3xO/FpLTTHpMjj3palavPTBQ2j65TMl13qZYw14=)

---

## 📝 Langkah Deploy (15 Menit)

### 1. Push ke GitHub (2 menit)
```powershell
git add .
git commit -m "Add Render deployment"
git push origin main
```

### 2. Buat Web Service di Render (3 menit)
1. Login [render.com](https://dashboard.render.com) dengan GitHub
2. **New +** → **Web Service**
3. Pilih repo: **EyeOne-FTE-Monitoring**

#### 🔹 OPSI A: Native Environment (Recommended - Lebih Cepat)
```
Name:          eyeone-fte-monitoring
Region:        Singapore
Branch:        main
Runtime:       Native Environment
Build Command: ./build.sh
Start Command: php artisan serve --host=0.0.0.0 --port=$PORT
Plan:          Free
```

#### 🔹 OPSI B: Docker (Alternatif - Lebih Lambat)
```
Name:          eyeone-fte-monitoring
Region:        Singapore
Branch:        main
Runtime:       Docker
Dockerfile:    Dockerfile
Docker Command: (kosongkan - auto detect)
Plan:          Free
```

**💡 Rekomendasi: Pakai Native Environment** (build 5-8 menit vs Docker 10-15 menit)

**⚠️ JANGAN klik "Create" dulu!**

### 3. Environment Variables (5 menit)
Scroll ke **Environment Variables**, tambahkan satu per satu:

```env
APP_NAME=EyeOne
APP_ENV=production
APP_KEY=base64:ipky3xO/FpLTTHpMjj3palavPTBQ2j65TMl13qZYw14=
APP_DEBUG=false
APP_URL=https://eyeone-fte-monitoring.onrender.com

DB_CONNECTION=mysql
DB_HOST=switchback.proxy.rlwy.net
DB_PORT=51075
DB_DATABASE=fte
DB_USERNAME=root
DB_PASSWORD=SyLJdSQAashvRAJSEtXNGNgexWNJUqLf

CACHE_STORE=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

WORKOS_CLIENT_ID=your_workos_client_id_here
WORKOS_API_KEY=your_workos_api_key_here
WORKOS_REDIRECT_URL=https://eyeone-fte-monitoring.onrender.com/authenticate

LOG_CHANNEL=stack
LOG_LEVEL=error
MAIL_MAILER=log
```

### 4. Deploy! (8 menit)
1. Klik **Create Web Service**
2. Tunggu build selesai
3. Status **"Live"** → Buka URL

### 5. Update WorkOS (2 menit)
1. Login WorkOS Dashboard
2. Tambah redirect URL: `https://eyeone-fte-monitoring.onrender.com/authenticate`
3. Save

---

## 🐛 Troubleshooting

**Build gagal - permission denied**:
```powershell
git update-index --chmod=+x build.sh
git commit -m "Fix permissions"
git push
```

**Database error**:
- Cek DB_HOST, DB_PASSWORD di environment variables
- Restart web service

**Cold start lambat**:
- Normal untuk free tier (sleep after 15 min)
- Setup UptimeRobot untuk ping setiap 10 menit

---

## 💰 Biaya: $0

- Render: Free (750 jam/bulan, 512 MB RAM)
- Railway: $5 credit/bulan (sudah ada)
- WorkOS: Test mode gratis

---

## 🎯 Setelah Deploy

✅ Test homepage
✅ Test login WorkOS
✅ Test dashboard & CRUD
✅ Share URL dengan tim

**URL**: `https://eyeone-fte-monitoring.onrender.com`

---

## 🆚 Perbandingan: Native vs Docker

| Aspek | Native Environment | Docker |
|-------|-------------------|--------|
| **Build Time** | 5-8 menit ⚡ | 10-15 menit 🐌 |
| **Build Size** | ~200 MB | ~500 MB |
| **Complexity** | Simple (build.sh) | Medium (Dockerfile) |
| **Dependency** | Render manages PHP/Node | Self-contained |
| **Debug** | Easier (clear logs) | Harder (Docker layers) |
| **Update** | Fast rebuild | Slower rebuild |
| **Rekomendasi** | ✅ **PAKAI INI** | Backup option |

### Kapan Pakai Docker?
- ✅ Butuh custom system packages
- ✅ Environment sangat specific
- ✅ Sudah familiar dengan Docker

### Kapan Pakai Native?
- ✅ **Setup standard Laravel** (seperti aplikasi ini)
- ✅ Mau cepat dan simple
- ✅ Tidak butuh custom config

**Kesimpulan**: Untuk aplikasi ini, **Native Environment** lebih cocok karena:
1. Laravel standard (tidak butuh custom packages)
2. Build lebih cepat (hemat waktu development)
3. Lebih mudah di-maintain
4. Environment variables lebih clear

---

**Done! 🚀**
