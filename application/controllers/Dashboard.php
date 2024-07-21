<?php

class Dashboard extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Dashboard Inventory GA';
    public $namaView = 'dashboard';
    public $namaMenu = 'Dashboard';
    public $folderView = '';
    public $kategoriMenu = '';
    public $masterMenu = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->helper('url_helper');

        if (!$this->session->userdata('loggedIn')) {
            redirect(base_url('auth'), 'refresh');
        }
    }

    public function index() {
        $menu = buildMenu();

        $dataMenu = array();

        $listAksesMenu = implode(',', $this->session->userdata('aksesMenu'));
        if (!empty($listAksesMenu)) {
            $daftarKategori = $this->dashboard_model->getKategoriFilterAksesMenu($listAksesMenu);
            foreach ($daftarKategori as $list) {
                $dataMenu[$list['kategori']] = $this->dashboard_model->getMenuByKategoriFilterAksesMenu($listAksesMenu, $list['kategori']);
            }
        }
        
        $data = array(
            'title' => $this->titlePage,
            'dashboardMenu' => $dataMenu
        );

        $dataHeader = array(
            'title' => $this->titlePage,
            'link' => $this->namaView,
            'master' => $this->masterMenu,
            'menu' => $menu
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

}
