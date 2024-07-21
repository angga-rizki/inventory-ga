<?php

function buildMenu() {
    $CI = & get_instance();
    $menu = array();

    $listAksesMenu = implode(',', $CI->session->userdata('aksesMenu'));
    if (!empty($listAksesMenu)) {        
        foreach ($CI->menu_model->getKategoriFilterAksesMenu($listAksesMenu) as $dataKategori) {
            $namaKategori = $dataKategori['kategori'];
            $menuMaster = array();

            $dataMenuMaster = $CI->menu_model->getMasterMenuByKategori($namaKategori);
            foreach ($dataMenuMaster as $listData) {
                $dataSubmenu = $CI->menu_model->getSubmenuFilterAksesMenu($namaKategori, $listData['id'], $listAksesMenu);
                if (!empty($dataSubmenu)) {
                    $menuMaster[$listData['nama_menu']] = $dataSubmenu;
                }
            }

            $menu[$namaKategori] = array(
                'menuMaster' => $menuMaster,
                'menuSingle' => $CI->menu_model->getMenuSingleByKategoriFilterAksesMenu($namaKategori, $listAksesMenu)
            );
        }
    }

    return $menu;
}
