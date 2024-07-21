<?php

class barangKeluar_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getBarangKeluar($id = null) {
        $sql = "select bk.id, mb.id as barang_id, convert(date, bk.tanggal) as tanggal, nama_barang, quantity_out, satuan, keterangan
                from master_barang mb 
                join barang_keluar bk
                on mb.id = bk.barang_id
                order by tanggal desc";

        if (!empty($id)) {
            $sql = "select bk.id, mb.id as barang_id, convert(date, bk.tanggal) as tanggal, nama_barang, quantity_out, satuan, keterangan
                from master_barang mb 
                join barang_keluar bk
                on mb.id = bk.barang_id
                where bk.id = '{$id}'";

            $query = $this->db->query($sql);
            return $query->first_row('array');
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getListNamaBarang() {
        $sql = "select mb.id, nama_barang, (quantity_in - isnull(quantity_out, 0)) as sisa
                from master_barang mb 
                join
		(select barang_id, sum(quantity_in) as quantity_in from barang_masuk group by barang_id) bm
		on mb.id = bm.barang_id
		left join
		(select barang_id, sum(quantity_out) as quantity_out from barang_keluar group by barang_id) bk
		on bm.barang_id = bk.barang_id";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function insertBarangKeluar($idNamaBarang, $tanggal, $quantityOut) {
        $sql = "insert into barang_keluar (barang_id, tanggal, quantity_out) values ('{$idNamaBarang}', '{$tanggal}', '{$quantityOut}')";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBarangKeluar($id, $idNamaBarang, $tanggal, $quantityOut) {
        $sql = "update barang_keluar set barang_id = '{$idNamaBarang}', tanggal = '{$tanggal}', quantity_out = '{$quantityOut}' where id = '{$id}'";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function deleteBarangKeluar($id) {
        $this->db->query("delete from barang_keluar where id = '{$id}'");

        return $this->db->affected_rows();
    }

}
