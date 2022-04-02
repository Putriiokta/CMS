<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Beranda
 *
 */
class Beranda extends CI_Controller {
    
    public function index() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['email'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $jml_identitas = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if($jml_identitas > 0){
                $tersimpan = $this->Mglobals->getAllQR("SELECT * FROM identitas;");
                $data['alamat'] = $tersimpan->alamat;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url().'assets/img/logo.jpg';
                $data['logo'] = $deflogo;
                
            }else{
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url().'assets/img/logo.jpg';
            }
            
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/content');
            $this->load->view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
}
