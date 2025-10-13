<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblBoatExpiry
 *
 * @ORM\Table(name="tbl_boat_expiry")
 * @ORM\Entity
 */
class TblBoatExpiry
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
     * @var \DateTime
     *
     * @ORM\Column(name="active_form", type="date", nullable=false)
     */
    private $activeForm;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="active_to", type="date", nullable=false)
     */
    private $activeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="mfees", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $mfees;

    /**
     * @var string
     *
     * @ORM\Column(name="excess_deposit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excessDeposit;


}

