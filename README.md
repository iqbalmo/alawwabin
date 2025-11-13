<p align="center">
  <a href="#">
    <img src="public/img/alawwabin-logo.png" alt="Logo Al-Awwabin" width="120">
  </a>
</p>

<h1 align="center">SITU Al-Awwabin</h1>
<p align="center">
  <strong>Sistem Informasi Terpadu (SITU) untuk MTs Al-Awwabin</strong>
</p>
<p align="center">
  Sebuah aplikasi web internal untuk mengelola semua data akademik dan administratif sekolah secara terpusat.
</p>

---

## 🏫 Tentang Proyek

**SITU Al-Awwabin** adalah *Sistem Informasi Sekolah (SIS)* modern yang dibangun untuk menyederhanakan dan mendigitalkan manajemen data di **MTs Al-Awwabin**.  
Aplikasi ini mengelola berbagai hal mulai dari **data siswa yang sangat detail**, **data guru**, **manajemen kelas**, hingga **keuangan dan penjadwalan**.

Dibangun menggunakan **Laravel 12**, dengan frontend yang responsif didukung oleh **Tailwind CSS** dan **Alpine.js**.

---

## 🚀 Fitur Utama

- **Dashboard Utama** — Tampilan ringkasan dan kalender kegiatan sekolah.  
- **Manajemen Data Siswa** — CRUD (Create, Read, Update, Delete) untuk data siswa dengan 30+ bidang data lengkap, termasuk data orang tua, wali, dan alamat.  
- **Manajemen Data Guru** — CRUD untuk data guru dan staf pengajar.  
- **Manajemen Kelas** — Mengelola kelas dan alokasi wali kelas.  
- **Manajemen Mata Pelajaran (Mapel)** — Mengelola daftar mata pelajaran.  
- **Manajemen Jadwal** — Mengatur jadwal pelajaran per kelas.   
- **Sistem Autentikasi** — Sistem login yang aman untuk admin dan staf.  

---

## 🧰 Tumpukan Teknologi (Tech Stack)

| Komponen | Teknologi |
|-----------|------------|
| **Framework** | Laravel 12 |
| **Backend** | PHP 8.2+ |
| **Frontend** | Tailwind CSS, Alpine.js, Vite |
| **Database** | MySQL (atau PostgreSQL / SQLite yang didukung Laravel) |

---

## ⚙️ Panduan Instalasi (Getting Started)

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

### 1️⃣ Clone repositori
```bash
git clone https://github.com/username/repository.git
cd repository
```

### 2️⃣ Instal dependensi PHP
```bash
composer install
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
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alawwabin_db
DB_USERNAME=root
DB_PASSWORD=password
```
