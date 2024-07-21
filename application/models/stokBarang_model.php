<?php

class stokBarang_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getStokBarang() {
        $sql = "select mb.id, nama_barang, (quantity_in - isnull(quantity_out, 0)) as stock, satuan, keterangan
                from master_barang mb 
                join
		(select barang_id, sum(quantity_in) as quantity_in from barang_masuk group by barang_id) bm
		on mb.id = bm.barang_id
		left join
		(select barang_id, sum(quantity_out) as quantity_out from barang_keluar group by barang_id) bk
		on bm.barang_id = bk.barang_id
                order by nama_barang asc";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
