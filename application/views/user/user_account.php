<?php
$titleModalTambah = 'Tambah User';
$titleModalEdit = 'Edit User';
$linkSaveData = base_url('user_account/save_user');
$linkDeleteData = base_url('user_account/delete_user');
?>

<!-- Modal -->
<div class="modal fade" id="bootstrapModal" tabindex="-1" role="dialog" aria-labelledby="bootstrapModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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

                    <div class="form-group">
                        <label for="inputNamaUser">Nama User</label>
                        <input type="text" class="form-control" id="inputNamaUser" name="inputNamaUser" placeholder="Masukkan nama user" required="">
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Masukkan email user" required="">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="text" class="form-control" id="inputPassword" name="inputPassword" placeholder="Masukkan password" required="">
                    </div>

                    <label>Akses Menu</label>
                    <div class="form-control" style="height: auto; padding: 0;"> 
                        <?php foreach ($dataKategoriMenu as $namaKategori => $listMenu): ?>
                            <div class="d-inline-block m-3 align-top">
                                <h5><?= strtoupper($namaKategori) ?></h5>

                                <?php foreach ($listMenu as $dataMenu): ?>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="inputAksesMenu[]" value="<?= $dataMenu['id'] ?>" <?= 'id="menuId-' . $dataMenu['id'] . '"' ?>>
                                        <label class="form-check-label" <?= 'for="menuId-' . $dataMenu['id'] . '"' ?>>
                                            <?= ucwords($dataMenu['nama_menu']) ?>
                                        </label>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
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
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Akses Menu</th>
                                    </tr>
                                </thead>                                        

                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($listUser as $list): ?>
                                        <tr data-id="<?= $list['id'] ?>">
                                            <td class="col-2">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#bootstrapModal" data-title="<?= $titleModalEdit ?>" data-aksi="edit"><i class="fas fa-edit"></i> Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal" data-id="<?= $list['id'] ?>"><i class="fas fa-trash"></i> Delete</button>
                                            </td>
                                            <td style="width: 50px; text-align: center"><?= $no ?></td>
                                            <td><?= $list['nama'] ?></td>
                                            <td><?= $list['email'] ?></td>
                                            <td><?= $list['akses_menu'] ?></td>
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
                    ]
            });
        
        new ResizeObserver(table.columns.adjust).observe(cardTabel);

        $('#bootstrapModal').on('show.bs.modal', function (event) {
            var modal = $(this);
            var button = $(event.relatedTarget); // Button that triggered the modal
            var title = button.data('title'); // Extract info from data-* attributes

            aksi = button.data('aksi');

            modal.find('.modal-title').text(title);

            if (aksi == 'edit') {
                // Menyiapkan form
                var barisTabelButtonAksi = button.closest('tr'); // DOM baris tabel                   

                var id = barisTabelButtonAksi.data('id');
                var namaUser = barisTabelButtonAksi[0].cells[2].innerHTML;
                var email = barisTabelButtonAksi[0].cells[3].innerHTML;
                var aksesMenu = barisTabelButtonAksi[0].cells[4].innerHTML;
                var arrayAksesMenu = aksesMenu.split(',');

                namaUser = namaUser.replace(/&amp;/g, '&');

                // data untuk dikirim
                $('#id').val(id);
                $('#inputNamaUser').val(namaUser);
                $('#inputEmail').val(email);
                $('#inputPassword').attr('placeholder', '(unchanged)');
                $('#inputPassword').attr('required', false);

                for (var i = 0; i < arrayAksesMenu.length; i++) {
                    $("#menuId-" + arrayAksesMenu[i]).attr('checked', true);
                }
            }
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
        $('#bootstrapModal form')[0].reset();
        $('#inputPassword').attr('placeholder', 'Masukkan password');
        $('#inputPassword').attr('required', true);
        $('input:checkbox').removeAttr('checked');
    }

</script>