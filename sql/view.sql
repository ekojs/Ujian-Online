CREATE VIEW `v_ujian_mapel` AS select `ujian`.`id_ujian` AS `id_ujian`,`ujian`.`nama_ujian` AS `nama_ujian`,`ujian`.`id_mp` AS `id_mp`,`mapel`.`nama_mp` AS `nama_mp`,`ujian`.`tanggal` AS `tanggal`,`ujian`.`waktu` AS `waktu`,`ujian`.`keterangan` AS `keterangan` from (`ujian` join `mapel` on((`ujian`.`id_mp` = `mapel`.`id_mp`)));

INSERT INTO `admin` (`nis`, `nama`, `alamat`, `agama`) VALUES
('kaji_admin', 'ahmad afandi', 'cerme klagen', 'Islam');
