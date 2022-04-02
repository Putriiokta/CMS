<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gantipass
 *
 */
class Gantipass extends CI_Controller {
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['email'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/gantipass/index');
            $this->load->view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $idusers = $ses['idusers'];
            
            $lama = $this->modul->enkrip_pass($this->input->post('lama'));
            $lama_db = $this->Mglobals->getAllQR("select pass from users where idusers = '".$idusers."';")->pass;
            
            if($lama == $lama_db){
                $data = array(
                    'pass' => $this->modul->enkrip_pass($this->input->post('baru'))
                );
                $kond['idusers'] = $idusers;
                $update = $this->Mglobals->update("users",$data,$kond);
                if($update == 1){
                    $status = "Password tersimpan";
                }else{
                    $status = "Password gagal tersimpan";
                }
            }else{
                $status = "Passsword lama tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
