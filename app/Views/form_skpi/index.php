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
            ajax: {
                url: `${base_url}/form-skpi/get-all-form`,
                data: function(d) {
                    d.tahun = $('#tahun').val();
                }
            },
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'No. SKPI',
                    data: 'no_skpi'
                },
                {
                    title: 'Nama',
                    data: 'nama'
                },
                {
                    title: 'NIM',
                    data: 'nim'
                },
                {
                    title: 'Tempat tanggal lahir',
                    data: 'ttl'
                },
                {
                    title: 'Tanggal Masuk',
                    data: 'tanggal_masuk'
                },
                {
                    title: 'Tanggal Lulus',
                    data: 'tanggal_lulus'
                },
                {
                    title: 'Tanggal Pengesahan',
                    data: 'tgl_pengesahan'
                },
                {
                    title: 'Prodi',
                    data: 'prodi_name'
                },
                {
                    title: 'Fakultas',
                    data: 'fakultas_name'
                },
                {
                    title: 'Aksi',
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#tahun').change(function(event) {
            tabel.ajax.reload();
        });
    });

    $(document).on('click', '#edit-data', function(e) {
        // get id data
        let id = $(this).data('id');
        // get data
        $.ajax({
            url: `${base_url}/form-skpi/get-form`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                // set data 
                $('#form_skpi_id').val(data.id);
                $('#edit-nama').val(data.nama);
                $('#edit-nim').val(data.nim);
                $('#edit-ttl').val(data.ttl);
                $('#edit-tanggal_masuk').val(data.tanggal_masuk);
                $('#edit-tanggal_lulus').val(data.tanggal_lulus);
                $('#edit-nomor_seri_ijazah').val(data.nomor_seri_ijazah);
                $('#edit-tugas_khusus_pengganti_kerja_praktek').val(data.tugas_khusus_pengganti_kerja_praktek);
                $('#edit-tugas_khusus_pengganti_kerja_praktek_en').val(data.tugas_khusus_pengganti_kerja_praktek_en);
                $('#edit-pengalaman_organisasi').val(data.pengalaman_organisasi);
                $('#edit-pengalaman_organisasi_en').val(data.pengalaman_organisasi_en);
                $('#edit-tugas_akhir').val(data.tugas_akhir);
                $('#edit-tugas_akhir_en').val(data.tugas_akhir_en);
                $('#edit-tgl_pengesahan').val(data.tgl_pengesahan);
                $('#edit-prodi').val(data.prodi_id);
                $('#edit-penyelenggara_program_id').val(data.penyelenggara_program_id);
                $('#edit-kemampuan_bidang_umum_id').val(data.kemampuan_bidang_umum_id);
                $('#edit-kemampuan_bidang_khusus_id').val(data.kemampuan_bidang_khusus_id);
                $('#edit-penguasaan_pengetahuan_id').val(data.penguasaan_pengetahuan_id);
                $('#edit-penguasaan_sikap_id').val(data.penguasaan_sikap_id);
                $('#edit-bagian_ditjen_dikti_id').val(data.bagian_ditjen_dikti_id);
                $('#edit-gelar').val(data.gelar);
                $('#edit-no-skpi').val(data.no_skpi);


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
                    url: `${base_url}/form-skpi/delete-form`,
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

    $(document).on('click', '#export-data', function(e) {
        // get id
        let id = $(this).data('id');

        // send get to download
        window.location.href = `${base_url}/form-skpi/export-pdf?form_id=${id}`;
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
                        <div class="form-group">
                            <label for="tahun">Pilih Tahun Masuknya</label>
                            <select class="form-control" id="tahun" name="tahun">
                                <?php foreach ($years as $year) : ?>
                                    <option value="<?= $year['year'] ?>"><?= $year['year'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <table id="list-PPM" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<!-- Modal Add SKPI -->
<div class="modal fade" id="modalAddData" tabindex="-1" aria-labelledby="modalAddDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddDataLabel">Buat Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-skpi/add-form') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_skpi">Nomor SKPI</label>
                        <input type="text" class="form-control" id="no_skpi" name="no_skpi">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim">
                    </div>
                    <div class="form-group">
                        <label for="ttl">Tempat Tanggal Lahir</label>
                        <input type="text" class="form-control" id="ttl" name="ttl">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lulus">Tanggal Lulus</label>
                        <input type="date" class="form-control" id="tanggal_lulus" name="tanggal_lulus">
                    </div>
                    <div class="form-group">
                        <label for="nomor_seri_ijazah">Nomor Seri Ijazah</label>
                        <input type="text" class="form-control" id="nomor_seri_ijazah" name="nomor_seri_ijazah">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_khusus_pengganti_kerja_praktek">Tugas Khusus Pengganti Kerja Praktek</label>
                                <input type="text" class="form-control" id="tugas_khusus_pengganti_kerja_praktek" name="tugas_khusus_pengganti_kerja_praktek">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_khusus_pengganti_kerja_praktek_en">Tugas Khusus Pengganti Kerja Praktek Dalam Inggris</label>
                                <input type="text" class="form-control" id="tugas_khusus_pengganti_kerja_praktek_en" name="tugas_khusus_pengganti_kerja_praktek_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="pengalaman_organisasi">Pengalaman Organisasi</label>
                                <input type="text" class="form-control" id="pengalaman_organisasi" name="pengalaman_organisasi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pengalaman_organisasi_en">Pengalaman Organisasi Dalam Inggris</label>
                                <input type="text" class="form-control" id="pengalaman_organisasi_en" name="pengalaman_organisasi_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_akhir">Tugas Akhir</label>
                                <input type="text" class="form-control" id="tugas_akhir" name="tugas_akhir">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_akhir_en">Tugas Akhir Dalam Inggris</label>
                                <input type="text" class="form-control" id="tugas_akhir_en" name="tugas_akhir_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pengesahan">Tanggal Pengesahan</label>
                        <input type="date" class="form-control" id="tgl_pengesahan" name="tgl_pengesahan">
                    </div>

                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="prodi" name="prodi_id">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penyelenggara_program_id">Pilih Penyelenggara Program</label>
                        <select class="form-control" id="penyelenggara_program_id" name="penyelenggara_program_id">
                            <?php foreach ($penyeleggara_programs as $penyeleggara_program) : ?>
                                <option value="<?= $penyeleggara_program['id'] ?>"><?= $penyeleggara_program['prodi_name'] ?>,<?= $penyeleggara_program['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kemampuan_bidang_umum_id">Pilih Kemampuan Bidang Umum</label>
                        <select class="form-control" id="kemampuan_bidang_umum_id" name="kemampuan_bidang_umum_id">
                            <?php foreach ($kemampuan_bidang_umums as $kemampuan_bidang_umum) : ?>
                                <option value="<?= $kemampuan_bidang_umum['id'] ?>"><?= $kemampuan_bidang_umum['prodi_name'] ?>,<?= $kemampuan_bidang_umum['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kemampuan_bidang_khusus_id">Pilih Kemampuan Bidang Khusus</label>
                        <select class="form-control" id="kemampuan_bidang_khusus_id" name="kemampuan_bidang_khusus_id">
                            <?php foreach ($kemampuan_bidang_khususes as $kemampuan_bidang_khusus) : ?>
                                <option value="<?= $kemampuan_bidang_khusus['id'] ?>"><?= $kemampuan_bidang_khusus['prodi_name'] ?>,<?= $kemampuan_bidang_khusus['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penguasaan_pengetahuan_id">Pilih Penguasaan Pengetahuan</label>
                        <select class="form-control" id="penguasaan_pengetahuan_id" name="penguasaan_pengetahuan_id">
                            <?php foreach ($penguasaan_pengetahuans as $penguasaan_pengetahuan) : ?>
                                <option value="<?= $penguasaan_pengetahuan['id'] ?>"><?= $penguasaan_pengetahuan['prodi_name'] ?>,<?= $penguasaan_pengetahuan['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penguasaan_sikap_id">Pilih Penguasaan Sikap</label>
                        <select class="form-control" id="penguasaan_sikap_id" name="penguasaan_sikap_id">
                            <?php foreach ($penguasaan_sikaps as $penguasaan_sikap) : ?>
                                <option value="<?= $penguasaan_sikap['id'] ?>"><?= $penguasaan_sikap['prodi_name'] ?>,<?= $penguasaan_sikap['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bagian_ditjen_dikti_id">Pilih Bagian Ditjen Dikti</label>
                        <select class="form-control" id="bagian_ditjen_dikti_id" name="bagian_ditjen_dikti_id">
                            <?php foreach ($bagian_ditjen_diktis as $bagian_ditjen_dikti) : ?>
                                <option value="<?= $bagian_ditjen_dikti['id'] ?>"><?= $bagian_ditjen_dikti['prodi_name'] ?>,<?= $bagian_ditjen_dikti['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gelar">Pilih Gelar</label>
                        <select class="form-control" id="gelar" name="gelar">
                            <?php foreach ($gelars as $gelar) : ?>
                                <option value="<?= $gelar['name'] ?>"><?= $gelar['prodi_name'] ?>,<?= $gelar['name'] ?></option>
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

<!-- Modal Edit SKPI -->
<div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditDataLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('form-skpi/update-form') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="form_skpi_id" id="form_skpi_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-no-skpi">Nomor SKPI</label>
                        <input type="text" class="form-control" id="edit-no-skpi" name="no_skpi">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="edit-nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" id="edit-nim" name="nim">
                    </div>
                    <div class="form-group">
                        <label for="ttl">Tempat Tanggal Lahir</label>
                        <input type="text" class="form-control" id="edit-ttl" name="ttl">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="edit-tanggal_masuk" name="tanggal_masuk">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lulus">Tanggal Lulus</label>
                        <input type="date" class="form-control" id="edit-tanggal_lulus" name="tanggal_lulus">
                    </div>
                    <div class="form-group">
                        <label for="nomor_seri_ijazah">Nomor Seri Ijazah</label>
                        <input type="text" class="form-control" id="edit-nomor_seri_ijazah" name="nomor_seri_ijazah">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_khusus_pengganti_kerja_praktek">Tugas Khusus Pengganti Kerja Praktek</label>
                                <input type="text" class="form-control" id="edit-tugas_khusus_pengganti_kerja_praktek" name="tugas_khusus_pengganti_kerja_praktek">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_khusus_pengganti_kerja_praktek_en">Tugas Khusus Pengganti Kerja Praktek Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit-tugas_khusus_pengganti_kerja_praktek_en" name="tugas_khusus_pengganti_kerja_praktek_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="pengalaman_organisasi">Pengalaman Organisasi</label>
                                <input type="text" class="form-control" id="edit-pengalaman_organisasi" name="pengalaman_organisasi">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="pengalaman_organisasi_en">Pengalaman Organisasi Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit-pengalaman_organisasi_en" name="pengalaman_organisasi_en">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_akhir">Tugas Akhir</label>
                                <input type="text" class="form-control" id="edit-tugas_akhir" name="tugas_akhir">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tugas_akhir_en">Tugas Akhir Dalam Inggris</label>
                                <input type="text" class="form-control" id="edit-tugas_akhir_en" name="tugas_akhir_en">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tgl_pengesahan">Tanggal Pengesahan</label>
                        <input type="date" class="form-control" id="edit-tgl_pengesahan" name="tgl_pengesahan">
                    </div>

                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="edit-prodi" name="prodi_id">
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penyelenggara_program_id">Pilih Penyelenggara Program</label>
                        <select class="form-control" id="edit-penyelenggara_program_id" name="penyelenggara_program_id">
                            <?php foreach ($penyeleggara_programs as $penyeleggara_program) : ?>
                                <option value="<?= $penyeleggara_program['id'] ?>"><?= $penyeleggara_program['prodi_name'] ?>,<?= $penyeleggara_program['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kemampuan_bidang_umum_id">Pilih Kemampuan Bidang Umum</label>
                        <select class="form-control" id="edit-kemampuan_bidang_umum_id" name="kemampuan_bidang_umum_id">
                            <?php foreach ($kemampuan_bidang_umums as $kemampuan_bidang_umum) : ?>
                                <option value="<?= $kemampuan_bidang_umum['id'] ?>"><?= $kemampuan_bidang_umum['prodi_name'] ?>,<?= $kemampuan_bidang_umum['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kemampuan_bidang_khusus_id">Pilih Kemampuan Bidang Khusus</label>
                        <select class="form-control" id="edit-kemampuan_bidang_khusus_id" name="kemampuan_bidang_khusus_id">
                            <?php foreach ($kemampuan_bidang_khususes as $kemampuan_bidang_khusus) : ?>
                                <option value="<?= $kemampuan_bidang_khusus['id'] ?>"><?= $kemampuan_bidang_khusus['prodi_name'] ?>,<?= $kemampuan_bidang_khusus['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penguasaan_pengetahuan_id">Pilih Penguasaan Pengetahuan</label>
                        <select class="form-control" id="edit-penguasaan_pengetahuan_id" name="penguasaan_pengetahuan_id">
                            <?php foreach ($penguasaan_pengetahuans as $penguasaan_pengetahuan) : ?>
                                <option value="<?= $penguasaan_pengetahuan['id'] ?>"><?= $penguasaan_pengetahuan['prodi_name'] ?>,<?= $penguasaan_pengetahuan['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="penguasaan_sikap_id">Pilih Penguasaan Sikap</label>
                        <select class="form-control" id="edit-penguasaan_sikap_id" name="penguasaan_sikap_id">
                            <?php foreach ($penguasaan_sikaps as $penguasaan_sikap) : ?>
                                <option value="<?= $penguasaan_sikap['id'] ?>"><?= $penguasaan_sikap['prodi_name'] ?>,<?= $penguasaan_sikap['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bagian_ditjen_dikti_id">Pilih Bagian Ditjen Dikti</label>
                        <select class="form-control" id="edit-bagian_ditjen_dikti_id" name="bagian_ditjen_dikti_id">
                            <?php foreach ($bagian_ditjen_diktis as $bagian_ditjen_dikti) : ?>
                                <option value="<?= $bagian_ditjen_dikti['id'] ?>"><?= $bagian_ditjen_dikti['prodi_name'] ?>,<?= $bagian_ditjen_dikti['created_at'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="gelar">Pilih Gelar</label>
                        <select class="form-control" id="edit-gelar" name="gelar">
                            <?php foreach ($gelars as $gelar) : ?>
                                <option value="<?= $gelar['name'] ?>"><?= $gelar['prodi_name'] ?>,<?= $gelar['name'] ?></option>
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