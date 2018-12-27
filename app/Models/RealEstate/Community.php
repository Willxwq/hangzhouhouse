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

    public function getReggetCommunityDetailByBizcircleionList($params)
    {
        $ob = $this->where('bizcircle', '=', $params['bizcircle']);
        $count = $ob->count();

        if ($count) {
            $data['total'] = $count;
            $data['curPage'] = $params['start'];
            $data['pageSize'] = $params['length'];
            $data['totalPage'] = ceil($count / $params['length']);
        }
        $data['rows'] = $ob
            ->offset($params['start'])
            ->limit($params['length'])
            ->get()
            ->toArray();
        return $data;
    }
}
