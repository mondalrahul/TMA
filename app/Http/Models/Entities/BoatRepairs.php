<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatRepairs
 *
 * @ORM\Table(name="boat_repairs")
 * @ORM\Entity
 */
class BoatRepairs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="repair_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $repairId;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat", type="integer", nullable=false)
     */
    private $boat;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="repair_date", type="date", nullable=false)
     */
    private $repairDate;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;


}

