<?= $this->extend('templates/main_layout'); ?>


<?= $this->section('style'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('adminlte') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url('adminlte') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('adminlte') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url('adminlte') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        let tabel = $('#list-PPM').DataTable({
            processing: true,
            serverSide: true,
            ajax: `${base_url}/form-management/kemampuan-bidang-khusus-management/get-all-kemampuan-bidang-khusus`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Prodi',
                    data: 'name'
                },
                {
                    title: 'Dibuat Pada',
                    data: 'created_at'
                },
                {
                    title: 'Aksi',
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $(document).on('click', '#edit-data', function(e) {
        // get id data
        let id = $(this).data('id');
        // get data
        $.ajax({
            url: `${base_url}/form-management/kemampuan-bidang-khusus-management/get-kemampuan-bidang-khusus`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#edit_prodi').val(data.kemampuan_bidang_khusus.prodi_id);
                $('#kemampuan_bidang_khusus_id').val(data.kemampuan_bidang_khusus.id);

                let divDetailData = $('#edit-detail-data');
                divDetailData.html('');

                data.detail_kemampuan_bidang_khusus.forEach((value, index) => {
                    if (index == 0) {
                        divDetailData.append(`
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data">Isi text</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus[]" rows="3">${value.isi_kemampuan_bidang_khusus}</textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data_en">Isi text (inggris)</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus_en[]" rows="3">${value.isi_kemampuan_bidang_khusus_en}</textarea>
                                </div>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        `);
                    } else {
                        divDetailData.append(`
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data">Isi text</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus[]" rows="3">${value.isi_kemampuan_bidang_khusus}</textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data_en">Isi text (inggris)</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus_en[]" rows="3">${value.isi_kemampuan_bidang_khusus_en}</textarea>
                                </div>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger mt-4" id="remove-detail-data"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        `);
                    }
                });

                // show modal edit data
                $('#modalEditData').modal('show');
            }
        })
    });

    $(document).on('click', '#delete-data', function(e) {
        // get id 
        let id = $(this).data('id');
        // run sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // delete
                $.ajax({
                    url: `${base_url}/form-management/kemampuan-bidang-khusus-management/delete-kemampuan-bidang-khusus`,
                    type: 'post',
                    data: {
                        id: id
                            // setup csrf token
                            ,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>' // CSRF token
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == true) {
                            Swal.fire(
                                'Berhasil!',
                                data.message,
                                'success'
                            );
                            // reload page
                            location.reload();
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            );
                            // reload page
                            location.reload();
                        }
                    }
                })
            }
        })
    })

    $(document).on('click', '#add-detail-data', function(e) {
        let detailData = `
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="detail_data">Isi text</label>
                        <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus[]" rows="3"></textarea>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="detail_data_en">Isi text (inggris)</label>
                        <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus_en[]" rows="3"></textarea>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger mt-4" id="remove-detail-data"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `
        $('#detail-data').append(detailData);
    })

    $(document).on('click', '#remove-detail-data', function(e) {
        $(this).parent().parent().remove();
    });

    $(document).on('click', '#add-edit-detail-data', function(e) {
        let detailData = `
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="detail_data">Isi text</label>
                        <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus[]" rows="3"></textarea>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="detail_data_en">Isi text (inggris)</label>
                        <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus_en[]" rows="3"></textarea>
                    </div>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger mt-4" id="remove-detail-data"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `
        $('#edit-detail-data').append(detailData);
    })
</script>
<?= $this->endSection(); ?>

<?= $this->section('page-header'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<?= $this->endSection(); ?>

<?= $this->section('main-content'); ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tabel Kemampuan Bidang Khusus</h5>
                        <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalAddData">Buat Data Baru</button>
                    </div>
                    <div class="card-body">
                        <table id="list-PPM" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<!-- Modal Add KBU -->
<div class="modal fade" id="modalAddData" tabindex="-1" aria-labelledby="modalAddDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddDataLabel">Buat Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-management/kemampuan-bidang-khusus-management/add-kemampuan-bidang-khusus') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="prodi" name="prodi_id">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="detail-data">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data">Isi text</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus[]" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="detail_data_en">Isi text (inggris)</label>
                                    <textarea class="form-control" id="detail_data" name="kemampuan_bidang_khusus_en[]" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="add-detail-data"><i class="fas fa-plus"></i></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit KBU -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataLabel">Update Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-management/kemampuan-bidang-khusus-management/update-kemampuan-bidang-khusus') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="kemampuan_bidang_khusus_id" id="kemampuan_bidang_khusus_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="edit_prodi" name="prodi_id">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="edit-detail-data">
                    </div>
                    <button type="button" class="btn btn-primary" id="add-edit-detail-data"><i class="fas fa-plus"></i></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>