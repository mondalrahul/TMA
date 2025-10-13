<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblBoat
 *
 * @ORM\Table(name="boat_tbl_boat")
 * @ORM\Entity
 */
class BoatTblBoat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $boatId;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_name", type="string", length=200, nullable=false)
     */
    private $boatName;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_reg", type="string", length=100, nullable=false)
     */
    private $boatReg;

    /**
     * @var string
     *
     * @ORM\Column(name="mmsi", type="string", length=200, nullable=false)
     */
    private $mmsi;

    /**
     * @var string
     *
     * @ORM\Column(name="insurance_no", type="string", length=100, nullable=false)
     */
    private $insuranceNo;

    /**
     * @var string
     *
     * @ORM\Column(name="insurar", type="string", length=100, nullable=false)
     */
    private $insurar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insurance_exp", type="date", nullable=false)
     */
    private $insuranceExp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_inspection", type="date", nullable=false)
     */
    private $lastInspection;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_inspection", type="date", nullable=false)
     */
    private $nextInspection;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=100, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_type", type="string", length=20, nullable=false)
     */
    private $boatType;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_type", type="string", length=20, nullable=false)
     */
    private $fuelType;

    /**
     * @var string
     *
     * @ORM\Column(name="cost_hr", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $costHr;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_consumption", type="string", length=200, nullable=false)
     */
    private $fuelConsumption;

    /**
     * @var integer
     *
     * @ORM\Column(name="pax", type="integer", nullable=false)
     */
    private $pax;

    /**
     * @var integer
     *
     * @ORM\Column(name="marina", type="integer", nullable=false)
     */
    private $marina;

    /**
     * @var integer
     *
     * @ORM\Column(name="cruising", type="integer", nullable=false)
     */
    private $cruising;

    /**
     * @var integer
     *
     * @ORM\Column(name="party", type="integer", nullable=false)
     */
    private $party;

    /**
     * @var integer
     *
     * @ORM\Column(name="fishing", type="integer", nullable=false)
     */
    private $fishing;

    /**
     * @var integer
     *
     * @ORM\Column(name="wakeboarding", type="integer", nullable=false)
     */
    private $wakeboarding;

    /**
     * @var string
     *
     * @ORM\Column(name="other", type="string", length=200, nullable=false)
     */
    private $other;

    /**
     * @var string
     *
     * @ORM\Column(name="last_engine_hour", type="string", length=20, nullable=false)
     */
    private $lastEngineHour;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_maintain", type="date", nullable=false)
     */
    private $lastMaintain;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=5, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate_id", type="integer", nullable=false)
     */
    private $rateId;

    /**
     * @var integer
     *
     * @ORM\Column(name="self_drive", type="integer", nullable=false)
     */
    private $selfDrive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="main_photo", type="text", length=65535, nullable=false)
     */
    private $mainPhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="photo1", type="text", length=65535, nullable=false)
     */
    private $photo1;

    /**
     * @var string
     *
     * @ORM\Column(name="photo2", type="text", length=65535, nullable=false)
     */
    private $photo2;

    /**
     * @var string
     *
     * @ORM\Column(name="photo3", type="text", length=65535, nullable=false)
     */
    private $photo3;

    /**
     * @var string
     *
     * @ORM\Column(name="photo4", type="text", length=65535, nullable=false)
     */
    private $photo4;

    /**
     * @var string
     *
     * @ORM\Column(name="photo5", type="text", length=65535, nullable=false)
     */
    private $photo5;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

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
     * @ORM\Column(name="boat_details", type="text", length=65535, nullable=false)
     */
    private $boatDetails;

    /**
     * @var integer
     *
     * @ORM\Column(name="year_create", type="integer", nullable=false)
     */
    private $yearCreate;

    /**
     * @var string
     *
     * @ORM\Column(name="beam", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $beam;

    /**
     * @var integer
     *
     * @ORM\Column(name="no_engine", type="integer", nullable=false)
     */
    private $noEngine;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_type", type="string", length=30, nullable=false)
     */
    private $engineType;

    /**
     * @var integer
     *
     * @ORM\Column(name="head", type="integer", nullable=false)
     */
    private $head;

    /**
     * @var integer
     *
     * @ORM\Column(name="aircon", type="integer", nullable=false)
     */
    private $aircon;

    /**
     * @var integer
     *
     * @ORM\Column(name="gps", type="integer", nullable=false)
     */
    private $gps;

    /**
     * @var integer
     *
     * @ORM\Column(name="fishfinder", type="integer", nullable=false)
     */
    private $fishfinder;

    /**
     * @var integer
     *
     * @ORM\Column(name="vhf", type="integer", nullable=false)
     */
    private $vhf;

    /**
     * @var integer
     *
     * @ORM\Column(name="skipper_id", type="integer", nullable=false)
     */
    private $skipperId;

    /**
     * @var integer
     *
     * @ORM\Column(name="ispaid", type="integer", nullable=false)
     */
    private $ispaid;

    /**
     * @var integer
     *
     * @ORM\Column(name="bookedfor", type="integer", nullable=false)
     */
    private $bookedfor;

    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=20, nullable=false)
     */
    private $groupname;

    /**
     * @var string
     *
     * @ORM\Column(name="excess_deposit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $excessDeposit;

    /**
     * @var string
     *
     * @ORM\Column(name="charter_rate", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $charterRate;

    /**
     * @var string
     *
     * @ORM\Column(name="contractpaper", type="text", length=65535, nullable=false)
     */
    private $contractpaper;

    /**
     * @var string
     *
     * @ORM\Column(name="requirement", type="text", length=65535, nullable=false)
     */
    private $requirement;

    /**
     * @var integer
     *
     * @ORM\Column(name="charter_boat", type="integer", nullable=false)
     */
    private $charterBoat;

    /**
     * @var string
     *
     * @ORM\Column(name="charter_type", type="string", length=30, nullable=true)
     */
    private $charterType = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="manage", type="integer", nullable=false)
     */
    private $manage;

    /**
     * @var string
     *
     * @ORM\Column(name="contractpdf", type="string", length=250, nullable=true)
     */
    private $contractpdf = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="contractpdf1", type="string", length=250, nullable=true)
     */
    private $contractpdf1 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="contractpdf2", type="string", length=250, nullable=true)
     */
    private $contractpdf2 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="contractpdf3", type="text", length=65535, nullable=true)
     */
    private $contractpdf3 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="boatnote", type="text", length=65535, nullable=true)
     */
    private $boatnote = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="string", length=20, nullable=true)
     */
    private $length = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="main_imagealt", type="string", length=200, nullable=true)
     */
    private $mainImagealt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="photoonealt", type="string", length=200, nullable=true)
     */
    private $photoonealt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="phototwoalt", type="string", length=200, nullable=true)
     */
    private $phototwoalt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="photothreealt", type="string", length=200, nullable=true)
     */
    private $photothreealt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="photofouralt", type="string", length=200, nullable=true)
     */
    private $photofouralt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="photofivealt", type="string", length=200, nullable=true)
     */
    private $photofivealt = 'NULL';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_promoted", type="boolean", nullable=false)
     */
    private $isPromoted = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="promoted_text", type="text", length=65535, nullable=false)
     */
    private $promotedText;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_category", type="integer", nullable=true)
     */
    private $boatCategory = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_type_tma", type="integer", nullable=true)
     */
    private $boatTypeTma = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="paypal_address", type="string", length=255, nullable=true)
     */
    private $paypalAddress = 'NULL';

}

