# TP9DPBO2025C2
Saya Zaki Adam dengan NIM 2304934 mengerjakan Tugas Praktikum 9 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak akan melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.
## 🧩 Desain Program

### 📁 Model
Folder ini berisi class yang bertanggung jawab dan berinteraksi langsung dengan database.
- `DB.class.php`  
    Menangani koneksi database: membuka, menutup, dan mengeksekusi query MySQL.
- `Mahasiswa.class.php`  
    Representasi objek dari tabel `mahasiswa`. Mewakili satu record/baris data.
- `TabelMahasiswa.class.php`  
    Turunan dari `DB.class.php`, berisi method untuk operasi `Create, Read, Update, Delete (CRUD)` pada tabel `mahasiswa`.
- `Template.class.php`  
    Bertugas memproses file HTML, seperti `clear`, `write`, dan `replace`.

### 📁 Presenter

Folder ini berisi class yang mengolah input dari View dan memanggil Model untuk pengolahan data.
- `KontrakPresenter.php`  
    Interface yang didefinisikan untuk presenter lainnya.
- `ProsesMahasiswa.php`  
    Presenter yang mengelola data mahasiswa. Menyediakan method untuk operasi `CRUD`, getter untuk setiap kolom mahasiswa, dan memanggil fungsi Model untuk komunikasi dengan database.

### 📁 Templates
Folder ini berisi file-file HTML template yang dapat digunakan atau dimodifikasi oleh View.

### 📁 View
Folder ini mengelola tampilan UI dan interaksi pengguna.
- `KontrakView.php`  
    Interface untuk View lain.
- `TampilMahasiswa.php`  
    Menampilkan UI data mahasiswa dan menangani perintah user (create, update, delete) untuk dikirim ke Presenter.

### 📄 `index.php`

Merupakan entry point aplikasi. Mendeteksi action (`create`, `update`, `delete`) dan meneruskannya ke View. Secara default akan menampilkan tabel mahasiswa.

## 🔄 Alur Program

### 1. **List.html** – _Landing Page_
- Menampilkan tabel mahasiswa lengkap.
- Tombol `Tambah Mahasiswa` untuk menambahkan data baru.
- Setiap baris data memiliki tombol `Edit` dan `Delete`.

### 2. **Form.html** – _Form Input/Edit_
- Digunakan untuk menambah atau mengedit data mahasiswa.
- Field untuk setiap kolom mahasiswa tersedia.
- Tombol `Tambah` atau `Update` akan mengirim perintah ke View untuk diteruskan ke Presenter dan Model.
## Dokumentasi
![video](menyusul.png)
