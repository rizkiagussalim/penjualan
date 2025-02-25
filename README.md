1. Restore Database dari file 'ids-sales.bak' dari folder 'sql-server-things'
2. Salin file php_pdo_sqlsrv_82_ts_x64.dll dan php_sqlsrv_82_ts_x64.dll (masih di folder 'sql-server-things') ke folder C:\xampp\php\ext
3. Buka file php.ini di folder C:\xampp\php\ lalu tambahkan baris berikut:
; untuk koneksi SQL Server dengan php
extension=php_sqlsrv_82_ts_x64.dll
extension=php_pdo_sqlsrv_82_ts_x64.dll
4. Restart xampp server