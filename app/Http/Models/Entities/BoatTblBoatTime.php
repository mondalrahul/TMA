<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblBoatTime
 *
 * @ORM\Table(name="boat_tbl_boat_time")
 * @ORM\Entity
 */
class BoatTblBoatTime
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_id", type="integer", nullable=false)
     */
    private $timeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="added_by", type="integer", nullable=false)
     */
    private $addedBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_from", type="integer", nullable=false)
     */
    private $timeFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_to", type="integer", nullable=false)
     */
    private $timeTo;


}

