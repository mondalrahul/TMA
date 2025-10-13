<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatSkipper
 *
 * @ORM\Table(name="boat_skipper")
 * @ORM\Entity
 */
class BoatSkipper
{
    /**
     * @var integer
     *
     * @ORM\Column(name="skipper_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $skipperId;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_name", type="string", length=200, nullable=false)
     */
    private $skipperName;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_rank", type="string", length=20, nullable=false)
     */
    private $skipperRank;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_nric", type="string", length=200, nullable=false)
     */
    private $skipperNric;

    /**
     * @var string
     *
     * @ORM\Column(name="bookedfor", type="string", length=20, nullable=false)
     */
    private $bookedfor;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_contact", type="string", length=20, nullable=false)
     */
    private $skipperContact;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_address", type="text", length=65535, nullable=false)
     */
    private $skipperAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_next_kin", type="string", length=100, nullable=false)
     */
    private $skipperNextKin;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_next_kin_address", type="text", length=65535, nullable=false)
     */
    private $skipperNextKinAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_rate", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $skipperRate;

    /**
     * @var string
     *
     * @ORM\Column(name="skipper_license", type="string", length=50, nullable=false)
     */
    private $skipperLicense;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;


}

