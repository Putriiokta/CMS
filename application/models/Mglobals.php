<?php
class Mglobals extends CI_Model{
    
    public function getAllQ($q) {
        $list = $this->db->query($q);
        return $list;
    }
    
    public function getAllQR($q) {
        $list = $this->db->query($q);
        return $list->row();
    }
    
    public function getAll($table) {
        $this->db->from($table);
        return $this->db->get();
    }
    
    public function getAllW($table, $kondisi) {
        $this->db->from($table);
        $this->db->where($kondisi);
        return $this->db->get();
    }
    
    public function add($table, $data){
        $simpan = $this->db->insert($table,$data); 
        return $simpan;
    }
    
    public function delete($table,$kondisi){
        $this->db->where($kondisi);
        $delete = $this->db->delete($table);
        return $delete;
    }
    
    public function get_by_id($table, $kondisi){
        $this->db->from($table);
        $this->db->where($kondisi);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($table, $data, $condition){
        $this->db->where($condition);
        $update = $this->db->update($table, $data);
        return $update;
    }
    
    public function updateNK($table, $data){
        $update = $this->db->update($table, $data);
        return $update;
    }
    
    public function autokode($depan, $kolom, $table, $awal, $akhir) {
        $hasil = "";
        $data = $this->db->query("select ifnull(MAX(substr(".$kolom.",".$awal.",".$akhir.")),0) + 1 as jml from ".$table.";")->row();
        $panjang = strlen($data->jml);
        $pnjng_nol = ($akhir-$panjang) - $awal;
        $nol = "";
        for($i=1; $i<=$pnjng_nol; $i++){
            $nol .= "0";
        }
        $hasil = $depan.$nol.$data->jml;
        return $hasil;
    }
    
    public function autokodemax($kolom, $table) {
        $data = $this->db->query("SELECT ifnull(max(".$kolom."),0) + 1 as hasil FROM ".$table.";")->row();
        return $data->hasil;
    }
    
    public function kodemax_tb($kolom, $table, $where_statement) {
        $data = $this->db->query("SELECT ifnull(max(".$kolom."),0) + 1 as hasil FROM ".$table." where ".$where_statement.";")->row();
        return $data->hasil;
    }
    
}
