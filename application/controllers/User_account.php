<?php

class User_account extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Daftar User';
    public $namaView = 'user_account'; // nama view di project
    public $namaMenu = 'User Account'; // nama menu di database
    public $idMenu = 9; // id menu di database
    public $folderView = 'user/'; // nama folder view di project
    public $kategoriMenu = 'user'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
        $this->load->model('userAccount_model');
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
            'listUser' => $this->userAccount_model->getUser()
        );

        // data list akses menu form
        $listKategoriMenu = $this->menu_model->getKategori();
        $dataKategoriMenu = array();
        foreach ($listKategoriMenu as $namaKategori) {
            $listMenuByKategori = $this->menu_model->getMenuSubmenuByKategori($namaKategori['kategori']);
            $dataKategoriMenu[$namaKategori['kategori']] = $listMenuByKategori;
        }

        $data['dataKategoriMenu'] = $dataKategoriMenu;

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

    public function save_user() {
        $id = $this->input->post('id');
        $namaUser = $this->input->post('inputNamaUser');
        $email = $this->input->post('inputEmail');
        $password = $this->input->post('inputPassword');
        $aksesMenu = $this->input->post('inputAksesMenu');

        /* validasi */
        $this->form_validation->set_rules('id', 'Id Record', 'numeric');
        $this->form_validation->set_rules('inputNamaUser', 'Nama User', 'required');
        $this->form_validation->set_rules('inputEmail', 'Email User', 'required|valid_email');
        $this->form_validation->set_rules('inputPassword', 'Password', 'regex_match[/[A-Za-z0-9#?!@$%^&*-]/]');
        if (empty($id)) {
            $this->form_validation->set_rules('inputPassword', 'Password', 'required|regex_match[/[A-Za-z0-9#?!@$%^&*-]/]');
        }
        $this->form_validation->set_rules('inputAksesMenu[]', 'Akses Menu', 'numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }
        /* validasi */

        $listAksesMenu = null;
        $passwordHash = null;
        if (!empty($aksesMenu)) {
            $listAksesMenu = implode(',', $aksesMenu);
        }        
        if (!empty($password)) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        }

        // insert
        if (empty($id)) {
            if ($this->userAccount_model->insertUser($namaUser, $email, $passwordHash, $listAksesMenu) > 0) {
                $this->session->set_flashdata(setMessageFlashData('Berhasil menambah data', 'sukses_message'));
            } else {
                $this->session->set_flashdata(setMessageFlashData('Gagal menambah data', 'error_message'));
            }

            redirect(base_url($this->namaView), 'refresh');
        }

        // update
        if ($this->userAccount_model->updateUser($id, $namaUser, $email, $passwordHash, $listAksesMenu) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil update data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal update data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

    public function delete_user($id) {
        if ($this->userAccount_model->deleteUser($id) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil hapus data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal hapus data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }
}
