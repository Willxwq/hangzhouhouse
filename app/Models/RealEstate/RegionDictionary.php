<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class RegionDictionary extends BaseModel
{
    protected $table = 'region_dictionary';
    protected $connectionArr = ['mysql', 'mysql_sh', 'mysql_gz', 'mysql_cq', 'mysql_cd', 'mysql_sz', 'mysql_hf'];

    public function get()
    {
        return $this
            ->limit(5)
            ->get()->toArray();
    }

    public function getRegionList($type = 1, $districtId, $city)
    {
        $result = DB::connection($this->connectionArr[$city])
            ->table($this->table)
            ->where('type', '=', $type);
        if (!empty($districtId)) {
            $result->where('districtId', '=', $districtId);
        }
        return $result->get()->toArray();
    }
}
