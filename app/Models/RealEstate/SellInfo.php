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

    public function getSellUpsAndDowns()
    {
        return DB::table('sellinfo as s')
            ->select(DB::raw("s.houseID,s.totalPrice AS salePrice, h.totalPrice, (s.totalPrice - h.totalPrice) AS ups_or_downs, s.link, s.dealdate"))
            ->leftJoin('houseinfo as h', 's.houseID', '=', 'h.houseID')
            ->whereBetween('s.dealdate', ["2019-02-30", "2019-03-30"])
            ->orderBy('ups_or_downs')
            ->offset(0)
            ->limit(10)
            ->get()
            ->toArray();
    }
}
