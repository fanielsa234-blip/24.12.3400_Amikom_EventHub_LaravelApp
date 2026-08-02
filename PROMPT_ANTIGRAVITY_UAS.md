# Prompt untuk Antigravity 2.0 / Antigravity IDE
### Proyek: AmikomEventHub (Laravel) — Penyempurnaan UAS Digital Bisnis

Copy-paste seluruh isi di bawah ini (mulai dari `## KONTEKS PROYEK` sampai akhir) ke chat Antigravity di dalam IDE, dengan project sudah terbuka/ter-index.

---

## KONTEKS PROYEK

Saya sedang mengerjakan UAS mata kuliah Digital Bisnis. Project ini adalah aplikasi **Laravel** bernama **AmikomEventHub**, sebuah platform ticketing event (mirip Loket/Tiket.com) dengan 3 role: **User/Pengunjung**, **Organizer**, dan **Admin**. Progress saat ini ±90%. Stack: Laravel (Blade + Tailwind via Vite), SQLite, integrasi **Midtrans** untuk pembayaran, Socialite untuk Google SSO.

Struktur penting yang sudah ada (tolong baca dulu sebelum mengubah apa pun, jangan berasumsi):
- `app/Models/{Event,Transaction,Review,Category,Organizer,User}.php`
- `app/Http/Controllers/{EventController,CheckoutController,ReviewController,MidtransWebhookController}.php`
- `app/Http/Controllers/Admin/{DashboardController,TransactionController,EventController,CategoryController,PartnerController,OrganizerController,AuthController}.php`
- `app/Http/Controllers/Organizer/{DashboardController,EventController}.php`
- `resources/views/` — termasuk `layouts/app.blade.php`, `layouts/admin.blade.php`, `layouts/organizer.blade.php`, `event-detail.blade.php`, `katalog.blade.php`, `checkout/*.blade.php`, `admin/dashboard.blade.php`, `admin/transactions/index.blade.php`
- `database/migrations/` — tabel `reviews` **sudah ada** (kolom: `user_id`, `event_id`, `transaction_id` nullable, `rating` (1-5), `comment`, unique `[user_id, event_id]`)
- Console command `app:release-expired-reservations` sudah ada untuk melepas stok tiket dari transaksi pending yang kedaluwarsa (dipakai reserved ticket demo di admin).

Saya akan minta kamu mengerjakan **3 hal besar** secara berurutan. Kerjakan satu per satu, jangan langsung ubah banyak file sekaligus tanpa penjelasan. Setelah tiap bagian selesai, jelaskan singkat apa yang diubah dan file mana saja yang tersentuh.

---

## BAGIAN 1 — FITUR ULASAN (WAJIB, BELUM ADA DI UI)

Catatan penting: **backend fitur ulasan sudah 70% jadi** — `Review` model, `ReviewController@store`, migration `reviews`, route `POST /events/{event}/reviews`, dan accessor `getAverageRatingAttribute()` + `getReviewsCountAttribute()` di model `Event` semuanya **sudah ada**. Yang **belum ada** adalah tampilannya. Jangan buat ulang backend yang sudah ada — cek dulu, lalu sambungkan ke UI.

Tolong kerjakan:

1. Di halaman detail event (`resources/views/event-detail.blade.php`):
   - Tampilkan rata-rata rating (bintang) + jumlah ulasan di dekat judul/poster event, menggunakan `$event->average_rating` dan `$event->reviews_count` yang sudah tersedia dari accessor model.
   - Tambahkan section daftar ulasan (nama user, rating bintang, komentar, tanggal), dengan pagination sederhana jika ulasan banyak.
   - Tambahkan form untuk submit ulasan (rating 1-5 pakai star input + textarea komentar) yang mengarah ke route `events.reviews.store` (method POST), **hanya tampil jika**:
     - User sudah login,
     - Tanggal event sudah lewat (`event->date` di masa lalu),
     - User punya transaksi sukses/settlement untuk event tsb,
     - User belum pernah memberi ulasan untuk event tsb.
   - Jika salah satu syarat di atas tidak terpenuhi, tampilkan pesan yang sesuai (bukan form kosong) — contoh: "Login dulu untuk memberi ulasan", "Ulasan bisa diberikan setelah acara selesai", dsb.
   - Tampilkan flash message `success`/`error` dari session (controller sudah mengirim `back()->with(...)`).

