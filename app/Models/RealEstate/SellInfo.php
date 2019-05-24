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
        /* 打印SQL
         * DB::connection()->enableQueryLog();
        $result = DB::table('sellinfo as s')->get();
        $log = DB::getQueryLog();
        self::elog($log);*/
        //return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, ROUND(AVG(unitPrice)) AS unitPrice"))
        return $this->select(DB::raw("DATE_FORMAT(dealdate,'%Y-%m') as time, count(*) AS count, ROUND(AVG(unitPrice)) AS unitPrice"))
            ->where('community', '=', $communityName)
            ->groupBy('time')
            ->get()
            ->toArray();
    }

    public function getSellUpsAndDowns($params)
    {
        $startTime = date('Y-m-d',strtotime('-'. $params['time'] .' month'));
        if ($params['type'] == 1) {
            $num = "s.totalPrice / h.totalPrice";
        } else {
            $num = "h.totalPrice / s.totalPrice";
        }
        $data['rows'] = DB::table('sellinfo as s')
            ->select(DB::raw("TRUNCATE((1 - ". $num .") * 100, 2) AS ups_or_downs"))
            ->addSelect("s.houseID","s.totalPrice AS salePrice", "h.totalPrice", "s.link", "s.dealdate",
                                "h.community", "h.square", "h.unitPrice", "h.validdate", "c.his")
            ->leftJoin('houseinfo as h', 's.houseID', '=', 'h.houseID')
            ->join(DB::raw("(SELECT houseID, group_concat( totalPrice ORDER BY date ASC SEPARATOR '->') AS his FROM hisprice GROUP BY houseID) 
                                    AS c"),'c.houseID','=','s.houseID')
            ->where('s.dealdate', '>=', $startTime)
            ->where('s.dealdate', '<=', date('Y-m-d', time()))
            ->whereRaw('(s.totalPrice - h.totalPrice) IS NOT NULL')
            ->orderBy('ups_or_downs', 'desc')
            ->offset(0)
            ->limit(100)
            ->get()
            ->toArray();

        $data['total'] = count($data['rows']);
        $data['curPage'] = 1;
        $data['pageSize'] = 1;
        $data['totalPage'] = 1;

        return $data;
    }
}
