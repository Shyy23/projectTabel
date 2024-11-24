-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 11:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_syahrull`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--
/* 
CRUD -> C -> Create 
Create by Syahrul
Create Databases 
*/

Create DATABASE query_syahrul;
USE query_syahrul;

-- Create Table
CREATE TABLE `siswa` (
  `id_siswa` int(10) NOT NULL AUTO_INCREMENT,
  `nisn` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `kelas` ENUM ('10', '11', '12'),
  `no_telepon` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY (`nisn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Create Index
CREATE INDEX idx_nama ON siswa (nama);

-- Function hash password SHA-256
CREATE FUNCTION hash_password(input_password VARCHAR(255))
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
RETURN SHA2(input_password, 256)
END;

-- Create Procedure
CREATE PROCEDURE tambah_siswa (
    IN nama_siswa VARCHAR(100), 
    IN nisn_siswa VARCHAR(10), 
    IN jenis_kelamin_siswa ENUM('L', 'P'),
    IN alamat_siswa TEXT, 
    IN kelas_siswa VARCHAR(10), 
    IN no_telepon_siswa VARCHAR(20), 
    IN password_siswa VARCHAR(255)
)
BEGIN
    IF kelas_siswa NOT IN ('10', '11', '12') THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Kelas hanya terdiri dari 10, 11, 12'
    END IF;

    INSERT INTO siswa (nama, nisn, jenis_kelamin, alamat, kelas, no_telepon, hash_password(password)) 
    VALUES (nama_siswa, nisn_siswa, jenis_kelamin_siswa, alamat_siswa, kelas_siswa, no_telepon_siswa, password_siswa);
END;

-- Create View
CREATE VIEW view_siswa AS
SELECT 
    id_siswa,
    nisn,
    nama,
    kelas
FROM 
    siswa;
    
-- Create Insert dumping siswa

INSERT INTO `siswa` (`id_siswa`, `nisn`, `nama`, `jenis_kelamin`, `alamat`, `kelas`, `no_telepon`, `password`) VALUES
(1, '909290187', 'syahrul', 'L', 'cempaka', '11', '083820103522', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5'),
(2, '909290187', 'zidan', 'L', 'tegallaja', '11', '08959328903', '960b98f2767a8b4e417f747ad1adea6a438de622c5f46ed163b4d686d7e09c12'),
(3, '728372324', 'hangesa', 'L', 'lebaksari', '11', '0838216217', '49c43ea53c82b6a6950d99293e247ca477b52b7485df5daaca6282a0674ecf46'),
(4, '564738234', 'andy', 'L', 'jl kenanga', '11', '0845682193', '2937013f2181810606b2a799b05bda2849f3e369a20982a4138f0e0a55984ce4'),
(5, '456823902', 'budi', 'L', 'Kp.cina', '10', '0845409455', 'sadaisreihjijsd');

-- ADD Primary KEY
ALTER TABLE `siswa`
ADD PRIMARY KEY (`id_siswa`);

INSERT INTO `jurusan` (`nama_jurusan`) VALUES
(UPPER('RPL')),
(UPPER('TJKT')),
(UPPER('AT')),
(UPPER('BR')),
(UPPER('TEI')),
(UPPER('TKI')),
(UPPER('AXIOO')),
(UPPER('ORACLE')),
(UPPER('GAMELAB'));

INSERT INTO `abc` (`nama_abc`) VALUES 
(UPPER('A')),
(UPPER('B')),
(UPPER('C'));

INSERT INTO `kelas` (`tingkatan`, `id_jurusan`, `id_abc`) VALUES 
('10', 1, 1),
('10', 1, 2),
('10', 2, 1),
('10', 2, 2),
('10', 3, 1),
('10', 3, 2),
('10', 4, 1),
('10', 4, 2),
('10', 5, 1),
('10', 5, 2),
('10', 6, 1),
('10', 6, 2),
('10', 6, 3),
('10', 7, 1),
('10', 9, 1),
('11', 1, 1),
('11', 1, 2),
('11', 2, 1),
('11', 2, 2),
('11', 3, 1),
('11', 3, 2),
('11', 4, 1),
('11', 4, 2),
('11', 5, 1),
('11', 6, 1),
('11', 6, 2),
('11', 7, 1),
('11', 8, 1);

CREATE OR REPLACE VIEW vKelas AS 
 
SELECT k.id_kelas, k.tingkatan, j.nama_jurusan, abc.nama_abc, CONCAT(
    CASE k.tingkatan
    WHEN '10' THEN 'X'
    WHEN '11' THEN 'XI'
    WHEN '12' THEN 'XII'
    ELSE k.tingkatan
    END, ' ', j.nama_jurusan, ' ', abc.nama_abc
) AS nama_kelas
FROM kelas k
JOIN jurusan j ON k.id_jurusan = j.id_jurusan
JOIN abc ON k.id_abc = abc.id_abc
ORDER BY k.id_kelas;

CREATE OR REPLACE VIEW vSiswa AS
SELECT s.id_siswa, s.nisn, s.nama,s.id_kelas, 
CASE s.jenis_kelamin 
WHEN 'L' THEN 'Laki-Laki'
WHEN 'P' THEN 'Perempuan'
ELSE s.jenis_kelamin
END AS jenis_kelamin, s.alamat, vK.nama_kelas AS nama_kelas_s, s.no_telepon 
FROM siswa s
JOIN vKelas vK ON s.id_kelas = vK.id_kelas;

CREATE OR REPLACE VIEW vGuru AS 
SELECT g.id_guru, g.nip, g.nama AS nama_guru_g, g.id_mapel, CASE g.jenis_kelamin
WHEN 'L' THEN 'Laki-Laki'
WHEN 'P' THEN 'Perempuan'
ELSE g.jenis_kelamin
END AS jenis_kelamin , m.nama_mapel AS nama_mapel_g, g.alamat AS alamat_guru_g
FROM guru g
JOIN mapel m ON g.id_mapel = m.id_mapel;

CREATE OR REPLACE VIEW vJadwal AS 
SELECT j.*,h.nama_hari AS nama_hari_j, g.nama AS nama_guru_j, vK.nama_kelas AS nama_kelas_j, m.nama_mapel AS nama_mapel_j
FROM jadwal j
JOIN hari h ON j.id_hari = h.id_hari
JOIN guru g ON j.id_guru = g.id_guru
JOIN vKelas vK ON j.id_kelas = vK.id_kelas
JOIN mapel m ON j.id_mapel = m.id_mapel;

CREATE OR REPLACE VIEW vAbsen AS
SELECT a.id_absen , a.id_jadwal, a.id_jadwal,s.nama AS nama_siswa_a, vJ.nama_mapel_j AS nama_mapel_a, a.waktu, a.tanggal, CASE a.keterangan
WHEN 'H' THEN 'Hadir'
WHEN 'S' THEN 'Sakit'
WHEN 'I' THEN 'Izin'
WHEN 'A' THEN 'Alfa'
WHEN 'T' THEN 'Terlambat'
ELSE a.keterangan
END AS keterangan_a,
a.keterangan
FROM absen A
JOIN siswa s ON a.id_siswa = s.id_siswa
JOIN vJadwal vJ ON a.id_jadwal = vJ.id_jadwal;

CREATE OR REPLACE VIEW vJAdAbsen AS
SELECT j.id_jadwal, m.nama_mapel, j.aktif FROM jadwal j 
JOIN mapel m ON j.id_mapel = m.id_mapel WHERE j.id_hari = DAYOFWEEK(CURDATE());  