# Panduan Instalasi dan Konfigurasi Aplikasi

## Prasyarat
Panduan ini mengasumsikan bahwa Anda telah menginstal SQL Server, XAMPP, dan Laravel dengan benar di sistem Anda.

## Langkah-langkah

1. **Restore Database**
   - Restore database dari file `ids-sales.bak` yang berada di folder `sql-server-things`.

2. **Update File .env**
   - Buka file `.env` dan ubah konfigurasinya menjadi seperti berikut:
     ```plaintext
     DB_CONNECTION=sqlsrv
     DB_HOST="DESKTOP-RENKKTS\\SQLEXPRESS01" # Sesuaikan jika perlu
     DB_PORT=53214 # Sesuaikan jika perlu
     DB_DATABASE=ids-sales
     DB_USERNAME=sa # Sesuaikan jika perlu
     DB_PASSWORD= # Sesuaikan jika perlu
     ```

3. **Salin File DLL**
   - Salin file `php_pdo_sqlsrv_82_ts_x64.dll` dan `php_sqlsrv_82_ts_x64.dll` dari folder `sql-server-things` ke folder `C:\xampp\php\ext`.

4. **Edit File php.ini**
   - Buka file `php.ini` yang berada di folder `C:\xampp\php\` dan tambahkan baris berikut:
     ```plaintext
     ; untuk koneksi SQL Server dengan PHP
     extension=php_sqlsrv_82_ts_x64.dll
     extension=php_pdo_sqlsrv_82_ts_x64.dll
     ```

5. **Restart XAMPP Server**
   - Restart server XAMPP untuk menerapkan perubahan.

6. **Jalankan Perintah npm**
   - Buka terminal dan jalankan perintah `npm run dev`, biarkan prosesnya berjalan.

7. **Jalankan Laravel Server**
   - Buka terminal baru dan jalankan perintah `php artisan serve`.

8. **Akses Aplikasi**
   - Buka browser dan akses `http://127.0.0.1:8000/dashboard`.

9. **Login**
   - Login dengan menggunakan kredensial berikut:
     - **Username:** `admin@gmail.com`
     - **Password:** `admin123`