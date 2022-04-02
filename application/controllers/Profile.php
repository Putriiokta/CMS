<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profile
 *
 */
class Profile extends CI_Controller {
    
    public function index(){
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['email'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            $data['tersimpan'] = $this->Mglobals->getAllQR("select * from users where idusers = '".$ses['idusers']."';");
            
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/profile/index');
            $this->load->view('backend/foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $idusers = $ses['idusers'];
            
            $data = array(
                'email' => $this->input->post('email'),
                'nama' => $this->input->post('nama')
            );
            $kond['idusers'] = $idusers;
            $update = $this->Mglobals->update("users",$data,$kond);
            if($update == 1){
                $status = "Profile tersimpan";
            }else{
                $status = "Profile gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