2. Cek kembali logika di `ReviewController@store`: pastikan validasi tetap konsisten dengan yang sudah ada, jangan diubah kecuali ada bug nyata.

3. Tambahkan tampilan rating rata-rata event juga di card event pada `katalog.blade.php` dan di homepage (list event), supaya konsisten di seluruh situs.

4. Jika model `Organizer\EventController` atau dashboard organizer menampilkan detail event, tambahkan juga ringkasan rating/jumlah ulasan di sana (opsional tapi bagus untuk organizer melihat performa event mereka).

---

## BAGIAN 2 — PENYEMPURNAAN DASHBOARD ADMIN

File terkait: `app/Http/Controllers/Admin/DashboardController.php`, `resources/views/admin/dashboard.blade.php`, `resources/views/layouts/admin.blade.php`.

Dashboard admin sekarang sudah punya: total revenue, tiket terjual, event aktif, pending orders, 5 transaksi terbaru, dan 4 grafik bulanan (user growth, event growth, organizer growth, revenue growth) pakai Chart.js.

Tolong sempurnakan:
1. **Rapikan UI card statistik** di bagian atas — pastikan grid-nya responsive (1 kolom di mobile, 2 di tablet, 4 di desktop), ikon konsisten, dan warna/kontras selaras dengan tema situs (cek warna utama di `layouts/app.blade.php` / Tailwind config agar tidak beda gaya dengan halaman publik).
2. **Perbaiki layout grafik** — pastikan chart tidak overflow/gepeng di layar kecil, beri container dengan `min-height` yang wajar, dan tambahkan state kosong ("Belum ada data") jika array data kosong supaya Chart.js tidak error/blank.
3. Tambahkan **shortcut/quick action** ke halaman yang sering dipakai admin (kelola event, kelola transaksi, kelola organizer) dalam bentuk card/button di dashboard.
4. Tambahkan **filter rentang tanggal sederhana** (opsional, kalau waktu cukup) untuk revenue/tickets sold — kalau tidak sempat, cukup rapikan yang sudah ada dulu, jangan tambah kompleksitas backend baru yang berisiko bug menjelang deadline.
5. Pastikan sidebar admin (`layouts/admin.blade.php`) punya state "active" yang benar sesuai halaman yang sedang dibuka, dan collapsible/responsive di layar kecil (hamburger menu untuk mobile).

---

## BAGIAN 3 — PENYEMPURNAAN RESERVED TICKET

Alur reserved ticket saat ini: saat checkout, transaksi dibuat dengan `status = 'pending'` dan `expired_at`; jika tidak dibayar sampai waktu itu, command `app:release-expired-reservations` (dipanggil manual lewat tombol admin di `TransactionController@releaseExpired`, atau per-transaksi via `simulateExpireSingle`) akan mengubah status jadi `expired` dan mengembalikan `stock` event (+1).

Tolong sempurnakan:
1. **Jadikan pelepasan reservasi otomatis**, bukan cuma tombol manual admin:
   - Cek apakah command `app:release-expired-reservations` sudah didaftarkan di scheduler (`routes/console.php` atau `bootstrap/app.php` — cek Laravel 11 style scheduling). Jika belum, daftarkan agar berjalan otomatis tiap beberapa menit (`->everyFiveMinutes()` misalnya).
   - Tetap pertahankan tombol manual admin sebagai fallback/demo untuk presentasi UAS.
