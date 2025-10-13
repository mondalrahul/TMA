<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblMake
 *
 * @ORM\Table(name="boat_tbl_make")
 * @ORM\Entity
 */
class BoatTblMake
{
    /**
     * @var integer
     *
     * @ORM\Column(name="make_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $makeId;

    /**
     * @var string
     *
     * @ORM\Column(name="make_name", type="string", length=255, nullable=false)
     */
    private $makeName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="make_date", type="date", nullable=false)
     */
    private $makeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="make_status", type="string", length=10, nullable=false)
     */
    private $makeStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="parentcategory", type="text", length=65535, nullable=false)
     */
    private $parentcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="make_title", type="text", length=65535, nullable=false)
     */
    private $makeTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="make_meta_key", type="text", length=65535, nullable=false)
     */
    private $makeMetaKey;

    /**
     * @var string
     *
     * @ORM\Column(name="make_meta_desc", type="text", length=65535, nullable=false)
     */
    private $makeMetaDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="make_description", type="text", nullable=false)
     */
    private $makeDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="make_rank", type="integer", nullable=false)
     */
    private $makeRank;

    /**
     * @var string
     *
     * @ORM\Column(name="make_slug", type="text", length=65535, nullable=false)
     */
    private $makeSlug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;


}

