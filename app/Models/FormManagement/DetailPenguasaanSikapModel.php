<?php

namespace App\Models\FormManagement;

use CodeIgniter\Model;

class DetailPenguasaanSikapModel extends Model
{
    protected $table            = 'detail_penguasaan_sikap';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['penguasaan_sikap_id', 'isi_penguasaan_sikap', 'isi_penguasaan_sikap_en'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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
