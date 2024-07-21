<?php

class Barang_keluar extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Barang Keluar';
    public $namaView = 'barang_keluar'; // nama view di project
    public $namaMenu = 'Barang Keluar'; // nama menu di database
    public $idMenu = 2; // id menu di database
    public $folderView = 'inventory/'; // nama folder view di project
    public $kategoriMenu = 'inventory'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
        $this->load->model('barangKeluar_model');
        $this->load->model('rekapPengeluaranAlatUtility_model');
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
            'listBarangKeluar' => $this->barangKeluar_model->getBarangKeluar()
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

    public function ajax_load_list_select_nama_barang() {
        $listNamaBarang = $this->barangKeluar_model->getListNamaBarang();

        echo json_encode($listNamaBarang);
    }

    public function save_barang_keluar() {
        $id = $this->input->post('id');
        $tanggal = $this->input->post('inputFormatTanggal');
        $idNamaBarang = $this->input->post('inputIdNamaBarang');
        $quantityOut = $this->input->post('inputQuantityOut');

        /* validasi form */
        $this->form_validation->set_rules('id', 'Id Record', 'numeric');
        $this->form_validation->set_rules('inputFormatTanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('inputIdNamaBarang[]', 'Id Nama Barang', 'required|numeric');
        $this->form_validation->set_rules('inputQuantityOut[]', 'Quantity Out', "required|greater_than[0]");

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }

        if (!date_create($tanggal)) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }

        if (count($idNamaBarang) != count($quantityOut)) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }
        /* /.validasi form */

        $sukses = array();
        $gagal = array();

        if (!empty($id)) {
            $idNamaBarang = array($this->input->post('inputIdNamaBarang')[0]);
            $quantityOut = array($this->input->post('inputQuantityOut')[0]);
        }
        
        for ($i = 0; $i < count($idNamaBarang); $i++) {
            if (!empty($idNamaBarang[$i]) && !empty($quantityOut[$i])) {
                /* validasi nilai stok */
                $inputTanggalFormat = date_format(date_create($tanggal), 'Y-m-d');

                $orderByTanggalRekap = 'asc';
                $rekapSelisihBarang = $this->rekapPengeluaranAlatUtility_model->getRekapSelisihBarangMaxTanggal($orderByTanggalRekap, $idNamaBarang[$i], $inputTanggalFormat);

                if ($orderByTanggalRekap == 'desc') {
                    $rekapSelisihBarang = array_reverse($rekapSelisihBarang);
                }

                // cek stok negatif
                $stokTerakhir = 0;

                foreach ($rekapSelisihBarang as $dataRekap) {
                    $stokTerakhir += $dataRekap['selisih'];
                }

                $dataBarangKeluar = $this->barangKeluar_model->getBarangKeluar($id);
                if (!empty($id) && $idNamaBarang[$i] == $dataBarangKeluar['barang_id'] && $inputTanggalFormat >= $dataBarangKeluar['tanggal']) {
                    $stokTerakhir += $dataBarangKeluar['quantity_out'] - $quantityOut[$i];
                } else {
                    $stokTerakhir -= $quantityOut[$i];
                }

                if ($stokTerakhir < 0) {
                    array_push($gagal, array(
                        'idBarang' => $idNamaBarang[$i],
                        'quantity' => $quantityOut[$i]
                    ));
                    /* /.validasi nilai stok */
                } else {
                    // insert
                    if (empty($id)) {
                        if ($this->barangKeluar_model->insertBarangKeluar($idNamaBarang[$i], $tanggal, $quantityOut[$i]) > 0) {
                            array_push($sukses, array(
                                'idBarang' => $idNamaBarang[$i],
                                'quantity' => $quantityOut[$i]
                            ));
                        } else {
                            array_push($gagal, array(
                                'idBarang' => $idNamaBarang[$i],
                                'quantity' => $quantityOut[$i]
                            ));
                        }
                    } else {
                        // update
                        if ($this->barangKeluar_model->updateBarangKeluar($id, $idNamaBarang[0], $tanggal, $quantityOut[0]) > 0) {
                            array_push($sukses, array(
                                'idBarang' => $idNamaBarang[0],
                                'quantity' => $quantityOut[0]
                            ));
                        } else {
                            array_push($gagal, array(
                                'idBarang' => $idNamaBarang[0],
                                'quantity' => $quantityOut[0]
                            ));
                        }
                    }
                }
            } else {
                array_push($gagal, array(
                    'idBarang' => $idNamaBarang[$i],
                    'quantity' => $quantityOut[$i]
                ));
            }
        }

        $pesanInformasi = "<b>Sukses : </b><br>";
        foreach ($sukses as $dataSuksesInput) {
            $pesanInformasi .= "id barang : {$dataSuksesInput['idBarang']} -> quantity : {$dataSuksesInput['quantity']} <br>";
        }
        $pesanInformasi .= '<br><b>Gagal : </b><br>';
        foreach ($gagal as $dataGagalInput) {
            $pesanInformasi .= "id barang : {$dataGagalInput['idBarang']} -> quantity : {$dataGagalInput['quantity']} <br>";
        }

        $this->session->set_flashdata(setMessageFlashData($pesanInformasi, 'sukses_message'));
        redirect(base_url($this->namaView), 'refresh');
    }

    public function delete_barang_keluar($id) {
        if ($this->barangKeluar_model->deleteBarangKeluar($id) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil hapus data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal hapus data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

}
