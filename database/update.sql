-- CRUD -> U -> UPDATE
-- update with where
--update with beberapa kondisi
UPDATE siswa
SET kelas = '12'
WHERE kelas ='11' AND nama = 'andy';

-- update with like
UPDATE siswa
SET nama = 'aris'
WHERE nama LIKE '%andy%';

-- Update dengan function
UPDATE siswa 
SET `password` = hash_password('password_baru')
WHERE id_siswa = 5;