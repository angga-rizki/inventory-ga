<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php foreach ($dashboardMenu as $namaKategori => $listMenu): ?>
                <h3 class="mb-3"><?= strtoupper($namaKategori) ?></h3>
                <div class="row pb-3">

                    <?php foreach ($listMenu as $dataMenu): ?>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner" style="height: 113px">
                                    <h4><?= ucwords($dataMenu['nama_menu']) ?></h4>
                                </div>
                                <div class="icon">
                                    <i class="fas <?= $dataMenu['icon'] ?>" style="font-size: 55px"></i>
                                </div>
                                <a href="<?= base_url($dataMenu['link']) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>
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