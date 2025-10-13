<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblPole
 *
 * @ORM\Table(name="boat_tbl_pole")
 * @ORM\Entity
 */
class BoatTblPole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pole_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $poleId;

    /**
     * @var string
     *
     * @ORM\Column(name="pole_question", type="text", length=65535, nullable=false)
     */
    private $poleQuestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date", nullable=false)
     */
    private $dateCreate;

    /**
     * @var string
     *
     * @ORM\Column(name="pole_description", type="text", length=65535, nullable=false)
     */
    private $poleDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="featured", type="integer", nullable=false)
     */
    private $featured;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="pole_status", type="string", length=2, nullable=false)
     */
    private $poleStatus;


}

