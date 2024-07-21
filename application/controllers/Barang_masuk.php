<?php

class Barang_masuk extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Barang Masuk';
    public $namaView = 'barang_masuk'; // nama view di project
    public $namaMenu = 'Barang Masuk'; // nama menu di database
    public $idMenu = 1; // id menu di database
    public $folderView = 'inventory/'; // nama folder view di project
    public $kategoriMenu = 'inventory'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
        $this->load->model('barangMasuk_model');
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
            'listBarangMasuk' => $this->barangMasuk_model->getBarangMasuk()
        );

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

    public function ajax_load_list_select_nama_barang() {
        $listNamaBarang = $this->barangMasuk_model->getListNamaBarang();

        echo json_encode($listNamaBarang);
    }

    public function save_barang_masuk() {
        $id = $this->input->post('id');
        $tanggal = $this->input->post('inputFormatTanggal');
        $idNamaBarang = $this->input->post('inputIdNamaBarang');
        $quantityIn = $this->input->post('inputQuantityIn');

        /* validasi form */
        $this->form_validation->set_rules('id', 'Id Record', 'numeric');
        $this->form_validation->set_rules('inputFormatTanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('inputIdNamaBarang[]', 'Id Nama Barang', 'required|numeric');
        $this->form_validation->set_rules('inputQuantityIn[]', 'Quantity In', "required|greater_than[0]");

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }

        if (!date_create($tanggal)) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }

        if (count($idNamaBarang) != count($quantityIn)) {
            $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
            redirect(base_url($this->namaView), 'refresh');
        }
        /* /.validasi form */

        $sukses = array();
        $gagal = array();

        if (!empty($id)) {
            /* validasi nilai stok */
            $inputTanggalFormat = date_format(date_create($tanggal), 'Y-m-d');

            $idNamaBarang = $this->input->post('inputIdNamaBarang')[0];
            $quantityIn = $this->input->post('inputQuantityIn')[0];

            $dataBarangMasukSaatIni = $this->barangMasuk_model->getBarangMasuk($id);
            $tanggalBarangKeluarTerdekat = $this->barangMasuk_model->getTanggalBarangKeluarTerdekat($dataBarangMasukSaatIni['barang_id'], $dataBarangMasukSaatIni['tanggal']);

            $orderByTanggalRekap = 'asc';
            $rekapSelisihBarang = $this->rekapPengeluaranAlatUtility_model->getRekapSelisihBarangMaxTanggal($orderByTanggalRekap, $dataBarangMasukSaatIni['barang_id'], $tanggalBarangKeluarTerdekat['tanggal']);

            if ($orderByTanggalRekap == 'desc') {
                $rekapSelisihBarang = array_reverse($rekapSelisihBarang);
            }

            $stokTerakhir = $quantityIn - $dataBarangMasukSaatIni['quantity_in'];

            if (($inputTanggalFormat > $tanggalBarangKeluarTerdekat['tanggal'] && $idNamaBarang == $dataBarangMasukSaatIni['barang_id']) || $idNamaBarang != $dataBarangMasukSaatIni['barang_id']) {
                $stokTerakhir -= $quantityIn;
            }

            // cek stok negatif
            foreach ($rekapSelisihBarang as $dataRekap) {
                $stokTerakhir += $dataRekap['selisih'];

                if ($stokTerakhir < 0) {
                    $this->session->set_flashdata(setMessageFlashData('Gagal input data', 'error_message'));
                    redirect(base_url($this->namaView), 'refresh');
                }
            }
            /* /.validasi nilai stok */

            // update
            if ($this->barangMasuk_model->updateBarangMasuk($id, $idNamaBarang, $tanggal, $quantityIn) > 0) {
                array_push($sukses, array(
                    'idBarang' => $idNamaBarang,
                    'quantity' => $quantityIn
                ));
            } else {
                array_push($gagal, array(
                    'idBarang' => $idNamaBarang,
                    'quantity' => $quantityIn
                ));
            }
        } else {
            // insert
            for ($i = 0; $i < count($idNamaBarang); $i++) {
                if (!empty($idNamaBarang[$i]) && !empty($quantityIn[$i])) {
                    if ($this->barangMasuk_model->insertBarangMasuk($idNamaBarang[$i], $tanggal, $quantityIn[$i]) > 0) {
                        array_push($sukses, array(
                            'idBarang' => $idNamaBarang[$i],
                            'quantity' => $quantityIn[$i]
                        ));
                    } else {
                        array_push($gagal, array(
                            'idBarang' => $idNamaBarang[$i],
                            'quantity' => $quantityIn[$i]
                        ));
                    }
                } else {
                    array_push($gagal, array(
                        'idBarang' => $idNamaBarang[$i],
                        'quantity' => $quantityIn[$i]
                    ));
                }
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

    public function delete_barang_masuk($id) {
        $dataBarangMasukSaatIni = $this->barangMasuk_model->getBarangMasuk($id);
        $jumlahBarangIdKeluar = $this->barangMasuk_model->getJumlahBarangIdKeluar($dataBarangMasukSaatIni['barang_id']);
        $tanggalBarangKeluarTerdekat = $this->barangMasuk_model->getTanggalBarangKeluarTerdekat($dataBarangMasukSaatIni['barang_id'], $dataBarangMasukSaatIni['tanggal']);

        // validasi
        if ($jumlahBarangIdKeluar['jumlah'] > 0) {
            $orderByTanggalRekap = 'asc';
            $rekapSelisihBarang = $this->rekapPengeluaranAlatUtility_model->getRekapSelisihBarangMaxTanggal($orderByTanggalRekap, $dataBarangMasukSaatIni['barang_id'], $tanggalBarangKeluarTerdekat['tanggal']);

            if ($orderByTanggalRekap == 'desc') {
                $rekapSelisihBarang = array_reverse($rekapSelisihBarang);
            }

            $stokTerakhir = -$dataBarangMasukSaatIni['quantity_in'];

            // cek stok negatif
            foreach ($rekapSelisihBarang as $dataRekap) {
                $stokTerakhir += $dataRekap['selisih'];

                if ($stokTerakhir < 0) {
                    $this->session->set_flashdata(setMessageFlashData('Gagal hapus data', 'error_message'));
                    redirect(base_url($this->namaView), 'refresh');
                }
            }
        }

        // langsung hapus jika tidak ada barang keluar
        if ($this->barangMasuk_model->deleteBarangMasuk($id) > 0) {
            $this->session->set_flashdata(setMessageFlashData('Berhasil hapus data', 'sukses_message'));
        } else {
            $this->session->set_flashdata(setMessageFlashData('Gagal hapus data', 'error_message'));
        }

        redirect(base_url($this->namaView), 'refresh');
    }

}