2. **Tampilkan sisa waktu reservasi (countdown)** ke user di halaman checkout/payment (`checkout/payment.blade.php`), menghitung selisih ke `expired_at`, supaya user tahu batas waktu bayar sebelum tiket dilepas kembali.
3. **Cegah race condition stok**: pastikan saat `CheckoutController@store` membuat transaksi baru, pengurangan `stock` event dilakukan dengan aman (idealnya dalam DB transaction / lock), agar tidak terjadi stok minus jika ada beberapa user checkout bersamaan.
4. Di halaman admin transaksi (`admin/transactions/index.blade.php`), perjelas secara visual status transaksi: badge warna berbeda untuk `pending` (kuning), `settlement/success` (hijau), `expired` (abu-abu/merah), agar admin bisa cepat melihat mana yang butuh tindakan (release).
5. Pastikan setelah tiket dilepas (expired), stok event yang bertambah kembali (`+1`) langsung terlihat konsisten di halaman katalog/detail event (tidak perlu cache-buster khusus kalau memang tidak pakai cache, cukup pastikan query stock selalu fresh).

---

## BAGIAN 4 — UI/UX: KERAPIAN, KONSISTENSI, DAN RESPONSIVENESS

Ini lintas semua halaman (publik, organizer, admin). Tolong lakukan audit dan perbaikan berikut:

1. **Konsistensi desain**: satukan skema warna, jenis font, ukuran heading, dan gaya tombol/badge di seluruh halaman (`layouts/app.blade.php` untuk publik, `layouts/organizer.blade.php`, `layouts/admin.blade.php`). Kalau ada halaman yang masih pakai warna/style beda sendiri (misalnya `event-detail.blade.php`, `checkout/*.blade.php`, `profil.blade.php`, `tentang.blade.php`, `bantuan.blade.php`), samakan dengan tema utama.
2. **Responsiveness penuh** (mobile, tablet, desktop) untuk minimal halaman-halaman ini, urutkan sesuai prioritas:
   - `welcome.blade.php` / homepage
   - `katalog.blade.php`
   - `event-detail.blade.php` (termasuk section review baru dari Bagian 1)
   - `checkout/create.blade.php`, `checkout/payment.blade.php`, `checkout/success.blade.php`
   - `admin/dashboard.blade.php` dan sidebar admin
   - `organizer/dashboard.blade.php`
3. Pastikan navbar publik (`layouts/app.blade.php`) punya hamburger menu yang berfungsi di mobile, dan tidak ada elemen yang overflow horizontal di layar kecil.
4. Perbaiki form-form (login, register organizer, checkout, review) agar input rapi, label jelas, pesan error/validasi tampil dengan baik, dan tombol submit punya state loading/disable saat submit supaya tidak double-submit (khusus checkout & review).
5. Cek konsistensi ukuran gambar/poster event (aspect ratio) di semua tempat ia muncul: homepage, katalog, detail, dashboard organizer/admin.

**Sebelum mengubah styling besar-besaran**, tolong scan dulu apakah project sudah pakai Tailwind config kustom (cek `tailwind.config.js` / `vite.config.js`) dan ikuti pola/desain token yang sudah ada, jangan bikin sistem warna baru yang bentrok.

---

## ATURAN KERJA

- Jangan hapus/timpa fitur yang sudah berjalan (auth, Google SSO, Midtrans checkout, organizer multi-tenant, admin CRUD) kecuali memang ada bug yang harus diperbaiki — jika begitu, jelaskan bug-nya dulu.
- Setelah membuat migration baru (jika terpaksa perlu, misalnya kolom tambahan), tunjukkan perintah `php artisan migrate` yang perlu saya jalankan, jangan asumsikan sudah dijalankan otomatis.
- Untuk setiap bagian (1-4), setelah selesai, tampilkan ringkasan: file yang diubah/ditambahkan, dan langkah testing manual yang perlu saya lakukan di browser untuk verifikasi.
- Kerjakan Bagian 1 dulu sampai selesai dan saya konfirmasi, baru lanjut ke Bagian 2, dst — supaya saya bisa cek progresnya bertahap untuk keperluan laporan UAS.
