<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;

class HomeLogic
{
    use LogicDbTrait;

    /**
     * Description
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getCountry()
    {
        return $this->readDb(function ($manager, $conn) {
            echo '<pre>';
            $query = $manager->createQueryBuilder();
            $query->select('c.name')
                ->from('App\Http\Models\Entities\BoatCountry', 'c');

            print_r($query->getQuery()->getResult());
        });
    }
}