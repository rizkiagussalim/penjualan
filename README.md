1. Restore Database dari file 'ids-sales.bak' dari folder 'sql-server-things'
2. Update .env file
DB_CONNECTION=sqlsrv
DB_HOST="DESKTOP-RENKKTS\\SQLEXPRESS01" # sesuaikan
DB_PORT=53214 # sesuaikan
DB_DATABASE=ids-sales
DB_USERNAME=sa # sesuaikan
DB_PASSWORD=# sesuaikan
3. Salin file php_pdo_sqlsrv_82_ts_x64.dll dan php_sqlsrv_82_ts_x64.dll (masih di folder 'sql-server-things') ke folder C:\xampp\php\ext
4. Buka file php.ini di folder C:\xampp\php\ lalu tambahkan baris berikut:
; untuk koneksi SQL Server dengan php
extension=php_sqlsrv_82_ts_x64.dll
extension=php_pdo_sqlsrv_82_ts_x64.dll
5. Restart xampp server
6. Jalankan perintah 'npm run dev', biarkan terus berjalan
7. Buka terminal baru, jalankan perintah 'php artisan serve'