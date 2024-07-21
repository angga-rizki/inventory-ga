<?php

class Master_barang extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Master Barang';
    public $namaView = 'master_barang'; // nama view di project
    public $namaMenu = 'master barang'; // nama menu di database
    public $idMenu = 5; // id menu di database
    public $folderView = 'master/'; // nama folder view di project
    public $kategoriMenu = 'master'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
        $this->load->model('masterBarang_model');
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
            'listMasterBarang' => $this->masterBarang_model->getMasterBarang()
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

    public function save_master_barang() {
        $id = $this->input->post('id');
        $namaBarang = $this->input->post('inputNamaBarang');
        $satuan = $this->input->post('inputSatuan');
        $keterangan = $this->input->post('inputKeterangan');
        
        /* validasi */
        $this->form_validation->set_rules('id', 'Id Record', 'numeric');
        $this->form_validation->set_rules('inputNamaBarang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('inputSatuan', 'Satuan Barang', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }
        /* validasi */

        // insert
        if (empty($id)) {
            if ($this->masterBarang_model->insertMasterBarang($namaBarang, $satuan, $keterangan) > 0) {
                $this->session->set_flashdata(setMessageFlashData('Berhasil menambah data', 'sukses_message'));
            } else {
                $this->session->set_flashdata(setMessageFlashData('Gagal menambah data', 'error_message'));
            }

            redirect(base_url($this->namaView), 'refresh');
        }

        // update
        if ($this->masterBarang_model->updateMasterBarang($id, $namaBarang, $satuan, $keterangan) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil update data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal update data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

    public function delete_master_barang($id) {
        if ($this->masterBarang_model->deleteMasterBarang($id) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil hapus data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal hapus data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

}
