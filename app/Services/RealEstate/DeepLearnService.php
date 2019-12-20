<?php

namespace App\Services\RealEstate;

use App\Services\BaseServices;
use Illuminate\Support\Facades\Cache;
use Phpml\Classification\Ensemble\RandomForest;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Exception\InvalidArgumentException;
use Phpml\Exception\LibsvmCommandException;
use Phpml\Dataset\ArrayDataset;
use Phpml\Association\Apriori;

class DeepLearnService  extends BaseServices
{
    public function test()
    {
        $samples = (new TestDataService)::getTestData();

        try {

            // try body
            $labels  = [];
            //$samples = [
            //    ['啤酒', '尿布', '儿童玩具'],
            //    ['尿布', '儿童玩具','笔记本电脑'],
            //    ['啤酒','耳机', '唇膏'],
            //    ['啤酒','唇膏', '高跟鞋']
            //];
            $associator = new Apriori($support = 0.1, $confidence = 0.1);
            $associator->train($samples, $labels);

            $res = $associator->apriori();
            self::elog($res);

            $res = $associator->predict([20]);

            //self::elog($res);
            $rules = $associator->getRules();
            self::elog($res);
            self::elog($rules);

        } catch (LibsvmCommandException $e) {
            self::elog("-----false------");
        } catch (InvalidArgumentException $e) {
        }
    }

    public function test_bak()
    {
        $redis = Cache::store('redis');
        $data = json_decode($redis->get('city0'));

        $datumM = [];
        $samples = [];
        $labels = [];
        foreach ($data as $datum) {
            if (empty($datum->deldate_year)) {
                continue;
            }
            for ($i = 1; $i <= 12; $i++) {
                $m = 'median_' . $i;
                if (!empty($datum->$m)) {
                    $medianPrice = collect(array_unique(explode(',', $datum->$m)))->median();
                    if (empty($medianPrice)) {
                        continue;
                    }
                    $labels[] = (integer)$medianPrice;
                    $samples[] = [$datum->deldate_year, $i];
                    $datumM[] = ["price" => $medianPrice, "year" => $datum->deldate_year, "month" => $i];
                }
            }
        }
        try {
            $dataSet = new ArrayDataset($samples, $labels);

            $dataSet = new RandomSplit($dataSet);
            // train group
            $sample = $dataSet->getTrainSamples();
            $label = $dataSet->getTrainLabels();

            $RandomForest = new RandomForest();
            $RandomForest->train($sample,$label);

            $result = $RandomForest->predict([[2019, 1], [2019, 2], [2019, 3], [2019, 4], [2019, 5], [2019, 6], [2019, 7],
                [2019, 8], [2019, 9]]);

            self::elog($sample);
            self::elog($result);
        } catch (LibsvmCommandException $e) {
            self::elog("-----false------");
        } catch (InvalidArgumentException $e) {
        }

    }
}
