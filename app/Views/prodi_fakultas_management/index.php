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
        let tabelFakultas = $('#list-fakultas').DataTable({
            processing: true,
            serverSide: true,
            ajax: `${base_url}/prodi-fakultas-management/get-all-fakultas`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Nama Fakultas',
                    data: 'name'
                },
                {
                    title: 'Nama Fakultas Dalam Inggris',
                    data: 'name_en'
                },
                {
                    title: 'Nama Dekan',
                    data: 'dekan'
                },
                {
                    title: 'Dekan NIDN',
                    data: 'dekan_nidn'
                },
                {
                    title: 'Aksi',
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        let tabelProdi = $('#list-prodi').DataTable({
            processing: true,
            serverSide: true,
            ajax: `${base_url}/prodi-fakultas-management/get-all-prodi`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Nama Prodi',
                    data: 'nama_prodi'
                },
                {
                    title: 'Nama Fakultas',
                    data: 'nama_fakultas'
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

    $(document).on('click', '#edit-fakultas', function(e) {
        // get id fakultas
        let id = $(this).data('id');
        // get data fakultas
        $.ajax({
            url: `${base_url}/prodi-fakultas-management/get-fakultas`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#edit-nama-fakultas').val(data.name);
                $('#edit-nama-fakultas-en').val(data.name_en);
                $('#edit-dekan').val(data.dekan);
                $('#edit-dekan-nidn').val(data.dekan_nidn);
                $('#id_fakultas').val(data.id);

                $('#modalEditFakultas').modal('show');
            }
        })
    });

    $(document).on('click', '#edit-prodi', function(e) {
        // get id prodi
        let id = $(this).data('id');
        // get data prodi
        $.ajax({
            url: `${base_url}/prodi-fakultas-management/get-prodi`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#edit-nama-prodi').val(data.name);
                $('#edit-fakultas-prodi').val(data.fakultas_id);
                $('#id_prodi').val(data.id);

                $('#modalEditProdi').modal('show');
            }
        })
    });

    $(document).on('click', '#delete-prodi', function(e) {
        // get id user
        let id = $(this).data('id');
        // run sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Prodi dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // delete user
                $.ajax({
                    url: `${base_url}/prodi-fakultas-management/delete-prodi`,
                    type: 'post',
                    data: {
                        id: id,
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
                                'User gagal dihapus.',
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

    $(document).on('click', '#delete-fakultas', function(e) {
        // get id user
        let id = $(this).data('id');
        // run sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Fakultas dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // delete user
                $.ajax({
                    url: `${base_url}/prodi-fakultas-management/delete-fakultas`,
                    type: 'post',
                    data: {
                        id: id,
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
                                'User gagal dihapus.',
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
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tabel Fakultas Management</h5>
                        <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalAddFakultas">Buat Fakultas Baru</button>
                    </div>
                    <div class="card-body">
                        <table id="list-fakultas" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tabel Prodi Management</h5>
                        <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalAddProdi">Buat Prodi Baru</button>
                    </div>
                    <div class="card-body">
                        <table id="list-prodi" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>



<!-- Modal Add Fakultas -->
<div class="modal fade" id="modalAddFakultas" tabindex="-1" aria-labelledby="modalAddFakultasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddFakultasLabel">Buat Fakultas Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('prodi-fakultas-management/add-fakultas') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fakultas">Nama Fakultas</label>
                                <input type="text" class="form-control" id="fakultas" name="nama_fakultas">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="fakultas-en">Nama Fakultas Dalam Inggris</label>
                                <input type="text" class="form-control" id="fakultas-en" name="nama_fakultas_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="dekan">Nama Dekan</label>
                                <input type="text" class="form-control" id="dekan" name="nama_dekan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="dekan_nidn">NIDN Dekan</label>
                                <input type="text" class="form-control" id="dekan_nidn" name="dekan_nidn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Fakultas -->
<div class="modal fade" id="modalEditFakultas" tabindex="-1" aria-labelledby="modalEditFakultasLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditFakultasLabel">Buat Fakultas Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('prodi-fakultas-management/edit-fakultas') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_fakultas" id="id_fakultas">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fakultas">Nama Fakultas</label>
                                <input type="text" class="form-control" id="edit-nama-fakultas" name="nama_fakultas">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="fakultas-en">Nama Fakultas Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit-nama-fakultas-en" name="nama_fakultas_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="dekan">Nama Dekan</label>
                                <input type="text" class="form-control" id="edit-dekan" name="nama_dekan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="edit-dekan-nidn">NIDN Dekan</label>
                                <input type="text" class="form-control" id="edit-dekan-nidn" name="dekan_nidn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal Add Prodi -->
<div class="modal fade" id="modalAddProdi" tabindex="-1" aria-labelledby="modalAddProdiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddProdiLabel">Buat Prodi Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('prodi-fakultas-management/add-prodi') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="prodi">Nama Prodi</label>
                        <input type="text" class="form-control" id="prodi" name="nama_prodi">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="create-fakultas-id" name="fakultas_id">
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['id'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buat Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Prodi -->
<div class="modal fade" id="modalEditProdi" tabindex="-1" aria-labelledby="modalEditProdiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProdiLabel">Edit Prodi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('prodi-fakultas-management/edit-prodi') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_prodi" id="id_prodi">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="prodi">Nama Prodi</label>
                        <input type="text" class="form-control" id="edit-nama-prodi" name="nama_prodi">
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="edit-fakultas-prodi" name="fakultas_id">
                            <option value="">Tidak memiliki fakultas</option>
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['id'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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