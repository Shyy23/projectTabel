-- CRUD -> D -> DELETE
-- Menghapus semua data
DELETE FROM siswa
-- menghapus data berdasarkan id_siswa
DELETE FROM siswa
WHERE id_siswa = 5;

-- menghapus dengan drop
DROP DATABASE query_syahrul;
DROP TABLE siswa;

-- Menghapus dengan TRUNCATE
TRUNCATE TABLE siswa;

-- Menghapus Alter Drop
ALTER TABLE siswa
DROP COLUMN kp_cempaka RT03/03;

ALTER TABLE siswa
DROP INDEX idx_nama;

ALTER TABLE siswa
DROP CONSTRAINT fk_kelas;;