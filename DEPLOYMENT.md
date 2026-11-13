# Panduan Deployment Cloud PaaS (Railway / Render / Fly.io)

Aplikasi **Event Ticketing App** ini telah dikonfigurasi secara lengkap menggunakan **Docker (Multi-stage build)** dengan Nginx, PHP 8.2 FPM, Supervisor, dan Vite asset builder.

---

## 1. Langkah Persiapan: Push ke GitHub

Sebelum deploy ke Railway atau Render, Anda perlu memasukkan kode ini ke repositori GitHub Anda:

1. Buat repositori baru di GitHub (misal: `event-ticketing-app`).
2. Jalankan perintah berikut di terminal:
   ```bash
   git branch -M main
   git remote add origin https://github.com/USERNAME_ANDA/NAMA_REPO.git
   git push -u origin main
   ```

---

## 2. Opsi A: Deploy ke Railway (Paling Direkomendasikan ⭐)

Railway adalah platform termudah untuk Laravel karena otomatis mendeteksi `Dockerfile` dan `railway.json`.

### Langkah-langkah:
1. Buka [Railway.com](https://railway.com) dan login dengan akun GitHub.
2. Klik **New Project** → **Deploy from GitHub repo**.
3. Pilih repositori `event-ticketing-app` Anda.
4. Klik **Add Variables** dan masukkan environment variables berikut:
   - `APP_NAME` : `Event Ticketing`
   - `APP_ENV` : `production`
   - `APP_KEY` : `base64:0Y4t42qDHyrkVKpq0BKDDnhrdgT8dVZJGIcSNHFOBfg=`
   - `APP_DEBUG` : `false`
   - `APP_URL` : `https://${{RAILWAY_PUBLIC_DOMAIN}}`
   - `DB_CONNECTION` : `sqlite`
   - `RUN_MIGRATIONS` : `true`
   - `DB_SEED` : `true` *(agar user admin dan sample event otomatis dibuat)*
5. Buka tab **Settings** → scroll ke bagian **Networking** → klik **Generate Domain**.
6. Railway akan otomatis membangun (build) container dan menjalankan aplikasi. Setelah selesai, buka URL domain yang dibuat!

> **Tips Database MySQL di Railway**: Jika ingin database MySQL permanen, klik **+ New** di canvas Railway → pilih **Database** → **Add MySQL**. Di service aplikasi Laravel Anda, cukup hubungkan atau tambahkan variabel `DATABASE_URL` atau data MySQL dari Railway.

---

## 3. Opsi B: Deploy ke Render (Gratis)

Render menyediakan tier gratis untuk Web Service berbasis Docker.

### Langkah-langkah:
1. Buka [Render.com](https://render.com) dan login dengan GitHub.
2. Klik **New +** → **Web Service**.
3. Hubungkan repositori GitHub Anda.
4. Di bagian konfigurasi:
   - **Language / Runtime**: `Docker`
   - **Region**: `Singapore` (paling dekat dengan Indonesia)
   - **Instance Type**: `Free`
5. Di bagian **Environment Variables**, klik **Add Environment Variable** dan isi:
   - `APP_NAME` : `Event Ticketing`
   - `APP_ENV` : `production`
   - `APP_KEY` : `base64:0Y4t42qDHyrkVKpq0BKDDnhrdgT8dVZJGIcSNHFOBfg=`
   - `APP_DEBUG` : `false`
   - `APP_URL` : `https://nama-app-anda.onrender.com`
   - `DB_CONNECTION` : `sqlite`
   - `RUN_MIGRATIONS` : `true`
   - `DB_SEED` : `true`
6. Klik **Create Web Service**. Tunggu beberapa menit hingga status menjadi **Live**.

---

## 4. Opsi C: Deploy ke Fly.io

Jika Anda memiliki Fly CLI:
1. Jalankan di terminal:
   ```bash
   fly launch
   ```
2. Ikuti instruksi (pilih region `sin` untuk Singapura). File [fly.toml](file:///c:/Users/USER/Downloads/event-ticketing-app/event-ticketing-app/fly.toml) sudah disiapkan.
3. Set secret APP_KEY:
   ```bash
   fly secrets set APP_KEY="base64:0Y4t42qDHyrkVKpq0BKDDnhrdgT8dVZJGIcSNHFOBfg="
   ```
4. Deploy aplikasi:
   ```bash
   fly deploy
   ```

---

## 5. Akun Bawaan (Default Login)

Setelah database ter-migrate dan di-seed (`DB_SEED=true`), Anda bisa langsung login dengan akun berikut:

- **Admin Account**:
  - Email: `admin@example.com`
  - Password: `password`
  - Akses: Kelola event, kelola tipe tiket, laporan penjualan, export PDF & Excel.

- **User Biasa**:
  - Email: `user@example.com`
  - Password: `password`
  - Akses: Melihat event, memesan tiket, melihat tiket saya (`/my-tickets`).
