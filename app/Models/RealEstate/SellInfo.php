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
        if ($params['showType'] == 1) {
            if ($params['type'] == 1) {
                $num = "s.totalPrice / h.totalPrice";
            } else {
                $num = "h.totalPrice / s.totalPrice";
            }
            $select = "TRUNCATE((1 - ". $num .") * 100, 2)";
            $num = "(1 - ". $num .")";
        } else {
            if ($params['type'] == 1) {
                $num = "h.totalPrice - s.totalPrice";
            } else {
                $num = "s.totalPrice - h.totalPrice";
            }
            $select = $num;
        }

        $ob = DB::table('sellinfo as s')
            ->select(DB::raw($select ." AS ups_or_downs"))
            ->addSelect("s.title","s.totalPrice AS salePrice", "h.totalPrice", "s.link", "s.dealdate",
                                "h.unitPrice", "h.validdate", "c.his")
            ->leftJoin('houseinfo as h', 's.houseID', '=', 'h.houseID')
            ->join(DB::raw("(SELECT houseID, group_concat( totalPrice ORDER BY date ASC SEPARATOR '->') AS his FROM hisprice GROUP BY houseID) 
                                    AS c"),'c.houseID','=','s.houseID')
            ->where('s.dealdate', '>=', $startTime)
            ->where('s.dealdate', '<=', date('Y-m-d', time()))
            ->whereRaw($num ." > 0")
            ->whereRaw('(s.totalPrice - h.totalPrice) IS NOT NULL')
            ->orderBy('ups_or_downs', 'desc');

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

        //$data['total'] = $count;
        //$data['curPage'] = 1;
        //$data['pageSize'] = 1;
        //$data['totalPage'] = 1;

        return $data;
    }
}
