<?php
$linkSaveData = base_url('ganti_password/update_password');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex flex-nowrap">
                    <h1 class="m-0"><?= ucwords($title) ?></h1>
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
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="<?= $linkSaveData ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="inputPasswordLama">Password Lama</label>
                                        <input type="password" class="form-control" id="inputPasswordLama" name="inputPasswordLama" placeholder="Masukkan password lama" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPasswordBaru">Password Baru</label>
                                        <input type="password" class="form-control" id="inputPasswordBaru" name="inputPasswordBaru" placeholder="Masukkan password baru" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputKonfirmasiPassword">Konfimarsi Password</label>
                                        <input type="password" class="form-control" id="inputKonfirmasiPassword" name="inputKonfirmasiPassword" placeholder="Ulangi password" required="">
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right my-2">Submit</button>
                                </div>
                            </form>
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