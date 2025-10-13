<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblMakeModel
 *
 * @ORM\Table(name="boat_tbl_make_model")
 * @ORM\Entity
 */
class BoatTblMakeModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="boat_model_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $boatModelId;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_make_id", type="text", length=65535, nullable=false)
     */
    private $boatMakeId;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_model_name", type="text", length=65535, nullable=false)
     */
    private $boatModelName;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_model_description", type="text", nullable=false)
     */
    private $boatModelDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_model_url", type="text", length=65535, nullable=false)
     */
    private $boatModelUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="length", type="integer", nullable=false)
     */
    private $length;

    /**
     * @var integer
     *
     * @ORM\Column(name="beam", type="integer", nullable=false)
     */
    private $beam;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="hulltype", type="string", length=200, nullable=false)
     */
    private $hulltype;

    /**
     * @var string
     *
     * @ORM\Column(name="act_fishing", type="string", length=200, nullable=false)
     */
    private $actFishing;

    /**
     * @var string
     *
     * @ORM\Column(name="act_watersports", type="string", length=200, nullable=false)
     */
    private $actWatersports;

    /**
     * @var string
     *
     * @ORM\Column(name="act_day_cruise", type="string", length=200, nullable=false)
     */
    private $actDayCruise;

    /**
     * @var string
     *
     * @ORM\Column(name="act_live_aboard", type="string", length=200, nullable=false)
     */
    private $actLiveAboard;

    /**
     * @var string
     *
     * @ORM\Column(name="act_overnight_cruise", type="string", length=200, nullable=false)
     */
    private $actOvernightCruise;

    /**
     * @var integer
     *
     * @ORM\Column(name="pax", type="integer", nullable=false)
     */
    private $pax;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_id", type="text", length=65535, nullable=false)
     */
    private $catId;

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
     * @ORM\Column(name="engine_type", type="string", length=200, nullable=false)
     */
    private $engineType;

    /**
     * @var string
     *
     * @ORM\Column(name="cabins", type="string", length=200, nullable=false)
     */
    private $cabins;

    /**
     * @var string
     *
     * @ORM\Column(name="toilet", type="string", length=200, nullable=false)
     */
    private $toilet;

    /**
     * @var string
     *
     * @ORM\Column(name="transom", type="string", length=200, nullable=false)
     */
    private $transom;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_engines", type="integer", nullable=false)
     */
    private $numEngines;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_make", type="string", length=200, nullable=false)
     */
    private $engineMake;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_size", type="string", length=200, nullable=false)
     */
    private $engineSize;

    /**
     * @var string
     *
     * @ORM\Column(name="year_from", type="text", length=65535, nullable=false)
     */
    private $yearFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="year_to", type="text", length=65535, nullable=false)
     */
    private $yearTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="date", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=false)
     */
    private $status;


}

