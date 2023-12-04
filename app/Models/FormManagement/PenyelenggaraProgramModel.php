<?php

namespace App\Models\FormManagement;

use CodeIgniter\Model;

class PenyelenggaraProgramModel extends Model
{
    protected $table            = 'penyelenggara_program';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['program_studi', 'program_studi_en', 'status_akreditasi', 'jenis_pendidikan', 'jenis_pendidikan_en', 'jenjang_pendidikan', 'jenjang_pendidikan_en', 'jenjang_pendidikan_sesuai_kkni', 'persyaratan_penerimaan', 'persyaratan_penerimaan_en', 'bahasa_pengantar_kuliah', 'bahasa_pengantar_kuliah_en', 'sistem_penilaian', 'lama_studi', 'lama_studi_en', 'jenis_jenjang_pendidikan_lanjutan', 'prodi', 'fakultas'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // custom when function
    public function when($status, $key, $value)
    {
        if ($status) {
            $this->where($key, $value);
        }

        return $this;
    }
}
