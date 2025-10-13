<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;
use Illuminate\Support\Facades\DB;

class BoatHomeSliderTmaLogic
{
    use LogicDbTrait;

    /**
     * Get all home slider active
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllHomeSliderActive()
    {
        return $this->readDb(function($manager, $conn) {
            $query = $manager->createQueryBuilder();
            $query->select('bh.sliderName, bh.sliderLink, bh.duration')
                ->from('App\Http\Models\Entities\BoatHomeSliderTma', 'bh')
                ->where($query->expr()->eq('bh.active', 1))
                ->orderBy('bh.updatedAt', 'DESC');

            return $query->getQuery()->getArrayResult();
        });

    }
}