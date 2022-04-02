-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2022 at 11:46 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `idblog` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `konten` longtext DEFAULT NULL,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `thumb` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`idblog`, `tanggal`, `judul`, `konten`, `idusers`, `thumb`) VALUES
('B00001', '2022-04-02', 'AS Tambah Bantuan untuk Ukraina, Termasuk Drone Bunuh Diri Switchblade  Baca artikel detiknews, \"AS Tambah Bantuan untuk Ukraina, Termasuk Drone Bunuh', '<p>Jakarta - Departemen Pertahanan Amerika Serikat atau Pentagon mengumumkan pada Jumat (1/4) waktu setempat, bahwa pihaknya mengalokasikan US$ 300 juta dalam \"bantuan keamanan\" untuk Ukraina guna meningkatkan kemampuan pertahanan negara itu.<br />Bantuan ini akan menambah bantuan senilai US$ 1,6 miliar yang telah diberikan Washington ke Ukraina sejak Rusia menginvasi pada akhir Februari lalu.<br /><br />Dilansir dari kantor berita AFP, Sabtu (2/4/2022), paket bantuan tersebut mencakup sistem roket berpemandu laser, drone bunuh diri Switchblade, amunisi, perangkat penglihatan malam, sistem komunikasi taktis aman, suplai medis, dan kendaraan lapis baja.<br /><br /><br /></p>', 'U00001', './assets/img/e39748059370ab3daa467a44578e10ef.jpeg'),
('B00002', '2022-04-02', 'Selama Ramadhan, Polda Metro Jaya Gelar Vaksinasi Booster di GBK dan Pasar Tanah Abang pada Akhir Pekan  Artikel ini telah tayang di Kompas.com dengan', '<p>Polda Metro Jaya menggelar vaksinasi booster&nbsp;untuk Covid-19 pada akhir pekan selama Ramadhan 1443 Hijriah. Kegiatan tersebut dilaksanakan di Stadion Gelora Bung Karno (GBK) dan Pasar Tanah Abang Blok A, Jakarta Pusat hingga sepekan sebelum Lebaran. Kapolda Metro Jaya, Irjen Fadil Imran menjelaskan, vaksinasi booster setiap akhir pekan selama Ramadhan dilakukan untuk memastikan seluruh warga mendapatkan penyuntikan vaksin Covid-19. \"Tim Polda Metro Jaya bergerak memastikan seluruh warga di wilayah hukum Polda Metro sudah mendapatkan vaksinasi booster (penguat),\" ujar Fadil Imran dalam keterangannya, Sabtu (2/4/2022).<br />Menurut Fadil, vaksinasi booster dapat meminimal potensi penularan Covid-19 di masyarakat, sekaligus mengantisipasi terjadinya lonjakan kasus Covid-19. Dengan begitu, masyarakat dapat menjalankan ibadah selama Ramadhan hingga Hari Raya Lebaran 1443 Hijriah dengan nyaman dan khidmat. \"Kami yakin, vaksinasi menjadi jalan melindungi masyarakat dari biaya tambahan akibat sakit dan tidak dapat beraktivitas ekonomi, misalnya,&rdquo; ujar Fadil. Dia menambahkan, pada masa pandemi Covid-19 saat ini Polda Metro Jaya tidak hanya bertugas menjaga keamanan dan ketertiban. Kepolisian juga diperintahkan membantu percepatan vaksinasi dan menegakkan protokol kesehatan untuk menekan kasus penularan Covid-19. \"Sesuai arahan Kapolri, kami semenjak 2021 berupaya konsisten, tidak hanya menjaga ketertiban dan keamanan, tetapi melakukan percepatan vaksinasi dan praktik kepatuhan prokes,\" ungkap Fadil. Sementara itu, Kabid Humas Polda Metro Jaya Kombes Endra Zulpan mengatakan, kegiatan vaksinasi booster akhir di pekan di dua lokasi tersebut akan berlangsung hingga pekan ketiga bulan suci Ramadhan. \"Kegiatan vaksinasi booster akhir pekan ini berlanjut sampai minggu ketiga bulan suci Ramadhan,\" ucap Zulpan.<br /><br /><br /></p>', 'U00001', './assets/img/f0ef463cacb921fb5173863b8fa36679.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `blog_komentar`
--

CREATE TABLE `blog_komentar` (
  `idblog_komentar` varchar(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `komentar` text NOT NULL,
  `idblog` varchar(6) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `kode` varchar(6) NOT NULL DEFAULT '0',
  `instansi` varchar(255) NOT NULL,
  `slogan` varchar(100) DEFAULT NULL,
  `tahun` float DEFAULT NULL,
  `pimpinan` varchar(150) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kdpos` varchar(7) DEFAULT NULL,
  `tlp` varchar(15) DEFAULT NULL,
  `fax` varchar(35) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `logo` longtext DEFAULT NULL,
  `lat` varchar(45) DEFAULT NULL,
  `lon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`kode`, `instansi`, `slogan`, `tahun`, `pimpinan`, `alamat`, `kdpos`, `tlp`, `fax`, `website`, `email`, `logo`, `lat`, `lon`) VALUES
('I00001', 'Dinamika', 'horee', 0, 'pak rampa', 'Jl. Kedung Baruk 98 Surabaya', '3657257', '08121626086', '', 'https://dinamika.ac.id/', 'official@dinamika.ac.id', './assets/img/bae2ba471604f9ee3e4b180053aba3a4.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medsos`
--

CREATE TABLE `medsos` (
  `idmedsos` varchar(6) NOT NULL,
  `tw` varchar(150) NOT NULL,
  `fb` varchar(150) NOT NULL,
  `ig` varchar(150) NOT NULL,
  `lk` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medsos`
--

INSERT INTO `medsos` (`idmedsos`, `tw`, `fb`, `ig`, `lk`) VALUES
('M00001', 'https://www.google.com/', 'https://www.google.com/', 'https://www.google.com/', 'https://www.google.com/');

-- --------------------------------------------------------

--
-- Table structure for table `tentang`
--

CREATE TABLE `tentang` (
  `idtentang` varchar(6) NOT NULL,
  `pesan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tentang`
--

INSERT INTO `tentang` (`idtentang`, `pesan`) VALUES
('T00001', 'Universitas Dinamika adalah sebuah perguruan tinggi swasta berbasis teknologi yang terletak di Kota Surabaya, Jawa Timur. Sebelum berganti nama, dahulunya Universitas Dinamika bernama Institut Bisnis dan Informatika Stikom Surabaya.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(35) CHARACTER SET utf8mb4 NOT NULL,
  `pass` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  `nama` varchar(45) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `email`, `pass`, `nama`) VALUES
('U00001', 'azzahoktaviann@gmail.com', 'aGtq', 'putriii');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`idblog`),
  ADD KEY `FK_blog_users` (`idusers`);

--
-- Indexes for table `blog_komentar`
--
ALTER TABLE `blog_komentar`
  ADD PRIMARY KEY (`idblog_komentar`),
  ADD KEY `FK_blog_komentar_key` (`idblog`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `medsos`
--
ALTER TABLE `medsos`
  ADD PRIMARY KEY (`idmedsos`);

--
-- Indexes for table `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`idtentang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idusers`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
