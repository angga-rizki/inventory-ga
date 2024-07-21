<?php

class Stok_barang extends CI_Controller {
    
    // konfigurasi halaman
    public $titlePage = 'Stok Barang Saat Ini';
    public $namaView = 'stok_barang'; // nama view di project
    public $namaMenu = 'Stok Barang'; // nama menu di database
    public $idMenu = 3; // id menu di database
    public $folderView = 'inventory/'; // nama folder view di project
    public $kategoriMenu = 'inventory'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
        $this->load->model('stokBarang_model');
        $this->load->helper('url_helper');
        
        if (!$this->session->userdata('loggedIn')) {
            redirect(base_url('auth'), 'refresh');
        }

        if (!in_array($this->idMenu, $this->session->userdata('aksesMenu'))) {
            redirect(base_url('dashboard'), 'refresh');
        }
    }

    public function index() {
        $menu = buildMenu();

        $dataHeader = array(
            'title' => $this->titlePage,
            'link' => $this->namaView,
            'master' => $this->masterMenu,
            'menu' => $menu
        );

        $data = array(
            'namaMenu' => $this->namaMenu,
            'kategoriMenu' => $this->kategoriMenu,
            'listStokBarang' => $this->stokBarang_model->getStokBarang()
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

}
