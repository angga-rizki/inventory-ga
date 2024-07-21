<?php
$titleModalTambah = 'Tambah Barang Masuk';
$titleModalEdit = 'Edit Barang Masuk';
$linkSaveData = base_url('barang_masuk/save_barang_masuk');
$linkDeleteData = base_url('barang_masuk/delete_barang_masuk');
?>

<!-- Modal -->
<div class="modal fade" id="bootstrapModal" tabindex="-1" role="dialog" aria-labelledby="bootstrapModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleModal">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= $linkSaveData ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="">
                    <input type="hidden" id="inputFormatTanggal" name="inputFormatTanggal" value="">
                    <input type="hidden" id="inputIdNamaBarang" name="inputIdNamaBarang" value="">

                    <div class="form-group">
                        <label for="inputNamaBarang">Nama Barang</label>
                        <select class="form-control" id="inputNamaBarang" name="inputNamaBarang" required="">
                            <option value="" disabled selected>Pilih barang...</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="inputTanggal">Tanggal</label>
                        <input type="date" class="form-control" id="inputTanggal" name="inputTanggal" required="">
                    </div>
                    <div class="form-group">
                        <label for="inputQuantityIn">Quantity In</label>
                        <input type="number" class="form-control" id="inputQuantityIn" name="inputQuantityIn" placeholder="Masukkan Quantity In" min="1"  required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex flex-nowrap">
                    <h1 class="m-0"><?= ucwords($title) ?></h1>
                    <button type="button" class="btn btn-success ml-3" data-toggle="modal" data-target="#bootstrapModal" data-title="<?= $titleModalTambah ?>" data-aksi="tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"><?= ucwords($kategoriMenu) ?></a></li>

                        <?php if (!empty($master)): ?>
                            <li class="breadcrumb-item"><a href="#"><?= ucwords($master) ?></a></li>
                        <?php endif; ?>

                        <li class="breadcrumb-item active"><?= ucwords($namaMenu) ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div style="width: 100%;">
                    <div id="cardTabel" class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped table-sm" style="width: 100%;">
                                <thead>
                                    <tr style="white-space: nowrap">
                                        <th class="d-print-none">Aksi</th>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>Quantity In</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>                                        

                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($listBarangMasuk as $list): ?>
                                        <tr data-id="<?= $list['id'] ?>">
                                            <td class="col-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#bootstrapModal" data-title="<?= $titleModalEdit ?>" data-aksi="edit"><i class="fas fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal" data-id="<?= $list['id'] ?>"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                            <td style="width: 50px; text-align: center"><?= $no ?></td>
                                            <td class="col-1"><?= $list['tanggal'] ?></td>
                                            <td><?= $list['nama_barang'] ?></td>
                                            <td class="col-1"><?= $list['quantity_in'] ?></td>
                                            <td class="col-1"><?= $list['satuan'] ?></td>
                                            <td><?= $list['keterangan'] ?></td>
                                        </tr>
                                        <?php $no++ ?>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script>
    var aksi;
    var formatTanggal;
    var idNamaBarangHashMap = [];
    var dt = new Date();
    var time = ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2) + ":" + ("0" + dt.getSeconds()).slice(-2);

    $(document).ready(function () {
            var table = $('#datatable').DataTable({
                    scrollY: '50vh',
                    scrollX: true,
            pageLength: 50,
            dom: '<"top"<"left-col"B><"center-col"><"right-col"f>>rtip',
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
                buttons:
                    [
                        'pageLength',
                        {
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ]
            });

        new ResizeObserver(table.columns.adjust).observe(cardTabel);

        $('#bootstrapModal').on('show.bs.modal', function (event) {
            var modal = $(this)
            var button = $(event.relatedTarget) // Button that triggered the modal
            var title = button.data('title') // Extract info from data-* attributes

            aksi = button.data('aksi')

            modal.find('.modal-title').text(title)

            $.ajax({
                url: 'barang_masuk/ajax_load_list_select_nama_barang',
            }).done(function (data) {
                var listNamaBarang = JSON.parse(data);
                var inputSelectNamaBarang = $('#inputNamaBarang');
                for (var i = 0; i < listNamaBarang.length; i++) {
                    var key = listNamaBarang[i]['nama_barang'];
                    var value = listNamaBarang[i]['id'];
                    idNamaBarangHashMap[key] = value;
                    inputSelectNamaBarang.append('<option>' + listNamaBarang[i]['nama_barang'] + '</option>');
                }

                if (aksi == 'edit') {
                    // Menyiapkan form
                    var barisTabelButtonAksi = button.closest('tr'); // DOM baris tabel

                    var id = barisTabelButtonAksi.data('id');
                    var tanggal = barisTabelButtonAksi[0].cells[2].innerHTML;
                    var namaBarang = barisTabelButtonAksi[0].cells[3].innerHTML;
                    var quantityIn = barisTabelButtonAksi[0].cells[4].innerHTML;

                    namaBarang = namaBarang.replace(/&amp;/g, '&');

                    $('#id').val(id);
                    $('#inputNamaBarang').val(namaBarang);
                    $('#inputTanggal').val(tanggal);
                    $('#inputQuantityIn').val(quantityIn);
                    formatTanggal = $('#inputTanggal').val() + ' ' + time;
                    $('#inputFormatTanggal').val(formatTanggal);

                    // set value inputIdNamaBarang
                    $('#inputIdNamaBarang').val(idNamaBarangHashMap[$('#inputNamaBarang').val()]);
                }
            });

            $('#inputTanggal').on('change', function () {
                formatTanggal = $('#inputTanggal').val() + ' ' + time;
                $('#inputFormatTanggal').val(formatTanggal);
            })

            $('#inputNamaBarang').on('change', function () {
                // set value inputIdNamaBarang
                $('#inputIdNamaBarang').val(idNamaBarangHashMap[$('#inputNamaBarang').val()]);
            });


        });

        $('#confirmModal').on('show.bs.modal', function (event) {
            var modal = $(this);
            var button = $(event.relatedTarget);

            var barisTabelButtonAksi = button.closest('tr'); // DOM baris tabel
            var id = barisTabelButtonAksi.data('id');
            $('#ok-button').attr("href", "<?= $linkDeleteData ?>/" + id);
        });

        $('#bootstrapModal').on('hidden.bs.modal', function (event) {
            resetForm();
        });
    });

    function resetForm() {
        $('#id').val('');
        $('#inputFormatTanggal').val('');
        $('#inputIdNamaBarang').val('');
        $('#bootstrapModal form')[0].reset();
        $('#inputNamaBarang').prop('selectedIndex', 0);
        $('#inputNamaBarang')
                .find('option')
                .remove()
                .end()
                .append('<option value="" disabled selected>Pilih barang...</option>')
                .val('')
                ;
    }

</script>