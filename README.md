# SISTEM INFORMASI SKPI (Surat Keterangan Pendamping Ijazah)

## Deskripsi Sistem
Aplikasi pengelolaan SKPI mahasiswa dengan alur pengajuan dan persetujuan bertahap sesuai hierarki akademik. Terdapat 5 modul data dan 1 fitur cetak SKPI dengan aturan approval yang berbeda-beda.

---

## MODUL DATA & ALUR APPROVAL

### Grup A — 2 Tahap Approval
Modul: Prestasi | Organisasi | Sertifikat Mahasiswa | Magang / Kerja Praktik

Alur: Mahasiswa → BAAK Fakultas → Dosen Wali (SELESAI)

Aturan:
- Status berubah ke "Approved" hanya jika Dosen Wali menyetujui
- BAAK Fakultas wajib approve terlebih dahulu sebelum Dosen Wali dapat bertindak
- Jika salah satu reject, mahasiswa harus mengajukan ulang dari awal

---

### Grup B — 3 Tahap Approval
Modul: Tugas Akhir

Alur: Mahasiswa → BAAK Fakultas → Dosen Wali → Kaprodi (SELESAI)

Aturan:
- Status berubah ke "Approved" hanya jika Kaprodi menyetujui
- Setiap tahap wajib berurutan; tahap berikutnya tidak dapat dilakukan sebelum tahap sebelumnya approve
- Jika salah satu reject, mahasiswa harus mengajukan ulang dari awal

---

### Grup C — 4 Tahap Approval (Fitur Baru)
Modul: Pengajuan Cetak SKPI

Alur: Mahasiswa → BAAK Fakultas → Dosen Wali → Kaprodi → Dekan (SELESAI → Cetak diizinkan)

Aturan:
- Cetak SKPI hanya bisa dilakukan setelah Dekan menyetujui pengajuan cetak
- Keempat tahap wajib berurutan dan semua harus "Approved"
- Jika salah satu reject, mahasiswa harus mengajukan ulang pengajuan cetak

---

## SYARAT CETAK SKPI

Mahasiswa HANYA dapat mencetak SKPI apabila SEMUA modul berikut berstatus "Approved":

1. Prestasi          → status: Approved (oleh Dosen Wali)
2. Organisasi        → status: Approved (oleh Dosen Wali)
3. Sertifikat        → status: Approved (oleh Dosen Wali)
4. Magang / KP       → status: Approved (oleh Dosen Wali)
5. Tugas Akhir       → status: Approved (oleh Kaprodi)
6. Pengajuan Cetak   → status: Approved (oleh Dekan)

Jika ada satu saja modul yang masih berstatus "Pending" atau "Rejected", tombol cetak SKPI harus dinonaktifkan (disabled) dan sistem menampilkan pesan informasi modul mana yang belum lengkap.

---

## HAK AKSES PER ROLE

### MAHASISWA
- Dapat menginput dan mengajukan data untuk semua modul
- Dapat melihat status pengajuan semua modul miliknya
- Dapat mengajukan Pengajuan Cetak SKPI
- Dapat mencetak SKPI hanya jika semua 6 kondisi di atas terpenuhi (semua Approved)
- Tidak dapat approve/reject data apapun

### BAAK FAKULTAS
- Approve / Reject: Prestasi, Organisasi, Sertifikat, Magang/KP, Tugas Akhir, Pengajuan Cetak SKPI
- Merupakan tahap pertama di semua alur approval
- Tidak dapat melanjutkan ke tahap berikutnya; tugasnya hanya verifikasi awal

### DOSEN WALI
- Approve / Reject: Prestasi, Organisasi, Sertifikat, Magang/KP (tahap final Grup A)
- Approve / Reject: Tugas Akhir (tahap ke-2 dari 3)
- Approve / Reject: Pengajuan Cetak SKPI (tahap ke-2 dari 4)
- Hanya dapat bertindak jika BAAK Fakultas sudah approve terlebih dahulu

### KAPRODI
- Approve / Reject: Tugas Akhir (tahap final Grup B)
- Approve / Reject: Pengajuan Cetak SKPI (tahap ke-3 dari 4)
- Tidak memiliki akses ke modul: Prestasi, Organisasi, Sertifikat, Magang/KP
- Hanya dapat bertindak jika Dosen Wali sudah approve terlebih dahulu

### DEKAN
- Approve / Reject: Pengajuan Cetak SKPI saja (tahap final, penentu hak cetak)
- Tidak memiliki akses ke modul: Prestasi, Organisasi, Sertifikat, Magang/KP, Tugas Akhir
- Hanya dapat bertindak jika Kaprodi sudah approve terlebih dahulu

---

## ATURAN BISNIS PENTING

1. SEQUENTIAL APPROVAL: Setiap tahap harus berurutan. Role berikutnya baru dapat melihat dan bertindak setelah role sebelumnya approve.

2. VALIDASI CETAK: Sistem harus memvalidasi status ke-6 modul secara real-time sebelum mengizinkan cetak. Satu saja yang pending/rejected = cetak diblokir.

3. REJECT = RESET: Jika salah satu tahap reject, pengajuan dikembalikan ke mahasiswa untuk diperbaiki dan diajukan ulang. Tahap yang sudah approved sebelumnya tidak ikut direset (tergantung kebijakan implementasi).

4. NOTIFIKASI: Setiap perubahan status (approve/reject) mengirimkan notifikasi ke mahasiswa dan ke role berikutnya dalam alur.

5. STATUS VALID: Hanya ada 3 status — Pending (menunggu review), Approved (disetujui), Rejected (ditolak dengan catatan alasan).

---

## RINGKASAN MATRIKS AKSES

| Modul              | Mahasiswa  | BAAK Fak. | Dosen Wali | Kaprodi | Dekan  |
|--------------------|-----------|-----------|------------|---------|--------|
| Prestasi           | Input/Ajukan | Approve/Reject | Approve/Reject (final) | — | — |
| Organisasi         | Input/Ajukan | Approve/Reject | Approve/Reject (final) | — | — |
| Sertifikat         | Input/Ajukan | Approve/Reject | Approve/Reject (final) | — | — |
| Magang / KP        | Input/Ajukan | Approve/Reject | Approve/Reject (final) | — | — |
| Tugas Akhir        | Input/Ajukan | Approve/Reject | Approve/Reject | Approve/Reject (final) | — |
| Pengajuan Cetak    | Input/Ajukan | Approve/Reject | Approve/Reject | Approve/Reject | Approve/Reject (final) |
| Cetak SKPI         | Cetak (jika semua approved) | — | — | — | — |
