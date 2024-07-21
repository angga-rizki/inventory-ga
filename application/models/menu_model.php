<?php

class menu_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // 3 tipe menu : 
    // master : menu parent dari submenu
    // submenu : menu - menu di dalam menu master
    // menu : single menu
    public function getKategori() {
        $sql = "select kategori from menu group by kategori";

        return $this->db->query($sql)->result_array();
    }

    public function getKategoriFilterAksesMenu($listIdMenu) {
        $sql = "select kategori from menu where id in ({$listIdMenu}) group by kategori";

        return $this->db->query($sql)->result_array();
    }

    public function getMasterMenuByKategori($kategori) {
        $sql = "select id, nama_menu from menu where tipe_menu = 'master' and kategori = '{$kategori}'";

        return $this->db->query($sql)->result_array();
    }

    public function getMenuSingleByKategoriFilterAksesMenu($kategori, $listIdMenu) {
        $sql = "select nama_menu, link, icon from (select * from menu where id in ({$listIdMenu})) as akses_menu where tipe_menu='menu' and kategori = '{$kategori}'";

        return $this->db->query($sql)->result_array();
    }

    public function getSubmenuFilterAksesMenu($kategori, $idMenuMaster, $listIdMenu) {
        $sql = "select nama_menu, link, icon from (select * from menu where id in ({$listIdMenu})) as akses_menu where tipe_menu = 'submenu' and kategori = '{$kategori}' and id_master_menu = '{$idMenuMaster}'";

        return $this->db->query($sql)->result_array();
    }

    public function getMenuSubmenuByKategori($kategori) {
        $sql = "select id, nama_menu, link, icon from menu where (tipe_menu = 'submenu' or tipe_menu = 'menu') and kategori = '{$kategori}'";

        return $this->db->query($sql)->result_array();
    }

}
