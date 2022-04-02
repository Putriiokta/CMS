<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Identitas
 *
 */
class Identitas extends CI_Controller{
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['email'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $jml_identitas = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->Mglobals->getAllQR("SELECT * FROM identitas;");
                $data['instansi'] = $tersimpan->instansi;
                $data['slogan'] = $tersimpan->slogan;
                $data['tahun'] = $tersimpan->tahun;
                $data['pimpinan'] = $tersimpan->pimpinan;
                $data['alamat'] = $tersimpan->alamat;
                $data['kdpos'] = $tersimpan->kdpos;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'assets/img/noimg.jpg';
                if(strlen($tersimpan->logo) > 0){
                    if(file_exists($tersimpan->logo)){
                        $deflogo = base_url().substr($tersimpan->logo, 2);
                    }
                }
                $data['logo'] = $deflogo;
                $data['lat'] = $tersimpan->lat;
                $data['lon'] = $tersimpan->lon;
                $data['email'] = $tersimpan->email;
                
            }else{
                $data['instansi'] = "";
                $data['slogan'] = "";
                $data['tahun'] = "";
                $data['pimpinan'] = "";
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'assets/img/noimg.jpg';
                $data['lat'] = "";
                $data['lon'] = "";
                $data['email'] = "";
            }
                
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/identitas/index');
            $this->load->view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $config['upload_path'] = './assets/temp/';
            $config['upload_newpath'] = './assets/img/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = TRUE;
            $config['max_size'] = '3024'; //3 MB
            
            $mode = "simpan";
            $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml > 0){
                $mode = "update";
            }

            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    if($mode == "simpan"){
                        $status = $this->simpandenganfoto($config);
                    }else if($mode == "update"){
                        $status = $this->updatedenganfoto($config);
                    }
                }
            }else{
                if($mode == "simpan"){
                    $status = $this->simpantanpafoto();
                }else if($mode == "update"){
                    $status = $this->updatetanpafoto();
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpandenganfoto($config) {
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'kode' => $this->Mglobals->autokode('I','kode', 'identitas', 2, 7),
                    'instansi' => $this->input->post('nama'),
                    'slogan' => $this->input->post('slogan'),
                    'tahun' => $this->input->post('tahun'),
                    'pimpinan' => $this->input->post('pimpinan'),
                    'alamat' => $this->input->post('alamat'),
                    'kdpos' => $this->input->post('kdpos'),
                    'tlp' => $this->input->post('tlp'),
                    'fax' => $this->input->post('fax'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('web'),
                    'logo' => $newpath,
                    'lat' => $this->input->post('lat'),
                    'lon' => $this->input->post('lon')
                );
                $simpan = $this->Mglobals->add("identitas",$data);
                if($simpan == 1){
                    unlink($path);
                    $status = "Identitas tersimpan";
                }else{
                    $status = "Identitas gagal tersimpan";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function updatedenganfoto($config) {
        $logo = $this->Mglobals->getAllQR("SELECT logo FROM identitas;")->logo;
        if(strlen($logo) > 0){
            if(file_exists($logo)){
                unlink($logo);
            }
        }
        
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {

            $datafile = $this->upload->data();
            $path = $config['upload_path'].$datafile['file_name'];
            $newpath = $config['upload_newpath'].$datafile['file_name'];

            $resize_foto = $this->resizeImage($path, $newpath);
            if($resize_foto){
                $data = array(
                    'instansi' => $this->input->post('nama'),
                    'slogan' => $this->input->post('slogan'),
                    'tahun' => $this->input->post('tahun'),
                    'pimpinan' => $this->input->post('pimpinan'),
                    'alamat' => $this->input->post('alamat'),
                    'kdpos' => $this->input->post('kdpos'),
                    'tlp' => $this->input->post('tlp'),
                    'fax' => $this->input->post('fax'),
                    'email' => $this->input->post('email'),
                    'website' => $this->input->post('web'),
                    'lat' => $this->input->post('lat'),
                    'lon' => $this->input->post('lon'),
                    'logo' => $newpath
                );
                $update = $this->Mglobals->updateNK("identitas",$data);
                if($update == 1){
                    unlink($path);
                    $status = "Identitas terupdate";
                }else{
                    $status = "Identitas gagal terupdate";
                }
            }else{
                $status = "Resize foto gagal";
            }
        } else {
            $status = $this->upload->display_errors();
        }
        return $status;
    }
    
    private function simpantanpafoto() {
        $data = array(
            'kode' => $this->Mglobals->autokode('I','kode', 'identitas', 2, 7),
            'instansi' => $this->input->post('nama'),
            'slogan' => $this->input->post('slogan'),
            'tahun' => $this->input->post('tahun'),
            'pimpinan' => $this->input->post('pimpinan'),
            'alamat' => $this->input->post('alamat'),
            'kdpos' => $this->input->post('kdpos'),
            'tlp' => $this->input->post('tlp'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('web'),
            'logo' => '',
            'lat' => $this->input->post('lat'),
            'lon' => $this->input->post('lon')
        );
        $simpan = $this->Mglobals->add("identitas",$data);
        if($simpan == 1){
            $status = "Identitas tersimpan";
        }else{
            $status = "Identitas gagal tersimpan";
        }
        return $status;
    }
    
    private function updatetanpafoto() {
        $data = array(
            'instansi' => $this->input->post('nama'),
            'slogan' => $this->input->post('slogan'),
            'tahun' => $this->input->post('tahun'),
            'pimpinan' => $this->input->post('pimpinan'),
            'alamat' => $this->input->post('alamat'),
            'kdpos' => $this->input->post('kdpos'),
            'tlp' => $this->input->post('tlp'),
            'fax' => $this->input->post('fax'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('web'),
            'lat' => $this->input->post('lat'),
            'lon' => $this->input->post('lon')
        );
        $update = $this->Mglobals->updateNK("identitas",$data);
        if($update == 1){
            $status = "Identitas terupdate";
        }else{
            $status = "Identitas gagal terupdate";
        }
        return $status;
    }
    
    private function resizeImage($path, $newpath){
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $path,
            'new_image' => $newpath,
            'maintain_ratio' => TRUE,
            'width' => 150,
            'height' => 150
        );
        $this->load->library('image_lib', $config_manip);
        $hasil = $this->image_lib->resize();
        $this->image_lib->clear();
        return $hasil;
    }
}
