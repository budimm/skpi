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
        let tabel = $('#list-gelar').DataTable({
            processing: true,
            serverSide: true,
            ajax: `${base_url}/gelar-management/get-all-gelar`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Nama Gelar',
                    data: 'name'
                },
                {
                    title: 'Nama Gelar (English)',
                    data: 'name_en'
                },
                {
                    title: 'Fakultas',
                    data: 'fakultas'
                },
                {
                    title: 'Prodi',
                    data: 'prodi'
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

    $(document).on('click', '#edit-gelar', function(e) {
        // get id gelar
        let id = $(this).data('id');
        // get data gelar
        $.ajax({
            url: `${base_url}/gelar-management/get-gelar`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                // set data gelar
                $('#gelar_id').val(data.id);
                $('#edit-name-gelar').val(data.name);
                $('#edit-name-gelar-en').val(data.name_en);
                $('#edit-name-fakultas').val(data.fakultas);
                $('#edit-name-prodi').val(data.prodi);
                $('#modalEditGelar').modal('show');
            }
        })
    });

    $(document).on('click', '#delete-gelar', function(e) {
        // get id gelar
        let id = $(this).data('id');
        // run sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Gelar akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // delete gelar
                $.ajax({
                    url: `${base_url}/gelar-management/delete-gelar`,
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
            <!-- /.col-md-6 -->
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Tabel Gelar Management</h5>
                        <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalAddGelar">Buat Gelar Baru</button>
                    </div>
                    <div class="card-body">
                        <table id="list-gelar" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<!-- Modal Add Gelar -->
<div class="modal fade" id="modalAddGelar" tabindex="-1" aria-labelledby="modalAddGelarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddGelarLabel">Buat Gelar Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('gelar-management/add-gelar') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="gelar">Nama Gelar</label>
                                <input type="text" class="form-control" id="gelar" name="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="gelar_en">Nama Gelar Dalam Inggris</label>
                                <input type="text" class="form-control" id="gelar_en" name="name_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Pilih Fakultas</label>
                        <select class="form-control" id="fakultas" name="fakultas">
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['name'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="prodi" name="prodi">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['name'] ?>"><?= $prodi['name'] ?></option>
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

<!-- Modal Edit Gelar -->
<div class="modal fade" id="modalEditGelar" tabindex="-1" aria-labelledby="modalEditGelarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditGelarLabel">Buat Gelar Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('gelar-management/edit-gelar') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="gelar_id" id="gelar_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="gelar">Nama Gelar</label>
                                <input type="text" class="form-control" id="edit-name-gelar" name="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="gelar_en">Nama Gelar Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit-name-gelar-en" name="name_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Pilih Fakultas</label>
                        <select class="form-control" id="edit-name-fakultas" name="fakultas">
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['name'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="edit-name-prodi" name="prodi">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['name'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Gelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>