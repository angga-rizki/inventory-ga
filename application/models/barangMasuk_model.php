<?php

class barangMasuk_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getBarangMasuk($id = null) {
        $sql = "select bm.id, mb.id as barang_id, convert(date, tanggal) as tanggal, nama_barang, quantity_in, satuan, keterangan from master_barang mb join barang_masuk bm on mb.id = bm.barang_id order by tanggal desc";
        if (!empty($id)) {
            $sql = "select bm.id, mb.id as barang_id, convert(date, tanggal) as tanggal, nama_barang, quantity_in, satuan, keterangan from master_barang mb join barang_masuk bm on mb.id = bm.barang_id where bm.id = '{$id}'";

            $query = $this->db->query($sql);
            return $query->first_row('array');
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getListNamaBarang() {
        $sql = 'select id, nama_barang from master_barang order by nama_barang asc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getJumlahBarangIdKeluar($barangId) {
        $sql = "select count(barang_id) as jumlah from barang_keluar where barang_id = {$barangId}";

        $query = $this->db->query($sql);
        return $query->first_row('array');
    }

    public function getTanggalBarangKeluarTerdekat($barangId, $tanggalBarangMasuk) {
        $sql = "select top 1 convert(date, tanggal) as tanggal from barang_keluar where barang_id = '{$barangId}' and tanggal >= '{$tanggalBarangMasuk}' order by tanggal asc";

        $query = $this->db->query($sql);
        return $query->first_row('array');
    }

    public function insertBarangMasuk($idNamaBarang, $tanggal, $quantityIn) {
        $sql = "insert into barang_masuk (barang_id, tanggal, quantity_in) values ('{$idNamaBarang}', '{$tanggal}', '{$quantityIn}')";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function updateBarangMasuk($id, $idNamaBarang, $tanggal, $quantityIn) {
        $sql = "update barang_masuk set barang_id = '{$idNamaBarang}', tanggal = '{$tanggal}', quantity_in = '{$quantityIn}' where id = '{$id}'";

        $query = $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function deleteBarangMasuk($id) {
        $this->db->query("delete from barang_masuk where id = '{$id}'");

        return $this->db->affected_rows();
    }

}
