<?php

class rekapPengeluaranAlatUtility_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function getRekapQuantityBarang($tanggalOrderByAscDesc) {
        $sql = "SELECT barang_id, nama_barang, tanggal, quantity_in, quantity_out, (quantity_in - quantity_out) as selisih,  satuan, keterangan 
                FROM
                (
                    SELECT
                    CASE 
                        WHEN bm.barang_id is null THEN bk.barang_id
                        WHEN bm.barang_id is not null THEN bm.barang_id
                    END as barang_id, 
                    CASE 
                        WHEN bm.tgl_masuk is null THEN bk.tgl_keluar
                        WHEN bm.tgl_masuk is not null THEN bm.tgl_masuk
                    END as tanggal, 
                    
                    isnull(quantity_in, 0) quantity_in, isnull(quantity_out, 0) quantity_out
                    FROM
                    (
                        SELECT barang_id, CONVERT(date,tanggal) as tgl_masuk, sum(quantity_in) quantity_in 
                        FROM barang_masuk
                        GROUP BY barang_id, CONVERT(date,tanggal)
                    ) bm				
                    FULL JOIN
                    (
                        SELECT barang_id, CONVERT(date,tanggal) as tgl_keluar, sum(quantity_out) quantity_out 
                        FROM barang_keluar
                        GROUP BY Barang_id,CONVERT(date,tanggal)
                    ) bk
                    ON bm.barang_id = bk.barang_id and bm.tgl_masuk = bk.tgl_keluar
                ) rekap
		LEFT JOIN master_barang mb
		ON mb.id = rekap.barang_id
                ORDER BY tanggal {$tanggalOrderByAscDesc}";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getRekapSelisihBarangMaxTanggal($tanggalOrderByAscDesc, $barangId, $tanggalMax) {
        $sql = "SELECT (quantity_in - quantity_out) as selisih 
                FROM
                (
                    SELECT
                    CASE 
                        WHEN bm.barang_id is null THEN bk.barang_id
                        WHEN bm.barang_id is not null THEN bm.barang_id
                    END as barang_id, 
                    CASE 
                        WHEN bm.tgl_masuk is null THEN bk.tgl_keluar
                        WHEN bm.tgl_masuk is not null THEN bm.tgl_masuk
                    END as tanggal, 
                    
                    isnull(quantity_in, 0) quantity_in, isnull(quantity_out, 0) quantity_out
                    FROM
                    (
                        SELECT barang_id, CONVERT(date,tanggal) as tgl_masuk, sum(quantity_in) quantity_in 
                        FROM barang_masuk
                        where barang_id = {$barangId}
                        GROUP BY barang_id, CONVERT(date,tanggal)
                    ) bm				
                    FULL JOIN
                    (
                        SELECT barang_id, CONVERT(date,tanggal) as tgl_keluar, sum(quantity_out) quantity_out 
                        FROM barang_keluar
                        where barang_id = {$barangId}
                        GROUP BY Barang_id,CONVERT(date,tanggal)
                    ) bk
                    ON bm.barang_id = bk.barang_id and bm.tgl_masuk = bk.tgl_keluar
                ) rekap
		LEFT JOIN master_barang mb
		ON mb.id = rekap.barang_id
                WHERE tanggal <= '{$tanggalMax}'
                ORDER BY tanggal {$tanggalOrderByAscDesc}";
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }

}
