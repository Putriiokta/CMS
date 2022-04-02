<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Singlepenelitian
 *
 */
class Singlepenelitian extends CI_Controller {
    
    public function index() {
        // identitas
        $jml_identitas = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($jml_identitas > 0){
            $tersimpan_iden = $this->Mglobals->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'assets/images/no_image.png';
            if(strlen($tersimpan_iden->logo) > 0){
                if(file_exists($tersimpan_iden->logo)){
                    $logo = base_url().substr($tersimpan_iden->logo, 2);
                }
            }
            $data['logo'] = $logo;
            $data['alamat'] = $tersimpan_iden->alamat;
            $data['tlp'] = $tersimpan_iden->tlp;
            $data['email'] = $tersimpan_iden->email;
            
        }else{
            $data['logo'] = base_url().'assets/images/no_image.png';
            $data['alamat'] = '';
            $data['tlp'] = '';
            $data['email'] = '';
        }
        
        // about
        $jml_tentang = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM tentang;")->jml;
        if($jml_tentang > 0){
            $tersimpan_tentang = $this->Mglobals->getAllQR("select * from tentang;");
            $data['tentang'] = $tersimpan_tentang->pesan;
        }else{
            $data['tentang'] = "";
        }
        
        // media sosial
        $jml = $this->Mglobals->getAllQR("select count(*) as jml from medsos")->jml;
        if($jml > 0){
            $tersimpan_med = $this->Mglobals->getAllQR("select * from medsos");
            $data['tw'] = $tersimpan_med->tw;
            $data['ig'] = $tersimpan_med->ig;
            $data['fb'] = $tersimpan_med->fb;
            $data['lk'] = $tersimpan_med->lk;
            
        }else{
            $data['tw'] = "";
            $data['ig'] = "";
            $data['fb'] = "";
            $data['lk'] = "";
        }
        
        $temp = $this->uri->segment(3);
        if(strlen($temp) > 0){
            $kode = $this->modul->dekrip_url($temp);
            $jml = $this->Mglobals->getAllQR("select count(*) as jml from penelitian where idpenelitian = '".$kode."';")->jml;
            if($jml > 0){
                $penelitian = $this->Mglobals->getAllQR("select a.*, date_format(a.tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt, b.nama_kategori from penelitian a, kategori_penelitian b where a.idkategori = b.idkategori and a.idpenelitian = '".$kode."';");
                $defthumb = base_url().'assets/img/noimg.jpg';
                if(strlen($penelitian->thumbnail) > 0){
                    if(file_exists($penelitian->thumbnail)){
                        $defthumb = base_url().substr($penelitian->thumbnail, 2);
                    }
                }
                
                $data['thumb'] = $defthumb;
                $data['kode'] = $penelitian->idpenelitian;
                $data['judul'] = $penelitian->judul;
                $data['tanggal'] = $penelitian->tgl;
                $data['penulis'] = "Administrator";
                $data['foto_penulis'] = $data['logo'];
                $data['konten'] = $penelitian->sinopsis;
                $data['kategori'] = $penelitian->nama_kategori;
                $data['keyword'] = $penelitian->katakunci;
                $data['jml_komentar'] = $this->Mglobals->getAllQR("select count(*) as jml from penelitian_komentar where idpenelitian = '".$penelitian->idpenelitian."';")->jml;
                if(strlen($penelitian->sandi) > 0){
                    $data['rahasia'] = "ya";
                }else{
                    $data['rahasia'] = "tidak";
                }
                
                // lainnya
                $data['lainnya'] = $this->Mglobals->getAllQ("select *, date_format(tanggal, '%d %M %Y') as tgl from penelitian where idpenelitian <> '".$penelitian->idpenelitian."' order by tanggal desc;");
                
                // dokumen
                $data['dokumen'] = $this->Mglobals->getAllQ("SELECT * FROM dokumen where idpenelitian = '".$penelitian->idpenelitian."';");
                
                $this->load->view('frontend/singlepenelitian', $data);
            }else{
                $this->modul->halaman("welcome");
            }
        }else{
            $this->modul->halaman("welcome");
        } 
    }
    
    public function ajax_komentar() {
        $kode = $this->uri->segment(3);
        
        $str = '';
        $listkomentar = $this->Mglobals->getAllQ("SELECT email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM penelitian_komentar where idpenelitian = '".$kode."';");
        foreach ($listkomentar->result() as $row) {
            $str .= '<div class="d-flex">
                        <div>
                            <h5>'.$this->modul->antixss($row->nama).'</h5>
                            <time>'.$row->tgl.' '.$row->wkt.'</time>
                            <p>'.$this->modul->antixss($row->komentar).'</p>
                        </div>
                    </div>
                    <hr>';
        }
        echo $str;
    }
    
    public function proseskomentar() {
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
        echo json_encode(array("status" => $status));
    }
    
    public function unduhfile() {
        if($this->nativesession->get('logged_siswa')){
            $ses = $this->nativesession->get('logged_siswa');
            $idusers = $ses['idusers'];
            
            $kode = $this->uri->segment(3);
            
            // mencari kode penelitian dari iddokumen
            $idpenelitian = $this->Mglobals->getAllQR("SELECT idpenelitian FROM dokumen where iddokumen = '".$kode."';")->idpenelitian;
            
            // cek dia sudah download brp x hari ini
            $jml_download = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM logdownload where idsiswa = '".$idusers."' and tanggal = '".$this->modul->TanggalSekarang()."';")->jml;
            if($jml_download > 2){
                $this->modul->pesan_halaman("Batas download 3 penelitian setiap hari", "listpenelitian");
            }else{
                // simpan log
                $data = array(
                    'idlog' => $this->Mglobals->autokode("L","idlog","logdownload", 2, 7),
                    'idsiswa' => $idusers,
                    'tanggal' => $this->modul->TanggalWaktu(),
                    'idpenelitian' => $idpenelitian,
                    'iddokumen' => $kode
                );
                $simpan = $this->Mglobals->add("logdownload",$data);
                if($simpan == 1){
                    $tmt2 = $this->Mglobals->getAllQR("select path from dokumen where iddokumen = '".$kode."';")->path;
                    
                    $this->load->helper('download');
                    force_download($tmt2, null);
                }else{
                    $status = "Gagal menyimpan log unduh";
                    $this->modul->pesan_halaman($status, "listpenelitian");
                }
            }
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ceksandi() {
        if($this->nativesession->get('logged_siswa')){
            $idpenelitian = $this->input->post('kode');
            $sandi_input = $this->input->post('sandi');
            
            // mencari password tersimpan
            $sandi_tersimpan = $this->Mglobals->getAllQR("select sandi from penelitian where idpenelitian = '".$idpenelitian."';")->sandi;
            if($sandi_input == $sandi_tersimpan){
                $status = "oke";
            }else{
                $status = "Sandi dokumen salah";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function loadgambar() {
        $idpenelitian = $this->uri->segment(3);
        // load data
        $hasil = '<table style="width : 100%;">';
        $list = $this->Mglobals->getAllQ("SELECT path FROM dokumen_gambar where idpenelitian = '".$idpenelitian."';");
        foreach ($list->result() as $row) {
            $hasil .= '<tr><td><img style="pointer-events: none;" class="img-thumbnail" src="'.base_url().substr($row->path, 2).'"></td></tr>';
        }
        $hasil .= '</table>';
        echo json_encode(array("hasil" => $hasil));
    }
}
