-- CRUD -> R -> READ
-- Mengambil Semua Data
SELECT * FROM siswa;

-- Mengambil dengan kriteria tertentu
SELECT * FROM siswa WHERE kelas = '11';

-- Mengambil data dengan filter beberapa kolom
SELECT nisn, nama, kelas FROM siswa;

-- Mengambil data dengan sorting
SELECT * FROM siswa ORDER BY nama DESC;

-- Mengambil data dengan 
SELECT * FROM siswa WHERE nama LIKE 'syahrul';

-- Mengambil data dengan LIMIT
SELECT * FROM siswa LIMIT 5;