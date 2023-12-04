<?php

namespace App\Controllers;

use CodeIgniter\Database\BaseBuilder;

class Home extends BaseController
{
    public function __construct()
    {
        $this->form_skpi_model = new \App\Models\FormSkpiModel();
        $this->user_model = new \Myth\Auth\Models\UserModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Home',
            'form_skpi' => $this->form_skpi_model
                ->join('master_prodi', 'master_prodi.id = form_skpi.prodi_id'),
            //     ->when(in_groups('fakultas'), function ($q) {
            //         return $q->where('master_prodi.fakultas_id', user()->fakultas_id);
            //     })
            //     ->when(in_groups('prodi'), function ($q) {
            //         return $q->where('prodi_id', user()->prodi_id);
            //     })
            //     ->countAllResults(),
            'user' => $this->user_model->countAll(),
        ];

        if (in_groups('fakultas')) {
            $data['form_skpi'] = $data['form_skpi']->where('master_prodi.fakultas_id', user()->fakultas_id)->countAllResults();
        } elseif (in_groups('prodi')) {
            $data['form_skpi'] = $data['form_skpi']->where('prodi_id', user()->prodi_id)->countAllResults();
        } else {
            $data['form_skpi'] = $data['form_skpi']->countAllResults();
        }

        return view('dashboard/index', $data);
        // return view('templates/export_pdf');
    }
}
