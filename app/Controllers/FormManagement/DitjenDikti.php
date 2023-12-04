<?php

namespace App\Controllers\FormManagement;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseBuilder;
use Hermawan\DataTables\DataTable;

class DitjenDikti extends BaseController
{
    public function __construct()
    {
        $this->ditjen_dikti_model = new \App\Models\FormManagement\DitjenDiktiModel();
        $this->prodi_model = new \App\Models\ProdiModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title'   => 'Ditjen Dikti Management',
        ];

        if (in_groups('admin', 'bpm')) {
            $data['prodis'] = $this->prodi_model->findAll();
        } elseif (in_groups('fakultas')) {
            $data['prodis'] = $this->prodi_model->where('fakultas_id', user()->fakultas_id)->findAll();
        } else {
            $data['prodis'] = $this->prodi_model->where('id', user()->prodi_id)->findAll();
        }

        return view('FormManagement/ditjen_dikti_management/index', $data);
    }

    public function get_all_ditjen_dikti()
    {
        $builder = $this->db
            ->table('bagian_ditjen_dikti')
            ->select('bagian_ditjen_dikti.id, master_prodi.name, text_bagian, text_bagian_en,bagian_ditjen_dikti.created_at')
            ->join('master_prodi', 'master_prodi.id = bagian_ditjen_dikti.prodi_id');

        return DataTable::of($builder)
            ->addNumbering('number')
            ->add('action', function ($row) {
                return '<button type="button" class="btn btn-primary btn-sm" id="edit-data" data-id="' . $row->id . '" ><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm ml-2" id="delete-data" data-id="' . $row->id . '" ><i class="fas fa-trash-alt"></i></button>';
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('id', 'desc');
            })
            ->filter(function ($builder, $request) {

                if (in_groups('fakultas')) {
                    $builder->whereIn('prodi_id', static function (BaseBuilder $builder) {
                        $builder->select('id')->from('master_prodi')->where('fakultas_id', user()->fakultas_id);
                    });
                }

                if (in_groups('prodi')) {
                    $builder->where('prodi_id', user()->prodi_id);
                }
            })
            ->toJson(true);
    }

    public function add_ditjen_dikti()
    {
        // set validation
        $validation = [
            'prodi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'is_unique' => 'Prodi sudah ada'
                ]
            ],
            'text_bagian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Text Bagian harus diisi',
                ]
            ],
            'text_bagian_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Text Bagian (English) harus diisi',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/form-management/ditjen-dikti-management')->withInput()->with('validation', $this->validator);
        }

        $this->ditjen_dikti_model->save([
            'prodi_id' => $this->request->getPost('prodi_id'),
            'text_bagian' => $this->request->getPost('text_bagian'),
            'text_bagian_en' => $this->request->getPost('text_bagian_en'),
        ]);

        return redirect()->to('/form-management/ditjen-dikti-management')->with('message-success', "Data Ditjen Dikti berhasil ditambahkan");
    }

    public function get_ditjen_dikti()
    {
        $id = $this->request->getPost('ditjen_dikti_id');

        $data = $this->ditjen_dikti_model->find($id);

        return json_encode($data);
    }

    public function update_ditjen_dikti()
    {
        // set validation
        $validation = [
            'prodi_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Prodi harus diisi',
                    'is_unique' => 'Prodi sudah ada'
                ]
            ],
            'text_bagian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Text Bagian harus diisi',
                ]
            ],
            'text_bagian_en' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Text Bagian (English) harus diisi',
                ]
            ],
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/form-management/ditjen-dikti-management')->withInput()->with('validation', $this->validator);
        }

        $this->ditjen_dikti_model->update($this->request->getPost('ditjen_dikti_id'), [
            'prodi_id' => $this->request->getPost('prodi_id'),
            'text_bagian' => $this->request->getPost('text_bagian'),
            'text_bagian_en' => $this->request->getPost('text_bagian_en'),
        ]);

        return redirect()->to('/form-management/ditjen-dikti-management')->with('message-success', "Data Ditjen Dikti berhasil diubah");
    }

    public function delete_ditjen_dikti()
    {
        $id = $this->request->getPost('id');

        $this->ditjen_dikti_model->delete($id);

        return json_encode(['status' => true]);
    }
}
