<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Webservice
 *
 */
class Ws extends CI_Controller {
    
    public function index(){
        echo 'Directory access is forbidden.';
    }
    
    public function slider() {
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $list = $this->Mglobals->getAllQ("SELECT path, judul, keterangan FROM slider_tentang;");
            foreach ($list->result() as $row) {
                array_push($result, array(
                    'status' => "oke",
                    'gambar' => base_url().substr($row->path, 2),
                    'judul' => $row->judul,
                    'keterangan' => $row->keterangan
                ));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }
	
    public function about_lppm(){
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
            if($jml > 0){
                $status = $this->Mglobals->getAllQR("SELECT pesan FROM tentang;")->pesan;
            }else{
                $status = "";
            }
            array_push($result, array('status' => $status));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }
	
    public function jenis_penelitian(){
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $listkelas = $this->Mglobals->getAll("kelas");
            foreach($listkelas->result() as $row){
                $jml = $this->Mglobals->getAllQR("select count(*) as jml from penelitian a, siswa b where a.idsiswa = b.idsiswa and b.idkelas = '".$row->idkelas."';")->jml;
                array_push($result, array(
                    'status' => "ok",
                    'kode_kelas' => $row->idkelas,
                    'nama_kelas' => $row->nama_kelas,
                    'jumlah' => $jml
                ));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }
	
    public function berita(){
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $list = $this->Mglobals->getAllQ("select a.*, date_format(a.tanggal, '%d %M %Y') as tgl, b.nama from blog a, users b where a.idusers = b.idusers order by a.idblog desc limit 6;");
            foreach($list->result() as $row){

                $def = base_url().'assets/img/noimg.jpg';
                if(strlen($row->thumb) > 0){
                    if(file_exists($row->thumb)){
                        $def = base_url().substr($row->thumb, 2);
                    }
                }

                array_push($result, array(
                    'status' => "ok",
                    'kode' => $row->idblog,
                    'tanggal' => $row->tgl,
                    'judul' => $row->judul,
                    'gambar' => $def,
                    'deskripsi' => $row->konten,
                    'nama_uploader' => $row->nama
                ));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));	
    }

	public function penelitian(){
		$result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
			$list = $this->Mglobals->getAllQ("select a.*, b.nama, date_format(a.tanggal, '%d %M %Y') as tgl, b.foto, c.nama_kategori from penelitian a, siswa b, kategori_penelitian c where a.idkategori = c.idkategori and a.idsiswa = b.idsiswa order by a.tanggal desc limit 50;");
			foreach($list->result() as $row){				
				$def = base_url().'assets/img/noimg.jpg';
				if(strlen($row->thumbnail) > 0){
					if(file_exists($row->thumbnail)){
						$def = base_url().substr($row->thumbnail, 2);
					}
				}
				
				$def_foto = base_url().'assets/img/noimg.jpg';
				if(strlen($row->foto) > 0){
					if(file_exists($row->foto)){
						$def_foto = base_url().substr($row->foto, 2);
					}
				}
				
				array_push($result, array(
					'status' => "ok",
					'kode' => $row->idpenelitian,
					'judul' => $row->judul,
					'nama' => $row->nama,
					'gambar' => $def,
					'tgl' => $row->tgl,
					'deskripsi' => $row->sinopsis,
					'foto' => $def_foto,
                    'katakunci' => $row->katakunci,
                    'kategori' => $row->nama_kategori
				));
			}
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function getKontak(){
		$result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {

			$jml_identitas = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
			if($jml_identitas > 0){
				$tersimpan_iden = $this->Mglobals->getAllQR("SELECT alamat, email, tlp FROM identitas;");

				$alamat = $tersimpan_iden->alamat;
				$tlp = $tersimpan_iden->tlp;
				$email = $tersimpan_iden->email;
				
			}else{
				$alamat = "";
				$tlp = "";
				$email = "";
			}

			array_push($result, array(
				'status' => "ok",
				'alamat' => $alamat,
				'tlp' => $tlp,
				'email' => $email
			));

        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
	}

	public function kelas() {
		$result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
			$list = $this->Mglobals->getAll("kelas");
            foreach ($list->result() as $row) {
				array_push($result, array(
					'status' => "ok",
					'kode_kelas' => $row->idkelas,
					'nama_kelas' => $row->nama_kelas
				));
            }
		} else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

	public function kategori_penelitian() {
		$result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
			$list = $this->Mglobals->getAll("kategori_penelitian");
            foreach ($list->result() as $row) {
				array_push($result, array(
					'status' => "ok",
					'kode_kat' => $row->idkategori,
					'nama_kat' => $row->nama_kategori
				));
            }
		} else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

	public function penelitianBySearch(){
		$result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
			$judul = $this->input->post('judul');
			$katakunci = $this->input->post('katakunci');
			$inputkategori = $this->input->post('inputkategori');
			$inputkelas = $this->input->post('inputkelas');

			$list = $this->Mglobals->getAllQ("select a.*, b.nama, date_format(a.tanggal, '%d %M %Y') as tgl, b.foto from penelitian a, siswa b where a.judul like '%".$judul."%' and a.katakunci like '%".$katakunci."%' and a.idkategori like '%".$inputkategori."%' and b.idkelas like '%".$inputkelas."%' and a.idsiswa = b.idsiswa order by a.tanggal desc limit 50;");
			foreach($list->result() as $row){				
				$def = base_url().'assets/img/noimg.jpg';
				if(strlen($row->thumbnail) > 0){
					if(file_exists($row->thumbnail)){
						$def = base_url().substr($row->thumbnail, 2);
					}
				}

				$def_foto = base_url().'assets/img/noimg.jpg';
				if(strlen($row->foto) > 0){
					if(file_exists($row->foto)){
						$def_foto = base_url().substr($row->foto, 2);
					}
				}
				
				array_push($result, array(
					'status' => "ok",
					'kode' => $row->idpenelitian,
					'judul' => $row->judul,
					'nama' => $row->nama,
					'gambar' => $def,
					'tgl' => $row->tgl,
					'deskripsi' => $row->sinopsis,
					'foto' => $def_foto
				));
			}
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
	}

    public function kirimpesan() {
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $data = array(
                'idinbox' => $this->Mglobals->autokode("I","idinbox","inbox", 2, 7),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'judul' => $this->input->post('judul'),
                'pesan' => $this->input->post('pesan')
            );
            $simpan = $this->Mglobals->add("inbox",$data);
            if($simpan == 1){
                $status = "Pesan tersimpan";
            }else{
                $status = "Pesan gagal tersimpan";
            }
            array_push($result, array('status' => $status));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function komentar_penelitian(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $idpenelitian = $this->input->post('idpenelitian');
            $listkomentar = $this->Mglobals->getAllQ("SELECT idkomen, email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM penelitian_komentar where idpenelitian = '".$idpenelitian."';");
            foreach ($listkomentar->result() as $row) {
                array_push($result, array(
					'status' => "ok",
                    'kode' => $row->idkomen,
					'nama' => $row->nama,
					'tgl' => $row->tgl,
					'waktu' => $row->wkt,
					'komentar' => $row->komentar
				));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
        
    }

    public function simpan_komentar(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $data = array(
                'idkomen' => $this->Mglobals->autokode("K","idkomen","penelitian_komentar", 2, 7),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'komentar' => $this->input->post('komentar'),
                'tanggal' => $this->modul->TanggalWaktu(),
                'idpenelitian' => $this->input->post('kode')
            );
            $simpan = $this->Mglobals->add("penelitian_komentar",$data);
            if($simpan == 1){
                $status = "Komentar tersimpan";
            }else{
                $status = "Komentar gagal tersimpan";
            }
            array_push($result, array('status' => $status));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function getKomentarBerita(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $idblog = $this->input->post('idberita');
            $listkomentar = $this->Mglobals->getAllQ("SELECT idblog_komentar, email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM blog_komentar where idblog = '".$idblog."';");
            foreach ($listkomentar->result() as $row) {
                array_push($result, array(
					'status' => "ok",
                    'kode' => $row->idblog_komentar,
					'nama' => $row->nama,
					'tgl' => $row->tgl,
					'waktu' => $row->wkt,
					'komentar' => $row->komentar
				));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function simpan_komentar_berita(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $data = array(
                'idblog_komentar' => $this->Mglobals->autokode("K","idblog_komentar","blog_komentar", 2, 7),
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'komentar' => $this->input->post('komentar'),
                'idblog' => $this->input->post('kode'),
                'tanggal' => $this->modul->TanggalWaktu()
            );
            $simpan = $this->Mglobals->add("blog_komentar",$data);
            if($simpan == 1){
                $status = "Komentar tersimpan";
            }else{
                $status = "Komentar gagal tersimpan";
            }
            array_push($result, array('status' => $status));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function getDokumenPenelitian(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $idpenelitian = $this->input->post('idpenelitian');
			// mencari password dokumen
			$pass_dokumen = $this->Mglobals->getAllQR("SELECT sandi FROM penelitian where idpenelitian = '".$idpenelitian."';")->sandi;
			
            $list = $this->Mglobals->getAllQ("SELECT * FROM dokumen where idpenelitian = '".$idpenelitian."';");
            foreach ($list->result() as $row) {
                array_push($result, array(
					'status' => "ok",
                    'kode' => $row->iddokumen,
					'judul' => $row->judul_dok,
					'path' => base_url().substr($row->path,2),
					'sandi' => $pass_dokumen
				));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function login(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $user = strtolower(trim($this->input->post('nrp')));
            $pass = trim($this->input->post('pass'));    
            $enkrip_pass = $this->modul->enkrip_pass($pass);

            $jml_siswa = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM siswa where nrp = '".$user."';")->jml;
            if($jml_siswa > 0){
                $jml2 = $this->Mglobals->getAllQR("select count(*) as jml from siswa where nrp = '".$user."' and pass = '".$enkrip_pass."';")->jml;
                if($jml2 > 0){
                    $row = $this->Mglobals->getAllQR("select a.idsiswa, a.nrp, a.nama, b.nama_pangkat, c.nama_korps from siswa a, pangkat b, korps c where a.nrp = '".$user."' and a.idpangkat = b.idpangkat and a.idkorps = c.idkorps;");
                    
                    array_push($result, array(
                        'status' => "ok",
                        'idsiswa' => $row->idsiswa,
                        'nrp' => $row->nrp,
                        'nama' => $row->nama,
                        'pangkat' => $row->nama_pangkat,
                        'korps' => $row->nama_korps
                    ));

                }else{
                    $status = "Anda tidak berhak mengakses !";
                    array_push($result, array('status' => "Access reject"));
                }
            }else{
                $status = "Maaf, user tidak ditemukan !";
                array_push($result, array('status' => "Access reject"));
            }
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function getProfile(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $idsiswa = $this->input->post('idsiswa');
            
            $profile = $this->Mglobals->getAllQR("select nama, nrp, email, a.idpangkat, b.nama_pangkat, a.idkorps, c.nama_korps, foto from siswa a, pangkat b, korps c where a.idpangkat = b.idpangkat and a.idkorps = c.idkorps and idsiswa = '".$idsiswa."';");
            $def_foto = base_url().'assets/img/noimg.jpg';
            if(strlen($profile->foto) > 0){
                if(file_exists($profile->foto)){
                    $def_foto = base_url().substr($profile->foto, 2);
                }
            }
            
            array_push($result, array(
                'status' => "ok", 
                'nrp' => $profile->nrp, 
                'nama' => $profile->nama,
                'email' => $profile->email,
                'idkorps' => $profile->idkorps,
                'nama_korps' => $profile->nama_korps,
                'idpangkat' => $profile->idpangkat,
                'nama_pangkat' => $profile->nama_pangkat,
                'foto' => $def_foto
            ));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function changepass(){
        $result = array();
        $token = $this->input->post('token');
		if ($token == 'prAmLPPM') {
            $idsiswa = $this->input->post('idsiswa');

            $lama = $this->modul->enkrip_pass($this->input->post('lama'));
            $lama_db = $this->Mglobals->getAllQR("select pass from siswa where idsiswa = '".$idsiswa."';")->pass;
            
            if($lama == $lama_db){
                $data = array(
                    'pass' => $this->modul->enkrip_pass($this->input->post('baru'))
                );
                $kond['idsiswa'] = $idsiswa;
                $update = $this->Mglobals->update("siswa",$data,$kond);
                if($update == 1){
                    $status = "Password tersimpan";
                }else{
                    $status = "Password gagal tersimpan";
                }
            }else{
                $status = "Passsword lama tidak sesuai";
            }
            array_push($result, array('status' => $status));
        } else {
            array_push($result, array('status' => "Access reject"));
        }
        echo json_encode(array("result" => $result));
    }

    public function upload_foto(){
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $dir = "./assets/img/";
            if (isset($_FILES['image']['name'])) {
                $file_name_temp = basename($_FILES['image']['name']);
                $file_name = preg_replace("/[^a-zA-Z0-9.]/", "", $file_name_temp);
                $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg') {
                    if ($_FILES["image"]["size"] < 4000001) {
                        $file = $dir . $file_name;

                        // hapus file jika ada yang lama
                        $lawas = $this->Mglobals->getAllQR("select foto from siswa where idsiswa = '" . $this->input->post('idsiswa') . "';")->foto;
                        if (strlen($lawas) > 0) {
                            if (file_exists($lawas)) {
                                unlink($lawas);
                            }
                        }

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                            $data = array(
                                'foto' => $dir . $file_name
                            );
                            $kond['idsiswa'] = $this->input->post('idsiswa');
                            $update = $this->Mglobals->update("siswa", $data, $kond);
                            if ($update == 1) {
                                $status = "Foto tersimpan";
                            } else {
                                $status = "Foto gagal terupdate";
                            }
                        } else {
                            $status = "Terjadi kesesalahan, silakan coba lagi";
                        }
                    } else {
                        $status = "Batas ukuran file 4 MB";
                    }
                } else {
                    $status = "Hanya mendukung format gambar .png, .jpg and .jpeg";
                }
            } else {
                $status = "Silakan mencoba dengan metode POST";
            }
        } else {
            $status = "token ditolak";
        }
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }

    public function ceklog(){
        $result = array();
        $token = $this->input->post('token');
        if ($token == 'prAmLPPM') {
            $idusers = $this->input->post('idusers');
            $iddokumen = $this->input->post('iddokumen');
            // mencari kode penelitian dari iddokumen
            $idpenelitian = $this->Mglobals->getAllQR("SELECT idpenelitian FROM dokumen where iddokumen = '".$iddokumen."';")->idpenelitian;
            
            // cek dia sudah download brp x hari ini
            $jml_download = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM logdownload where idsiswa = '".$idusers."' and tanggal = '".$this->modul->TanggalSekarang()."';")->jml;
            if($jml_download > 2){
                $status = "Batas download 3 penelitian setiap hari";
            }else{
                // simpan log
                $data = array(
                    'idlog' => $this->Mglobals->autokode("L","idlog","logdownload", 2, 7),
                    'idsiswa' => $idusers,
                    'tanggal' => $this->modul->TanggalWaktu(),
                    'idpenelitian' => $idpenelitian,
                    'iddokumen' => $iddokumen
                );
                $simpan = $this->Mglobals->add("logdownload",$data);
                if($simpan == 1){
                    $status = "oke";
                }else{
                    $status = "Gagal menyimpan log unduh";
                }
            }
        } else {
            $status = "token ditolak";
        }
        array_push($result, array('status' => $status));
        echo json_encode(array("result" => $result));
    }
}
