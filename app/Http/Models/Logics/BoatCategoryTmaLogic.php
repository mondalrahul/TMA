<?php
namespace App\Http\Models\Logics;

use App\Http\Traits\LogicDbTrait;

class BoatCategoryTmaLogic
{
    use LogicDbTrait;

    /**
     * Get all boat category
     *
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getAllBoatCategoryTma()
    {
        return $this->readDb(function ($manager, $conn) {
            $query = $manager->createQueryBuilder();
            $query->select('bct')
                ->from('App\Http\Models\Entities\BoatTblCategoryTma', 'bct');

            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get specific boat category from BoatTblCategoryTma
     *
     * @param int $categoryId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatCategoryTma($categoryId)
    {
        return $this->readDb(function ($manager, $conn) use ($categoryId) {
            $query = $manager->createQueryBuilder();
            $query->select('bct')
                ->from('App\Http\Models\Entities\BoatTblCategoryTma', 'bct')
                ->where($query->expr()->eq('bct.categoryId', ':categoryId'))
                ->setParameter('categoryId', $categoryId);
            return $query->getQuery()->getArrayResult();
        });
    }

    /**
     * Get specific boat categoryBoatTblCategory
     *
     * @param int $categoryId
     * @return array
     * @author vduong daiduongptit090@gmail.com
     */
    public function getBoatCategoryNormal($categoryId)
    {
        return $this->readDb(function ($manager, $conn) use ($categoryId) {
            $query = $manager->createQueryBuilder();
            $query->select('bc')
                ->from('App\Http\Models\Entities\BoatTblCategory', 'bc')
                ->where($query->expr()->eq('bc.categoryId', ':categoryId'))
                ->setParameter('categoryId', $categoryId);
            return $query->getQuery()->getArrayResult();
        });
    }
}