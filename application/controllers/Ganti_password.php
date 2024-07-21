<?php

class Ganti_password extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Ganti Password';
    public $namaView = 'ganti_password'; // nama view di project
    public $namaMenu = ''; // nama menu di database
    public $idMenu = ''; // id menu di database
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
            'namaMenu' => 'Ganti Password',
            'kategoriMenu' => $this->kategoriMenu
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

    public function update_password() {
        $passwordLama = $this->input->post('inputPasswordLama');
        $passwordBaru = $this->input->post('inputPasswordBaru');
        $konfirmasiPassword = $this->input->post('inputKonfirmasiPassword');

        $idUser = $this->session->userdata('idUser');
        $passwordSekarang = $this->userAccount_model->getUserPassword($idUser);

        /* validasi */
        $this->form_validation->set_rules('inputPasswordLama', 'Password Lama', 'required|regex_match[/[A-Za-z0-9#?!@$%^&*-]/]');
        $this->form_validation->set_rules('inputPasswordBaru', 'Password Baru', 'required|regex_match[/[A-Za-z0-9#?!@$%^&*-]/]');
        $this->form_validation->set_rules('inputKonfirmasiPassword', 'Konfirmasi Password', 'required|regex_match[/[A-Za-z0-9#?!@$%^&*-]/]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }
        /* validasi */

        if (!password_verify($passwordLama, $passwordSekarang['password'])) {
            $this->session->set_flashdata(setMessageFlashData('Password lama salah', 'error_message'));

            redirect(base_url($this->namaView), 'refresh');
        }

        if ($passwordBaru != $konfirmasiPassword) {
            $this->session->set_flashdata(setMessageFlashData('Password baru dan Konfirmasi password tidak cocok', 'error_message'));

            redirect(base_url($this->namaView), 'refresh');
        }

        $passwordBaruHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

        // update password
        if ($this->userAccount_model->updatePassword($idUser, $passwordBaruHash) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil update data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal update data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

}
