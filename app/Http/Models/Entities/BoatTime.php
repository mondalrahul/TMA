<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTime
 *
 * @ORM\Table(name="boat_time")
 * @ORM\Entity
 */
class BoatTime
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
     * @ORM\Column(name="time_from", type="integer", nullable=false)
     */
    private $timeFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_to", type="integer", nullable=false)
     */
    private $timeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="time_type", type="string", length=10, nullable=false)
     */
    private $timeType;

    /**
     * @var string
     *
     * @ORM\Column(name="time_type1", type="string", length=10, nullable=false)
     */
    private $timeType1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=200, nullable=false)
     */
    private $groupname;


}

