# 📋 Aplikasi & Deploy

## Aplikasi
**EyeOne FTE Monitoring** - Sistem monitoring beban kerja vendor untuk PT PLN Icon Plus

**Fitur**: Vendor CRUD, Project tracking (7 status), FTE calculation, Dashboard real-time, Reports

**Tech**: Laravel 12 + Livewire 3 + MySQL Railway + WorkOS + TailwindCSS 4

## Deploy ke Render
**Waktu**: 15 menit | **Biaya**: $0

### Cara Deploy:
**🔹 Opsi A: Native Environment** (Recommended - 5-8 menit build)
- Simple, cepat, pakai `build.sh`

**🔹 Opsi B: Docker** (Alternatif - 10-15 menit build)
- Self-contained, pakai `Dockerfile`

### Quick Steps:
1. Push ke GitHub
2. Buat web service di render.com (pilih Native/Docker)
3. Set environment variables (dari .env)
4. Deploy & tunggu
5. Update WorkOS redirect URL

**💡 Rekomendasi: Pakai Native Environment** (lebih cepat & simple untuk Laravel standard)

### Dokumentasi:
- 📝 **[STEP_BY_STEP.md](STEP_BY_STEP.md)** ⭐ - Panduan step-by-step super detail
- 📖 **[RENDER_DEPLOYMENT.md](RENDER_DEPLOYMENT.md)** - Panduan lengkap & troubleshooting

## Files
- `build.sh` - Build script untuk Native Environment ⭐
- `Dockerfile` - Docker config (backup option)
- `.env` - Environment variables (sudah ada)

## Database & Auth
✅ MySQL Railway (switchback.proxy.rlwy.net) - sudah aktif
✅ WorkOS test mode - sudah setup

**Tidak perlu buat baru!**
