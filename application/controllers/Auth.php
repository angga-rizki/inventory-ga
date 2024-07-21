<?php

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('userAccount_model');
        $this->load->helper('url_helper');
    }

    // konfigurasi halaman
    public $titlePage = 'Login Inventory GA';
    public $namaView = 'auth';
    public $namaMenu = '';
    public $folderView = '';
    public $kategoriMenu = '';
    public $masterMenu = '';

    public function index() {
        $data = array(
            'title' => $this->titlePage
        );

        $this->load->view($this->folderView . $this->namaView, $data);
    }
    
    public function login() {
        $email = $this->input->post('inputEmail');
        $password = $this->input->post('inputPassword');
        
        /* validasi */        
        $this->form_validation->set_rules('inputEmail', 'Email User', 'required|valid_email');
        $this->form_validation->set_rules('inputPassword', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect(base_url($this->namaView), 'refresh');
        }
        /* validasi */

        $dataUser = $this->userAccount_model->getUser($email);
        
        if(!password_verify($password, $dataUser['password'])){
            $this->session->set_flashdata(setMessageFlashData('Email atau password salah', 'error_message'));
            
            redirect(base_url($this->namaView), 'refresh');
        }
        
        $aksesMenu = explode(',', $dataUser['akses_menu']);
        
        $dataLogin = array(
            'idUser' => $dataUser['id'],
            'namaUser' => $dataUser['nama'],
            'email' => $dataUser['email'],
            'aksesMenu' => $aksesMenu,
            'loggedIn' => TRUE
        );
        
        $this->session->set_userdata($dataLogin);
        
        redirect(base_url('dashboard'), 'refresh');
    }
    
    public function logout() {
        $this->session->sess_destroy();
        
        redirect(base_url($this->namaView), 'refresh');
    }
}