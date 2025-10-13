<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;

class BoatCategoryLogic
{
    use LogicDbTrait;

    /**
     * Get all boat category
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatCategory()
    {
        return $this->readDb(function ($manager, $conn) {
            $query = $manager->createQueryBuilder();
            $query->select('bc')
                ->from('App\Http\Models\Entities\BoatTblCategory', 'bc');

            return $query->getQuery()->getArrayResult();
        });
    }
}