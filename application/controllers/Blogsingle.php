<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blogsingle
 *
 */
class Blogsingle extends CI_Controller {
    
    public function index() {
        // identitas
        $jml_identitas = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($jml_identitas > 0){
            $tersimpan_iden = $this->Mglobals->getAllQR("SELECT logo, alamat, email, tlp FROM identitas;");
            $logo = base_url().'assets/img/noimg.jpg';
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
            $data['logo'] = base_url().'assets/img/noimg.jpg';
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
            $jml = $this->Mglobals->getAllQR("select count(*) as jml from blog where idblog = '".$kode."';")->jml;
            if($jml > 0){
                $tersimpan_berita = $this->Mglobals->getAllQR("select a.*, date_format(tanggal, '%d %M %Y') as tgl, b.nama from blog a, users b where a.idusers = b.idusers and a.idblog = '".$kode."';");
                $defthumb = base_url().'assets/img/noimg.jpg';
                if(strlen($tersimpan_berita->thumb) > 0){
                    if(file_exists($tersimpan_berita->thumb)){
                        $defthumb = base_url().substr($tersimpan_berita->thumb, 2);
                    }
                }
                $data['thumb'] = $defthumb;
                $data['kode'] = $tersimpan_berita->idblog;
                $data['judul'] = $tersimpan_berita->judul;
                $data['tanggal'] = $tersimpan_berita->tgl;
                $data['penulis'] = $tersimpan_berita->nama;
                $data['konten'] = $tersimpan_berita->konten;
                $data['jml_komentar'] = $this->Mglobals->getAllQR("select count(*) as jml from blog_komentar where idblog = '".$tersimpan_berita->idblog."';")->jml;
                
                // berita lainnya
                $data['beritalain'] = $this->Mglobals->getAllQ("select *, date_format(tanggal,'%d %M %Y') as tgl from blog where idblog <> '".$tersimpan_berita->idblog."';");
                
                
                $this->load->view('frontend/blogsingle', $data);
            }else{
                $this->modul->halaman("welcome");
            }
        }else{
            $this->modul->halaman("welcome");
        }
    }
    
    public function ajax_komentar() {
        $idblog = $this->uri->segment(3);
        
        $str = '';
        $listkomentar = $this->Mglobals->getAllQ("SELECT email, nama, komentar, date_format(tanggal, '%d %M %Y') as tgl, time(tanggal) as wkt FROM blog_komentar where idblog = '".$idblog."';");
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
        echo json_encode(array("status" => $status));
    }
}
