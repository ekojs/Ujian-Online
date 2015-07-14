DROP TRIGGER IF EXISTS `isi_user_admin`;
DELIMITER //
CREATE TRIGGER `isi_user_admin` AFTER INSERT ON `admin`
 FOR EACH ROW begin
insert into user(id_user,password,level) values(new.nis,md5(new.nis),"admin");
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `hapus_data_admin`;
DELIMITER //
CREATE TRIGGER `hapus_data_admin` AFTER DELETE ON `admin`
 FOR EACH ROW begin
delete  from user where user.id_user = old.nis;
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `hapus_ujian`;
DELIMITER //
CREATE TRIGGER `hapus_ujian` AFTER DELETE ON `mapel`
 FOR EACH ROW begin
delete  from ujian where ujian.id_mp = old.id_mp;
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `isi_user`;
DELIMITER //
CREATE TRIGGER `isi_user` AFTER INSERT ON `siswa`
 FOR EACH ROW begin
insert into user(id_user,password,level) values(new.nis,md5(new.nis),"siswa");
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `hapus_semua_data_siswa`;
DELIMITER //
CREATE TRIGGER `hapus_semua_data_siswa` AFTER DELETE ON `siswa`
 FOR EACH ROW begin
delete  from user where user.id_user = old.nis;
delete  from nilai where id_user = old.nis;
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `hapus_pil_jawaban`;
DELIMITER //
CREATE TRIGGER `hapus_pil_jawaban` AFTER DELETE ON `soal`
 FOR EACH ROW begin
delete  from pil_jawaban where pil_jawaban.id_soal = old.id_soal;
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `hapus_soal`;
DELIMITER //
CREATE TRIGGER `hapus_soal` AFTER DELETE ON `ujian`
 FOR EACH ROW begin
delete  from soal where soal.id_ujian = old.id_ujian;
delete  from nilai where nilai.id_ujian = old.id_ujian;
end
//
DELIMITER ;

DROP TRIGGER IF EXISTS `isi_user_guru`;
DELIMITER //
CREATE TRIGGER `isi_user_guru` AFTER INSERT ON `guru`
 FOR EACH ROW begin

insert into user(id_user,password,level) values(new.nis,md5(new.nis),"guru");

end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `hapus_semua_data_guru`;
DELIMITER //
CREATE TRIGGER `hapus_semua_data_guru` AFTER DELETE ON `guru`
 FOR EACH ROW begin
delete  from user where user.id_user = old.nis;
end
//
DELIMITER ;
