<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Medsos
 *
 */
class Medsos extends CI_Controller{
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['email'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $jml = $this->Mglobals->getAllQR("select count(*) as jml from medsos;")->jml;
            if($jml > 0){
                $tersimpan = $this->Mglobals->getAllQR("select * from medsos;");
                $data['tw'] = $tersimpan->tw;
                $data['ig'] = $tersimpan->ig;
                $data['fb'] = $tersimpan->fb;
                $data['lk'] = $tersimpan->lk;
            }else{
                $data['tw'] = "";
                $data['ig'] = "";
                $data['fb'] = "";
                $data['lk'] = "";
            }
            
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/medsos/index');
            $this->load->view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $jml = $this->Mglobals->getAllQR("select count(*) as jml from medsos;")->jml;
            if($jml > 0){
                $status = $this->ganti();
            }else{
                $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    private function simpan() {
        $data = array(
            'idmedsos' => $this->Mglobals->autokode('M', "idmedsos", "medsos", 2, 7),
            'tw' => $this->input->post('tw'),
            'fb' => $this->input->post('fb'),
            'ig' => $this->input->post('ig'),
            'lk' => $this->input->post('lk')
        );
        $update = $this->Mglobals->add("medsos",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
    
    private function ganti() {
        $data = array(
            'tw' => $this->input->post('tw'),
            'fb' => $this->input->post('fb'),
            'ig' => $this->input->post('ig'),
            'lk' => $this->input->post('lk')
        );
        $update = $this->Mglobals->updateNK("medsos",$data);
        if($update == 1){
            $status = "Data tersimpan";
        }else{
            $status = "Data gagal tersimpan";
        }
        return $status;
    }
}
