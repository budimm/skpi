<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        // make fakultas 
        $data = [
            [
                'fakultas' => 'hukum',
                'prodi' => [
                    'hukum'
                ]
            ],
            [
                'fakultas' => 'ekonomi',
                'prodi' => [
                    'manajemen',
                    'akuntansi',
                    'ekonomi pembangunan'
                ]
            ],
            [
                'fakultas' => 'fisip',
                'prodi' => [
                    'administrasi negara',
                    'komunikasi'
                ]
            ],
            [
                'fakultas' => 'teknik',
                'prodi' => [
                    'elektro',
                    'sipil',
                    'informatika'
                ]
            ]

        ];
        foreach ($data as $value) {
            $this->db->query('INSERT INTO master_fakultas (name,name_en,created_at) VALUES(?,?,?)', [$value['fakultas'], $value['fakultas'], date('Y-m-d H:i:s')]);
            $fakultas_id = $this->db->insertID();

            foreach ($value['prodi'] as $prodi) {
                $this->db->query('INSERT INTO master_prodi (fakultas_id, name,created_at) VALUES(?, ?, ?)', [$fakultas_id, $prodi, date('Y-m-d H:i:s')]);
            }
        }

        // copy image for seeder
        copy('../public/adminlte/avatar5.png', '../public/img/avatar/frist-avatar.png');

        // make group with query
        $auth = service('authorization');
        $auth->createGroup('admin', 'Administrator');
        $auth->createGroup('bpm', 'BPM');
        $auth->createGroup('fakultas', 'Fakultas');
        $auth->createGroup('prodi', 'Prodi');

        // make user
        $user = new User([
            'active'   => 1,
            'username' => 'admin',
            'name'     => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => 'password',
            'avatar' => 'frist-avatar.png',
        ]);

        $users = model(UserModel::class);

        $users->withGroup('admin')->insert($user);
    }
}
