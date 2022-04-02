<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Korps
 *
 */
class Korps extends CI_Controller {
    
    public function index() {
        if($this->nativesession->get('logged_in')){
            $ses = $this->nativesession->get('logged_in');
            $data['idusers'] = $ses['idusers'];
            $data['nrp'] = $ses['nrp'];
            $data['nama'] = $ses['nama'];
            $data['golongan'] = $ses['grup'];
            
            $this->load->view('backend/head', $data);
            $this->load->view('backend/menu');
            $this->load->view('backend/korps/index');
            $this->load->view('backend/foot');
        }else{
           $this->modul->halaman('login');
        }
    }
    
    public function ajaxlist() {
        if($this->nativesession->get('logged_in')){
            $data = array();
            $list = $this->Mglobals->getAll("korps");
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->nama_korps;
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-outline-primary btn-fw" onclick="ganti('."'".$row->idkorps."'".')">Ganti</button>&nbsp;'
                        . '<button type="button" class="btn btn-outline-danger btn-fw" onclick="hapus('."'".$row->idkorps."'".','."'".$row->nama_korps."'".')">Hapus</button>'
                        . '</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'idkorps' => $this->Mglobals->autokode("K","idkorps","korps", 2, 7),
                'nama_korps' => $this->input->post('nama')
            );
            $simpan = $this->Mglobals->add("korps",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if($this->nativesession->get('logged_in')){
            $kondisi['idkorps'] = $this->uri->segment(3);
            $data = $this->Mglobals->get_by_id("korps", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->nativesession->get('logged_in')){
            $data = array(
                'nama_korps' => $this->input->post('nama')
            );
            $kond['idkorps'] = $this->input->post('kode');
            $update = $this->Mglobals->update("korps",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->nativesession->get('logged_in')){
            $kondisi['idkorps'] = $this->uri->segment(3);
            $hapus = $this->Mglobals->delete("korps",$kondisi);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
