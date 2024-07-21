<?php

class dashboard_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
    public function getKategoriFilterAksesMenu($listIdMenu) {
        $sql = "select kategori
                from 
                (select kategori from menu where id in ({$listIdMenu})) as akses_menu
                group by kategori";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMenuByKategoriFilterAksesMenu($listIdMenu, $kategori) {
        $sql = "select nama_menu, link, icon
                from (select nama_menu, link, icon, kategori from menu where id in ({$listIdMenu})) as akses_menu
                where kategori = '{$kategori}'";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getDataMenu($id) {
        $sql = "select nama_menu, link, icon from menu where id = '{$id}'";

        $query = $this->db->query($sql);
        return $query->first_row('array');
    }

}
