<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
            $data['logo'] = base_url().'assets/images/noimg.jpg';
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
        //$data['jmlslider'] = $this->Mglobals->getAllQR("select count(*) as jml from slider_tentang")->jml;
        //$data['slider'] = $this->Mglobals->getAll("slider_tentang");
        
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
        
        $data['berita'] = $this->Mglobals->getAllQ("select *, date_format(tanggal, '%d %M %Y') as tgl from blog order by idblog desc limit 3;");
        
        $this->load->view('frontend/index', $data);
    }
    
    public function kirimpesan() {
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
        echo json_encode(array("status" => $status));
    }
}
