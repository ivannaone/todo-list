# Changelog

Semua perubahan penting pada proyek ini akan didokumentasikan di file ini.

Format mengacu pada [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [1.1.0] - 2026-06-03

### Ditambahkan
- Kolom `priority` (low/medium/high) pada tabel tasks
- Fitur toggle selesai langsung dari daftar tugas tanpa masuk halaman edit
- Filter tugas berdasarkan status (semua/berjalan/selesai/terlambat) dan prioritas
- Modal konfirmasi sebelum menghapus tugas
- Indikator hari tersisa/keterlambatan pada setiap task card
- Donut chart progress di halaman Dashboard menggunakan Chart.js
- Bar chart distribusi status di halaman Statistik
- Breakdown penyelesaian per prioritas di halaman Statistik
- Kartu "Deadline Hari Ini" di Dashboard
- Bottom navigation untuk tampilan mobile
- Validasi form yang lebih lengkap dengan pesan error
- Live preview nama dan avatar di halaman Pengaturan
- Selector tema visual (card pilihan Light/Dark) di Pengaturan
- Badge jumlah tugas terlambat di sidebar dan bottom nav
- Shared layout `layout/app.blade.php` digunakan di semua halaman
- User info di sidebar bisa diklik untuk menuju Pengaturan

### Diubah
- Desain ulang keseluruhan UI dengan tema modern (warna, tipografi, spacing)
- Sidebar diperbarui dengan section label, nav icon, dan user footer
- Semua halaman kini menggunakan shared layout yang konsisten
- Halaman Deadline menampilkan hitungan hari keterlambatan
- Halaman Statistik menggunakan Chart.js menggantikan progress bar sederhana
- Validasi `store` dan `update` diperketat (min karakter, format tanggal, enum priority)
- Topbar menampilkan judul dan subtitle per halaman

### Diperbaiki
- Sidebar tidak hilang saat DevTools atau layar kecil (responsive)
- Konsistensi dark/light mode di semua halaman

---

## [1.0.0] - 2026-05-12

### Ditambahkan
- Inisialisasi proyek Laravel 11
- CRUD tugas (tambah, lihat, edit, hapus)
- Kolom title, description, deadline, is_done
- Halaman index, create, edit menggunakan Bootstrap 5
- Halaman Dashboard dengan ringkasan tugas
- Halaman Deadline menampilkan tugas terlambat
- Halaman Statistik dengan progress bar
- Halaman Pengaturan dengan simpan username, email, dan tema
- Dark/light mode berbasis session
- Sidebar navigasi di halaman index
- Pencarian tugas real-time
