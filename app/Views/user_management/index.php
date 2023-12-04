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
        let tabel = $('#list-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: `${base_url}/user-management/get-all-users`,
            order: [],
            columns: [{
                    title: 'No.',
                    data: 'number',
                    orderable: false,
                    searchable: false
                },
                {
                    title: 'Username',
                    data: 'username'
                },
                {
                    title: 'Nama',
                    data: 'user_name'
                },
                {
                    title: 'Fakultas',
                    data: 'fakultas_name'
                },
                {
                    title: 'Prodi',
                    data: 'prodi_name'
                },
                {
                    title: 'Role',
                    data: 'group_name'
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

    $(document).on('click', '#edit-user', function(e) {
        // get id user
        let id = $(this).data('id');
        // get data user
        $.ajax({
            url: `${base_url}/user-management/get-user`,
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $('#edit-avatar-user').attr('src', `${base_url}/img/avatar/${data.avatar}`);
                $('#edit-email').val(data.secret);
                $('#edit-username').val(data.username);
                $('#edit-name').val(data.user_name);
                $('#edit-role').val(data.group_id);
                $('#edit-fakultas').val(data.fakultas_id);
                $('#edit-prodi').val(data.prodi_id);
                $('#old_avatar').val(data.avatar);
                $('#user_id').val(data.id);

                $('#modalEditUser').modal('show');
                console.log(data);
            }
        })
    });

    $(document).on('click', '#delete-user', function(e) {
        // get id user
        let id = $(this).data('id');
        // run sweet alert
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "User akan dihapus secara permanen!",
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
                    url: `${base_url}/user-management/delete-user`,
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
                            $('#list-users').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'User gagal dihapus.',
                                'error'
                            );
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
                        <h5 class="m-0">Tabel User Management</h5>
                        <button class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#modalAddUser">Buat User Baru</button>
                    </div>
                    <div class="card-body">
                        <table id="list-users" class="table table-bordered table-striped"></table>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>



<!-- Modal Add User -->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddUserLabel">Buat User Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user-management/add-user') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <h5>Pilih File Avatar User</h5>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file-upload" name="avatar" accept="image/*">
                        <label class="custom-file-label" for="file-upload">Choose file</label>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Pilih Role</label>
                        <select class="form-control" id="role" name="role">
                            <?php foreach ($groups as $group) : ?>
                                <option value="<?= $group->id ?>"><?= $group->description  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Pilih Fakultas</label>
                        <select class="form-control" id="fakultas" name="fakultas">
                            <option value="">Tidak memiliki fakultas</option>
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['id'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="prodi" name="prodi">
                            <option value="">Tidak memiliki Prodi</option>
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
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

<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditUserLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user-management/update-user') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="old_avatar" id="old_avatar">
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-body">
                    <img src="" class="img-thumbnail" alt="#" id="edit-avatar-user" width="200">
                    <h5>Pilih File Avatar User</h5>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file-upload" name="avatar" accept="image/*">
                        <label class="custom-file-label" for="file-upload">Choose file</label>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="edit-email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="edit-username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="edit-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="edit-password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="role">Pilih Role</label>
                        <select class="form-control" id="edit-role" name="role">
                            <?php foreach ($groups as $group) : ?>
                                <option value="<?= $group->id ?>"><?= $group->description  ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Pilih Fakultas</label>
                        <select class="form-control" id="edit-fakultas" name="fakultas">
                            <option value="">Tidak memiliki fakultas</option>
                            <?php foreach ($fakultases as $fakultas) : ?>
                                <option value="<?= $fakultas['id'] ?>"><?= $fakultas['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="prodi">Pilih Prodi</label>
                        <select class="form-control" id="edit-prodi" name="prodi">
                            <option value="">Tidak memiliki Prodi</option>
                            <?php foreach ($prodis as $prodi) : ?>
                                <option value="<?= $prodi['id'] ?>"><?= $prodi['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>