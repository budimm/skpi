<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;
use Myth\Auth\Entities\User;
use App\Models\UserModel;
use Myth\Auth\Authorization\GroupModel;

class UserManagement extends BaseController
{
    protected $DataTables;
    public function __construct()
    {
        $this->db = db_connect();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->fakultas_model = new \App\Models\FakultasModel();
        $this->group_model = new \Myth\Auth\Authorization\GroupModel();
    }
    public function index()
    {

        $data = [
            'title' => 'User Management',
            'prodis' => $this->prodi_model->findAll(),
            'fakultases' => $this->fakultas_model->findAll(),
            'groups' => $this->group_model->findAll(),
        ];
        return view('user_management/index', $data);
    }

    public function data_user()
    {


        $builder = $this->db
            ->table('users')
            ->select('users.id, users.username, users.email, users.name as user_name, users.avatar, master_fakultas.name as fakultas_name, master_prodi.name as prodi_name, auth_groups.name as group_name')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->join('master_fakultas', 'master_fakultas.id = users.fakultas_id', 'left')
            ->join('master_prodi', 'master_prodi.id = users.prodi_id', 'left');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                if ($row->id == user_id()) {
                    return '<button type="button" class="btn btn-primary btn-sm" id="edit-user" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                } else {
                    return '<button type="button" class="btn btn-primary btn-sm" id="edit-user" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-user" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
                }
            })
            ->toJson(true);
    }

    public function add_user()
    {

        // set validation
        $validation = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                ]
            ],
            'username' => [
                'rules' => 'required|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi',
                    'is_unique' => 'Username sudah terdaftar',
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi',
                    // 'min_length' => 'Password minimal 8 karakter',
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus dipilih',
                ]
            ],
            'avatar' => [
                'rules' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Avatar harus diisi',
                    'max_size' => 'Ukuran avatar maksimal 1MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload bukan gambar',
                ]
            ],
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('user-management'))->withInput();
        }

        // handle upload image
        $avatar = $this->request->getFile('avatar');
        $randomName = $avatar->getRandomName();
        $avatar->move('img/avatar', $randomName);

        // insert data to database
        $data = [
            'active' => 1,
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'avatar' => $randomName,
            'name' => $this->request->getPost('name'),
        ];

        // check if prodi is selected
        if ($this->request->getPost('prodi') != '') {
            $data['prodi_id'] = $this->request->getPost('prodi');
        }

        // check if fakultas is selected
        if ($this->request->getPost('fakultas') != '') {
            $data['fakultas_id'] = $this->request->getPost('fakultas');
        }

        // insert data to database dengan codeigniter shield
        $user = new User($data);

        $users = model(UserModel::class);
        $users->insert($user);


        // insert role
        $groupModel = model(GroupModel::class);
        $groupModel->addUserToGroup($users->getInsertID(), $this->request->getPost('role'));

        // set flashdata
        session()->setFlashdata('message-success', 'User berhasil ditambahkan');
        // redirect to user management
        return redirect()->to(base_url('user-management'));
    }

    public function update_user()
    {

        // validation
        $validation = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi',
                    'valid_email' => 'Email tidak valid',
                ]
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username harus diisi',
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi',
                ]
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus dipilih',
                ]
            ],
            'avatar' => [
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran avatar maksimal 1MB',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'File yang diupload bukan gambar',
                ]
            ],
        ];

        // check validation
        if (!$this->validate($validation)) {
            return redirect()->to(base_url('user-management'))->withInput();
        }

        // setup data 
        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'name' => $this->request->getPost('name'),
        ];


        // check if avatar is uploaded
        if ($this->request->getFile('avatar')->getName() != '') {
            // delete old avatar
            unlink('img/avatar/' . $this->request->getPost('old_avatar'));

            // handle upload image
            $avatar = $this->request->getFile('avatar');
            $randomName = $avatar->getRandomName();
            $avatar->move('img/avatar', $randomName);
            // update data to database
            $data['avatar'] = $randomName;
        }

        // check if prodi is selected
        if ($this->request->getPost('prodi') != '') {
            $data['prodi_id'] = $this->request->getPost('prodi');
        } else {
            $data['prodi_id'] = null;
        }

        // check if fakultas is selected
        if ($this->request->getPost('fakultas') != '') {
            $data['fakultas_id'] = $this->request->getPost('fakultas');
        } else {
            $data['fakultas_id'] = null;
        }

        // check if password is changed
        if ($this->request->getPost('password') != '') {
            $data['password'] = $this->request->getPost('password');
        }

        // update data to database dengan codeigniter myth auth
        $userModel = new UserModel();
        $user      = $userModel->where('id', $this->request->getPost('user_id'))->first();
        $user->fill($data);
        if ($user->hasChanged()) {
            $userModel->save($user);
        }

        // update role
        $groupModel = model(GroupModel::class);
        $groupModel->removeUserFromAllGroups($this->request->getPost('user_id'));
        $groupModel->addUserToGroup($this->request->getPost('user_id'), $this->request->getPost('role'));

        // $user->syncGroups($this->request->getPost('role'));

        // set flashdata
        session()->setFlashdata('message-success', 'User berhasil diupdate');

        // redirect to user management
        return redirect()->to(base_url('user-management'));
    }

    public function delete_user()
    {

        // get id
        $id = $this->request->getPost('id');

        // Get the User Provider (UserModel by default)
        $users = new UserModel();

        $user = $users->where('id', $id)->first();

        // delete avatar
        unlink('img/avatar/' . $user->avatar);

        // delete user
        $users->delete($id, true);

        return json_encode(['status' => true, 'message' => 'User berhasil dihapus']);
    }

    public function get_user()
    {

        $id = $this->request->getPost('id');
        $user = $this->db
            ->table('users')
            ->select('users.id, users.username, users.email as secret, users.name as user_name, users.avatar, fakultas_id,prodi_id, auth_groups.name as group, auth_groups.id as group_id')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('users.id', $id)
            ->get()
            ->getRowArray();
        return json_encode($user);
    }
}
