<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;

class HisPrice extends BaseModel
{
    protected $table = 'hisprice';

    public function get()
    {
        return $this
            ->limit(5)
            ->get()->toArray();
    }

    public function downcommunity()
    {
        return $this->select(DB::raw('count(*) AS y'), 'district AS x')
            ->groupBy('district')
            ->get()
            ->toArray();
    }
}
