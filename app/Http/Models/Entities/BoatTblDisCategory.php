<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblDisCategory
 *
 * @ORM\Table(name="boat_tbl_dis_category")
 * @ORM\Entity
 */
class BoatTblDisCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="category_name", type="string", length=255, nullable=true)
     */
    private $categoryName = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="category_date", type="date", nullable=true)
     */
    private $categoryDate = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_status", type="string", length=10, nullable=true)
     */
    private $categoryStatus = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_image", type="string", length=250, nullable=true)
     */
    private $categoryImage = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_title", type="text", length=65535, nullable=true)
     */
    private $categoryTitle = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_meta_key", type="text", length=65535, nullable=true)
     */
    private $categoryMetaKey = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_meta_desc", type="text", length=65535, nullable=true)
     */
    private $categoryMetaDesc = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="category_description", type="text", length=65535, nullable=true)
     */
    private $categoryDescription = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="category_rank", type="integer", nullable=false)
     */
    private $categoryRank;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_type", type="integer", nullable=false)
     */
    private $categoryType;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=false)
     */
    private $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer", nullable=false)
     */
    private $views;


}

