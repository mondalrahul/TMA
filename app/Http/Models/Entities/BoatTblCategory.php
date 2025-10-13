<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblCategory
 *
 * @ORM\Table(name="boat_tbl_category")
 * @ORM\Entity
 */
class BoatTblCategory
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
     * @ORM\Column(name="category_name", type="string", length=255, nullable=false)
     */
    private $categoryName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="category_date", type="date", nullable=false)
     */
    private $categoryDate;

    /**
     * @var string
     *
     * @ORM\Column(name="category_status", type="string", length=10, nullable=false)
     */
    private $categoryStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="parentcategory", type="string", length=10, nullable=false)
     */
    private $parentcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="category_image", type="string", length=250, nullable=false)
     */
    private $categoryImage;

    /**
     * @var string
     *
     * @ORM\Column(name="category_title", type="text", length=65535, nullable=false)
     */
    private $categoryTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="category_meta_key", type="text", length=65535, nullable=false)
     */
    private $categoryMetaKey;

    /**
     * @var string
     *
     * @ORM\Column(name="category_meta_desc", type="text", length=65535, nullable=false)
     */
    private $categoryMetaDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="category_description", type="text", nullable=false)
     */
    private $categoryDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="default1", type="string", length=10, nullable=false)
     */
    private $default1;

    /**
     * @var string
     *
     * @ORM\Column(name="category_slug", type="text", length=65535, nullable=false)
     */
    private $categorySlug;


}

