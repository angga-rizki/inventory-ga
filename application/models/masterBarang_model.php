<?php

class masterBarang_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getMasterBarang($id = null) {
        if (empty($id))
        {
                $query = $this->db->order_by('nama_barang', 'asc')->get('master_barang');
                return $query->result_array();
        }
        
        $query = $this->db->get_where('master_barang', array('id' => $id));
        return $query->result_array();
    }

    public function insertMasterBarang($namaBarang, $satuan, $keterangan) {
        $this->db->query("insert into master_barang (nama_barang, satuan, keterangan) values ('{$namaBarang}', '{$satuan}', '{$keterangan}')");
        
        return $this->db->affected_rows();
    }
    
    public function updateMasterBarang($id, $namaBarang,$satuan,$keterangan){
        $this->db->query("update master_barang set nama_barang = '{$namaBarang}', satuan = '{$satuan}', keterangan = '{$keterangan}' where id = '{$id}'");
        
        return $this->db->affected_rows();
    }
    
    public function deleteMasterBarang($id) {
        $this->db->query("delete from master_barang where id = '{$id}'");
        
        return $this->db->affected_rows();
    }
}
