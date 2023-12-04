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
            ajax: `${base_url}/form-management/penyelenggara-program-management/get-all-penyelenggara-program`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Program Studi',
                    data: 'program_studi'
                },
                {
                    title: 'Status Akreditasi',
                    data: 'status_akreditasi'
                },
                {
                    title: 'Jenis Pendidikan',
                    data: 'jenis_pendidikan'
                },
                {
                    title: 'Jenjang Pendidikan',
                    data: 'jenjang_pendidikan'
                },
                {
                    title: 'Jenjang Pendidikan Sesuai KKNI',
                    data: 'jenjang_pendidikan_sesuai_kkni'
                },
                {
                    title: 'Persyaratan Penerimaan',
                    data: 'persyaratan_penerimaan'
                },
                {
                    title: 'Bahasa Pengantar Kuliah',
                    data: 'bahasa_pengantar_kuliah'
                },
                {
                    title: 'Sistem Penilaian',
                    data: 'sistem_penilaian'
                },
                {
                    title: 'Lama Studi',
                    data: 'lama_studi'
                },
                {
                    title: 'Jenis Jenjang Pendidikan Lanjutan',
                    data: 'jenis_jenjang_pendidikan_lanjutan'
                },
                {
                    title: 'Prodi',
                    data: 'prodi'
                },
                {
                    title: 'Fakultas',
                    data: 'fakultas'
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
            url: `${base_url}/form-management/penyelenggara-program-management/get-penyelenggara-program`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                // set data gelar
                $('#penyelenggara_program_id').val(data.id);
                $('#edit_program_studi').val(data.program_studi);
                $('#edit_program_studi_en').val(data.program_studi_en);
                $('#edit_status_akreditasi').val(data.status_akreditasi);
                $('#edit_jenis_pendidikan').val(data.jenis_pendidikan);
                $('#edit_jenis_pendidikan_en').val(data.jenis_pendidikan_en);
                $('#edit_jenjang_pendidikan').val(data.jenjang_pendidikan);
                $('#edit_jenjang_pendidikan_en').val(data.jenjang_pendidikan_en);
                $('#edit_jenjang_pendidikan_sesuai_kkni').val(data.jenjang_pendidikan_sesuai_kkni);
                $('#edit_persyaratan_penerimaan').val(data.persyaratan_penerimaan);
                $('#edit_persyaratan_penerimaan_en').val(data.persyaratan_penerimaan_en);
                $('#edit_bahasa_pengantar_kuliah').val(data.bahasa_pengantar_kuliah);
                $('#edit_bahasa_pengantar_kuliah_en').val(data.bahasa_pengantar_kuliah_en);
                $('#edit_sistem_penilaian').val(data.sistem_penilaian);
                $('#edit_lama_studi').val(data.lama_studi);
                $('#edit_lama_studi_en').val(data.lama_studi_en);
                $('#edit_jenis_jenjang_pendidikan_lanjutan').val(data.jenis_jenjang_pendidikan_lanjutan);
                $('#edit_fakultas').val(data.fakultas);
                $('#edit_prodi').val(data.prodi);
                // show modal edit data
                $('#modalEditData').modal('show');
            }
        })
    });

    $(document).on('click', '#delete-data', function(e) {
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
                    url: `${base_url}/form-management/penyelenggara-program-management/delete-penyelenggara-program`,
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
                        <h5 class="m-0">Tabel Penyelenggara Program Management</h5>
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



<!-- Modal Add PPM -->
<div class="modal fade" id="modalAddData" tabindex="-1" aria-labelledby="modalAddDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddDataLabel">Buat Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-management/penyelenggara-program-management/add-penyelenggara-program') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="program_studi">Program Studi</label>
                                <input type="text" class="form-control" id="program_studi" name="program_studi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="program_studi_en">Program Studi Dalam Inggris</label>
                                <input type="text" class="form-control" id="program_studi_en" name="program_studi_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_akreditasi">Status Akreditasi</label>
                        <input type="text" class="form-control" id="status_akreditasi" name="status_akreditasi">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="jenis_pendidikan">Jenis Pendidikan</label>
                                <input type="text" class="form-control" id="jenis_pendidikan" name="jenis_pendidikan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="jenis_pendidikan_en">Jenis Pendidikan Dalam Inggris</label>
                                <input type="text" class="form-control" id="jenis_pendidikan_en" name="jenis_pendidikan_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                                <input type="text" class="form-control" id="jenjang_pendidikan" name="jenjang_pendidikan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="jenjang_pendidikan_en">Jenjang Pendidikan Dalam Inggris</label>
                                <input type="text" class="form-control" id="jenjang_pendidikan_en" name="jenjang_pendidikan_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenjang_pendidikan_sesuai_kkni">Jenjang Pendidikan Sesuai KKNI</label>
                        <input type="text" class="form-control" id="jenjang_pendidikan_sesuai_kkni" name="jenjang_pendidikan_sesuai_kkni">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="persyaratan_penerimaan">Persyaratan Peneriamaan</label>
                                <input type="text" class="form-control" id="persyaratan_penerimaan" name="persyaratan_penerimaan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="persyaratan_penerimaan_en">Persyaratan Peneriamaan Dalam Inggris</label>
                                <input type="text" class="form-control" id="persyaratan_penerimaan_en" name="persyaratan_penerimaan_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="bahasa_pengantar_kuliah">Bahasa Pengantar Kuliah</label>
                                <input type="text" class="form-control" id="bahasa_pengantar_kuliah" name="bahasa_pengantar_kuliah">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="bahasa_pengantar_kuliah_en">Bahasa Pengantar Kuliah Dalam Inggris</label>
                                <input type="text" class="form-control" id="bahasa_pengantar_kuliah_en" name="bahasa_pengantar_kuliah_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sistem_penilaian">Sistem Penilaian</label>
                        <input type="text" class="form-control" id="sistem_penilaian" name="sistem_penilaian">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="lama_studi">Lama Studi</label>
                                <input type="text" class="form-control" id="lama_studi" name="lama_studi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lama_studi_en">Lama Studi Dalam Inggris</label>
                                <input type="text" class="form-control" id="lama_studi_en" name="lama_studi_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_jenjang_pendidikan_lanjutan">Jenis Jenjang Pendidikan Lanjutan</label>
                        <input type="text" class="form-control" id="jenis_jenjang_pendidikan_lanjutan" name="jenis_jenjang_pendidikan_lanjutan">
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

<!-- Modal Edit PPM -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataLabel">Buat Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-management/penyelenggara-program-management/update-penyelenggara-program') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="penyelenggara_program_id" id="penyelenggara_program_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="program_studi">Program Studi</label>
                                <input type="text" class="form-control" id="edit_program_studi" name="program_studi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="program_studi_en">Program Studi Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_program_studi_en" name="program_studi_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status_akreditasi">Status Akreditasi</label>
                        <input type="text" class="form-control" id="edit_status_akreditasi" name="status_akreditasi">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="jenis_pendidikan">Jenis Pendidikan</label>
                                <input type="text" class="form-control" id="edit_jenis_pendidikan" name="jenis_pendidikan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="jenis_pendidikan_en">Jenis Pendidikan Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_jenis_pendidikan_en" name="jenis_pendidikan_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="jenjang_pendidikan">Jenjang Pendidikan</label>
                                <input type="text" class="form-control" id="edit_jenjang_pendidikan" name="jenjang_pendidikan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="jenjang_pendidikan_en">Jenjang Pendidikan Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_jenjang_pendidikan_en" name="jenjang_pendidikan_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenjang_pendidikan_sesuai_kkni">Jenjang Pendidikan Sesuai KKNI</label>
                        <input type="text" class="form-control" id="edit_jenjang_pendidikan_sesuai_kkni" name="jenjang_pendidikan_sesuai_kkni">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="persyaratan_penerimaan">Persyaratan Peneriamaan</label>
                                <input type="text" class="form-control" id="edit_persyaratan_penerimaan" name="persyaratan_penerimaan">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="persyaratan_penerimaan_en">Persyaratan Peneriamaan Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_persyaratan_penerimaan_en" name="persyaratan_penerimaan_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="bahasa_pengantar_kuliah">Bahasa Pengantar Kuliah</label>
                                <input type="text" class="form-control" id="edit_bahasa_pengantar_kuliah" name="bahasa_pengantar_kuliah">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="bahasa_pengantar_kuliah_en">Bahasa Pengantar Kuliah Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_bahasa_pengantar_kuliah_en" name="bahasa_pengantar_kuliah_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sistem_penilaian">Sistem Penilaian</label>
                        <input type="text" class="form-control" id="edit_sistem_penilaian" name="sistem_penilaian">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="lama_studi">Lama Studi</label>
                                <input type="text" class="form-control" id="edit_lama_studi" name="lama_studi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="lama_studi_en">Lama Studi Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit_lama_studi_en" name="lama_studi_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_jenjang_pendidikan_lanjutan">Jenis Jenjang Pendidikan Lanjutan</label>
                        <input type="text" class="form-control" id="edit_jenis_jenjang_pendidikan_lanjutan" name="jenis_jenjang_pendidikan_lanjutan">
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Pilih Fakultas</label>
                        <select class="form-control" id="edit_fakultas" name="fakultas">
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['name'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="edit_prodi" name="prodi">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['name'] ?>"><?= $prodi['name'] ?></option>
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