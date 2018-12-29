<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class SellInfo extends BaseModel
{
    protected $table = 'sellinfo';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }


    public function getSellInfoByCommunity($communityName)
    {
        //return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, ROUND(AVG(unitPrice)) AS unitPrice"))
        return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, count(*) AS count, ROUND(AVG(unitPrice)) AS unitPrice"))
            ->where('community', '=', $communityName)
            ->groupBy('time')
            ->get()
            ->toArray();
    }
}
