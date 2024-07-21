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
                <div style="width: 100%;">
                    <div id="cardTabel" class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped table-sm" style="width: 100%;">
                                <thead>
                                    <tr style="white-space: nowrap">
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Barang</th>
                                        <th>In</th>
                                        <th>Out</th>
                                        <th>Stock</th>
                                        <th>Satuan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>                                        

                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($listRekap as $list): ?>
                                        <tr>
                                            <td style="width: 50px; text-align: center"><?= $no ?></td>
                                            <td class="col-1"><?= $list['tanggal'] ?></td>
                                            <td><?= $list['nama_barang'] ?></td>
                                            <td class="col-1"><?= $list['quantity_in'] ?></td>
                                            <td class="col-1"><?= $list['quantity_out'] ?></td>
                                            <td class="col-1"><?= $list['stock'] ?></td>
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
                buttons: [
                        'pageLength', 'excel', 'print'
                ]
            });

        new ResizeObserver(table.columns.adjust).observe(cardTabel);
    });
</script>