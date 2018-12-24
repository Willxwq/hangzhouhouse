<?php

namespace App\Models\RealEstate;

use App\Models\BaseModel;
use Illuminate\Support\Facades\DB;

class Community extends BaseModel
{
    protected $table = 'community';

    public function get()
    {
        $builder = $this;

        return $builder
            ->limit(5)
            ->get()->toArray();
    }

    public function numOfCellsInEachRegion()
    {
        return $this->select(DB::raw('count(*) AS y'), 'district AS x')
            ->groupBy('district')
            ->get()
            ->toArray();
    }

    public function averagePriceRankingOfEachRegion()
    {
        return $this->select(DB::raw('ROUND(AVG(price), 2) AS y'), 'district AS x')
            ->groupBy('district')
            ->get()
            ->toArray();
    }

    public function getReggetCommunityDetailByBizcircleionList($bizcircle)
    {
        return $this->where('bizcircle', '=', $bizcircle)
            ->get();
    }
}
