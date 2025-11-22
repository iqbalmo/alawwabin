<p align="center">
  <a href="#">
    <img src="public/img/alawwabin-logo.png" alt="Logo Al-Awwabin" width="120">
  </a>
</p>

<h1 align="center">SITU Al-Awwabin</h1>
<p align="center">
  <strong>Sistem Informasi Tata Usaha (SITU) untuk MTs Al-Awwabin</strong>
</p>
<p align="center">
  Sebuah aplikasi web internal modern untuk mengelola semua data akademik dan administratif sekolah secara terpusat dengan pengalaman pengguna yang premium.
</p>

---

## 🏫 Tentang Proyek

**SITU Al-Awwabin** adalah *Sistem Informasi Sekolah (SIS)* yang dibangun untuk mendigitalkan dan memodernisasi manajemen data di **MTs Al-Awwabin**. 

Aplikasi ini telah mengalami perombakan UI/UX besar-besaran dengan tema **"Harmoni Klasik"**, mengutamakan tampilan yang bersih, profesional, dan responsif (mobile-first). Dibangun menggunakan **Laravel 12**, dengan frontend modern berbasis **Tailwind CSS v4**, **Livewire 3.6**, dan **Alpine.js**.

---

## 🚀 Fitur Utama

### 🎨 UI/UX Premium
- **Tema "Harmoni Klasik"** — Kombinasi warna Hijau (#2C5F2D), Emas (#C8963E), dan Krem (#F0E6D2) yang elegan.
- **Mobile-First Design** — Tampilan responsif yang optimal di perangkat seluler (card view) dan desktop (tabel data).
- **Interaktif** — Notifikasi real-time, modal dialog, dan transisi yang halus.

### 📚 Modul Akademik
- **Dashboard & Statistik** — Ringkasan data real-time dan kalender kegiatan interaktif.
- **Manajemen Siswa** — Data lengkap siswa, arsip lulusan, dan fitur kenaikan kelas.
- **Manajemen Guru** — Profil guru, jadwal mengajar, dan agenda harian.
- **Manajemen Kelas** — Pengelolaan kelas, wali kelas, dan promosi siswa.
- **Manajemen Mapel & Ekskul** — Pengaturan mata pelajaran dan kegiatan ekstrakurikuler beserta anggotanya.
- **Jadwal Pelajaran** — Pengaturan jadwal yang fleksibel dengan tampilan per hari dan per kelas.
- **Agenda Mengajar** — Jurnal harian guru untuk mencatat materi dan absensi siswa.

### 🛡️ Keamanan & Akses
- **Role-Based Access Control (RBAC)** — Hak akses terpisah untuk Admin dan Guru.
- **Keamanan Akun** — Fitur ubah password dengan indikator kekuatan password.

---

## 🧰 Tumpukan Teknologi (Tech Stack)

| Komponen | Teknologi |
|-----------|------------|
| **Framework** | Laravel 12.0 |
| **Backend** | PHP 8.2+ |
| **Frontend** | Tailwind CSS v4, Alpine.js, Livewire 3.6 |
| **Database** | MySQL |
| **Build Tool** | Vite |
| **Icons** | Heroicons |

---

## ⚙️ Panduan Instalasi (Getting Started)

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

### 1️⃣ Clone repositori
```bash
git clone https://github.com/username/repository.git
cd repository
```

### 2️⃣ Instal dependensi PHP & Node.js
```bash
composer install
npm install
```

### 3️⃣ Buat file .env
```bash
cp .env.example .env
```

### 4️⃣ Hasilkan kunci aplikasi
```bash
php artisan key:generate
```

### 5️⃣ Konfigurasi database
Sesuaikan kredensial database di file `.env`:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alawwabin_db
DB_USERNAME=root
DB_PASSWORD=password
```

### 6️⃣ Migrasi & Seeding Database
```bash
php artisan migrate --seed
```

### 7️⃣ Jalankan Aplikasi
Jalankan server development Laravel dan Vite secara bersamaan:
```bash
npm run dev
```
Dan di terminal terpisah:
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`.
