<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 *

 */
class Login extends CI_Controller {
    
    public function index() {
        if($this->nativesession->get('logged_in')){
            $this->modul->halaman('beranda');
        }else{
           $this->load->view('backend/login');
        }
    }
    
    public function proses() {
        clearstatcache();
        
        $user = strtolower(trim($this->input->post('email')));
        $pass = trim($this->input->post('pass'));
        
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->Mglobals->getAllQR("SELECT count(*) as jml FROM users where email = '".$user."';")->jml;
        if($jml > 0){
			$jml1 = $this->Mglobals->getAllQR("select count(*) as jml from users where email = '".$user."' and pass = '".$enkrip_pass."';")->jml;
            if($jml1 > 0){
                $data = $this->Mglobals->getAllQR("select idusers, email, nama from users where email = '".$user."';");
                
                $this->nativesession->set('subfolder', $data->idusers);
                $this->nativesession->set('tautan_utama', substr(base_url(), 0, strlen(base_url())-1));
                // membuat folder
                $path_source = "./media/".$data->idusers;
                $path_thumbs = "./thumbs/".$data->idusers;
                $this->modul->buat_folder($path_source);
                $this->modul->buat_folder($path_thumbs);

                $sess_array = array('idusers' => $data->idusers, 'email' => $data->email, 'nama' => $data->nama, 'grup' => 'adnub');
                $this->nativesession->set('logged_in', $sess_array);    
                $status = "ok";
                
            }else{
                $status = "Anda tidak berhak mengakses !";
            }
        }else{
            $status = "Anda tidak berhak mengakses !";
        }
        
        echo json_encode(array("status" => $status));   
    }
    
    public function logout(){
        $this->nativesession->delete('subfolder');
        $this->nativesession->delete('tautan_utama');
        $this->nativesession->delete('logged_in');
        clearstatcache();
        
        $this->modul->halaman('welcome');
    }
    
}
