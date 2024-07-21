<?php

class Rekap_pengeluaran_alat_utility extends CI_Controller {

    // konfigurasi halaman
    public $titlePage = 'Rekap Pengeluaran Alat Utility';
    public $namaView = 'rekap_pengeluaran_alat_utility'; // nama view di project
    public $namaMenu = 'rekap pengeluaran alat utility'; // nama menu di database
    public $idMenu = 7; // id menu di database
    public $folderView = 'inventory/'; // nama folder view di project
    public $kategoriMenu = 'inventory'; // kategori menu di database
    public $masterMenu = ''; // master menu di database

    public function __construct() {
        parent::__construct();
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
            'listRekap' => array()
        );

        // proses data view
        $orderByTanggal = 'asc'; // asc/desc
        $rekapQuantity = $this->rekapPengeluaranAlatUtility_model->getRekapQuantityBarang($orderByTanggal);
        $barangIdHashMap = array();
        $tanggalSebelumHashMap = array();
        $dataStokBarang = array();

        if ($orderByTanggal == 'desc') {
            $rekapQuantity = array_reverse($rekapQuantity);
        }
        foreach ($rekapQuantity as $dataRekap) {
            if (in_array($dataRekap['barang_id'], $barangIdHashMap)) {
                $totalQtyIn = $dataRekap['quantity_in'] + $dataStokBarang[$dataRekap['barang_id']][$tanggalSebelumHashMap[$dataRekap['barang_id']]]['total_quantity_in'];
                $totalQtyOut = $dataRekap['quantity_out'] + $dataStokBarang[$dataRekap['barang_id']][$tanggalSebelumHashMap[$dataRekap['barang_id']]]['total_quantity_out'];
                $stok = $totalQtyIn - $totalQtyOut;

                $tanggalSebelumHashMap[$dataRekap['barang_id']] = $dataRekap['tanggal'];
            } else {
                array_push($barangIdHashMap, $dataRekap['barang_id']);
                $tanggalSebelumHashMap[$dataRekap['barang_id']] = $dataRekap['tanggal'];

                $totalQtyIn = $dataRekap['quantity_in'];
                $totalQtyOut = $dataRekap['quantity_out'];
                $stok = $totalQtyIn - $totalQtyOut;
            }

            $dataStokBarang[$dataRekap['barang_id']][$dataRekap['tanggal']] = array(
                'nama_barang' => $dataRekap['nama_barang'],
                'quantity_in' => $dataRekap['quantity_in'],
                'quantity_out' => $dataRekap['quantity_out'],
                'total_quantity_in' => $totalQtyIn,
                'total_quantity_out' => $totalQtyOut,
                'stock' => $stok,
                'satuan' => $dataRekap['satuan'],
                'keterangan' => $dataRekap['keterangan'],
            );
        }

        // data view
        $listRekap = array();
        foreach ($dataStokBarang as $barangId => $tanggal) {
            foreach ($tanggal as $key => $dataTanggal) {
                $dataBarangId = array(
                    'barang_id' => $barangId,
                    'tanggal' => $key,
                    'nama_barang' => $dataTanggal['nama_barang'],
                    'quantity_in' => $dataTanggal['quantity_in'],
                    'quantity_out' => $dataTanggal['quantity_out'],
                    'total_quantity_in' => $dataTanggal['total_quantity_in'],
                    'total_quantity_out' => $dataTanggal['total_quantity_out'],
                    'stock' => $dataTanggal['stock'],
                    'satuan' => $dataTanggal['satuan'],
                    'keterangan' => $dataTanggal['keterangan'],
                );
                array_push($listRekap, $dataBarangId);
            }
        }
        if ($orderByTanggal == 'desc') {
            $listRekap = array_reverse($listRekap);
        }

        $data['listRekap'] = $listRekap;

        $this->load->view('template/header', $dataHeader);
        $this->load->view($this->folderView . $this->namaView, $data);
        $this->load->view('template/footer');
    }

}
