<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblAllPhoto
 *
 * @ORM\Table(name="boat_tbl_all_photo")
 * @ORM\Entity
 */
class BoatTblAllPhoto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="photo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $photoId;

    /**
     * @var string
     *
     * @ORM\Column(name="main_photo", type="string", length=255, nullable=true)
     */
    private $mainPhoto = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="sess", type="string", length=250, nullable=false)
     */
    private $sess;

    /**
     * @var integer
     *
     * @ORM\Column(name="photo_rank", type="integer", nullable=false)
     */
    private $photoRank;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="photoalt", type="string", length=200, nullable=false)
     */
    private $photoalt;


}

