<?php

namespace App\Services\RealEstate;

use App\Services\BaseServices;
use Illuminate\Support\Facades\Cache;
use Phpml\Classification\Ensemble\RandomForest;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Exception\InvalidArgumentException;
use Phpml\Exception\LibsvmCommandException;
use Phpml\Dataset\ArrayDataset;

class DeepLearnService  extends BaseServices
{
    public function test()
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
