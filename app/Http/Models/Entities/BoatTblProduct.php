<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;
/**
 * BoatTblProduct
 *
 * @ORM\Table(name="boat_tbl_product")
 * @ORM\Entity
 */
class BoatTblProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_id", type="text", length=65535, nullable=false)
     */
    private $catId;

    /**
     * @var string
     *
     * @ORM\Column(name="boat_model_id", type="text", length=65535, nullable=false)
     */
    private $boatModelId;

    /**
     * @var string
     *
     * @ORM\Column(name="length", type="string", length=10, nullable=false)
     */
    private $length;

    /**
     * @var string
     *
     * @ORM\Column(name="draft", type="string", length=20, nullable=true)
     */
    private $draft = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="make_id", type="text", length=65535, nullable=false)
     */
    private $makeId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=250, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="regnum", type="string", length=40, nullable=true)
     */
    private $regnum = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="product_details", type="text", nullable=false)
     */
    private $productDetails;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=200, nullable=false)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_comment", type="text", nullable=false)
     */
    private $ownerComment;

    /**
     * @var integer
     *
     * @ORM\Column(name="passenger", type="integer", nullable=false)
     */
    private $passenger;

    /**
     * @var string
     *
     * @ORM\Column(name="berthtype", type="string", length=10, nullable=true)
     */
    private $berthtype = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="string", length=10, nullable=true)
     */
    private $conditions = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_engine", type="integer", nullable=false)
     */
    private $numberOfEngine;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_year", type="string", length=30, nullable=false)
     */
    private $engineYear;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_make_model", type="string", length=200, nullable=false)
     */
    private $engineMakeModel;

    /**
     * @var integer
     *
     * @ORM\Column(name="engine_hours", type="integer", nullable=false)
     */
    private $engineHours;

    /**
     * @var string
     *
     * @ORM\Column(name="engine_size", type="string", length=200, nullable=false)
     */
    private $engineSize;

    /**
     * @var string
     *
     * @ORM\Column(name="strokes", type="string", length=200, nullable=false)
     */
    private $strokes;

    /**
     * @var string
     *
     * @ORM\Column(name="cooling_systems", type="string", length=200, nullable=false)
     */
    private $coolingSystems;

    /**
     * @var integer
     *
     * @ORM\Column(name="fuel_tank", type="integer", nullable=false)
     */
    private $fuelTank;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_type", type="string", length=200, nullable=false)
     */
    private $fuelType;

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_consumption", type="string", length=200, nullable=false)
     */
    private $fuelConsumption;

    /**
     * @var string
     *
     * @ORM\Column(name="radar_arch", type="string", length=200, nullable=false)
     */
    private $radarArch;

    /**
     * @var string
     *
     * @ORM\Column(name="radar", type="string", length=200, nullable=false)
     */
    private $radar;

    /**
     * @var string
     *
     * @ORM\Column(name="autopilot", type="string", length=200, nullable=false)
     */
    private $autopilot;

    /**
     * @var string
     *
     * @ORM\Column(name="cd_player", type="string", length=200, nullable=false)
     */
    private $cdPlayer;

    /**
     * @var string
     *
     * @ORM\Column(name="compass", type="string", length=200, nullable=false)
     */
    private $compass;

    /**
     * @var string
     *
     * @ORM\Column(name="cockpit_tables", type="string", length=200, nullable=false)
     */
    private $cockpitTables;

    /**
     * @var string
     *
     * @ORM\Column(name="depth_finder", type="string", length=200, nullable=false)
     */
    private $depthFinder;

    /**
     * @var string
     *
     * @ORM\Column(name="fish_finder", type="string", length=200, nullable=false)
     */
    private $fishFinder;

    /**
     * @var string
     *
     * @ORM\Column(name="gps", type="string", length=200, nullable=false)
     */
    private $gps;

    /**
     * @var string
     *
     * @ORM\Column(name="dvd_player", type="string", length=200, nullable=false)
     */
    private $dvdPlayer;

    /**
     * @var string
     *
     * @ORM\Column(name="sonar", type="string", length=200, nullable=false)
     */
    private $sonar;

    /**
     * @var string
     *
     * @ORM\Column(name="speedometer", type="string", length=200, nullable=false)
     */
    private $speedometer;

    /**
     * @var string
     *
     * @ORM\Column(name="vhf", type="string", length=200, nullable=false)
     */
    private $vhf;

    /**
     * @var string
     *
     * @ORM\Column(name="satellite_radio", type="string", length=200, nullable=false)
     */
    private $satelliteRadio;

    /**
     * @var string
     *
     * @ORM\Column(name="sound_system", type="string", length=200, nullable=false)
     */
    private $soundSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="spotlight", type="string", length=200, nullable=false)
     */
    private $spotlight;

    /**
     * @var string
     *
     * @ORM\Column(name="cabins", type="string", length=200, nullable=false)
     */
    private $cabins;

    /**
     * @var string
     *
     * @ORM\Column(name="aircon", type="string", length=200, nullable=false)
     */
    private $aircon;

    /**
     * @var string
     *
     * @ORM\Column(name="sleep_capacity", type="string", length=200, nullable=false)
     */
    private $sleepCapacity;

    /**
     * @var string
     *
     * @ORM\Column(name="cockpit_shower", type="string", length=200, nullable=false)
     */
    private $cockpitShower;

    /**
     * @var string
     *
     * @ORM\Column(name="marine_toilet", type="string", length=200, nullable=false)
     */
    private $marineToilet;

    /**
     * @var string
     *
     * @ORM\Column(name="macerator", type="string", length=200, nullable=false)
     */
    private $macerator;

    /**
     * @var string
     *
     * @ORM\Column(name="dinette", type="string", length=200, nullable=false)
     */
    private $dinette;

    /**
     * @var string
     *
     * @ORM\Column(name="tv", type="string", length=200, nullable=false)
     */
    private $tv;

    /**
     * @var string
     *
     * @ORM\Column(name="fridge", type="string", length=200, nullable=false)
     */
    private $fridge;

    /**
     * @var string
     *
     * @ORM\Column(name="hand_basin", type="string", length=200, nullable=false)
     */
    private $handBasin;

    /**
     * @var string
     *
     * @ORM\Column(name="hot_water", type="string", length=200, nullable=false)
     */
    private $hotWater;

    /**
     * @var string
     *
     * @ORM\Column(name="sink", type="string", length=200, nullable=false)
     */
    private $sink;

    /**
     * @var string
     *
     * @ORM\Column(name="counter_top", type="string", length=200, nullable=false)
     */
    private $counterTop;

    /**
     * @var string
     *
     * @ORM\Column(name="microwave", type="string", length=200, nullable=false)
     */
    private $microwave;

    /**
     * @var string
     *
     * @ORM\Column(name="anchor", type="string", length=200, nullable=false)
     */
    private $anchor;

    /**
     * @var string
     *
     * @ORM\Column(name="anchor_winch", type="string", length=200, nullable=false)
     */
    private $anchorWinch;

    /**
     * @var string
     *
     * @ORM\Column(name="cockpit_sette", type="string", length=200, nullable=false)
     */
    private $cockpitSette;

    /**
     * @var string
     *
     * @ORM\Column(name="pulpit", type="string", length=200, nullable=false)
     */
    private $pulpit;

    /**
     * @var string
     *
     * @ORM\Column(name="beverage_holder", type="string", length=200, nullable=false)
     */
    private $beverageHolder;

    /**
     * @var string
     *
     * @ORM\Column(name="bolster_seat", type="string", length=200, nullable=false)
     */
    private $bolsterSeat;

    /**
     * @var string
     *
     * @ORM\Column(name="transome", type="string", length=200, nullable=false)
     */
    private $transome;

    /**
     * @var string
     *
     * @ORM\Column(name="freshwater_washdown", type="string", length=200, nullable=false)
     */
    private $freshwaterWashdown;

    /**
     * @var string
     *
     * @ORM\Column(name="windsheild_wipers", type="string", length=200, nullable=false)
     */
    private $windsheildWipers;

    /**
     * @var string
     *
     * @ORM\Column(name="fore_sun_deck_pads", type="string", length=200, nullable=false)
     */
    private $foreSunDeckPads;

    /**
     * @var string
     *
     * @ORM\Column(name="hardtop", type="string", length=200, nullable=false)
     */
    private $hardtop;

    /**
     * @var string
     *
     * @ORM\Column(name="bimini", type="string", length=200, nullable=false)
     */
    private $bimini;

    /**
     * @var string
     *
     * @ORM\Column(name="plastic_cover", type="string", length=200, nullable=false)
     */
    private $plasticCover;

    /**
     * @var string
     *
     * @ORM\Column(name="rod_holder", type="string", length=200, nullable=false)
     */
    private $rodHolder;

    /**
     * @var string
     *
     * @ORM\Column(name="alerm", type="string", length=200, nullable=false)
     */
    private $alerm;

    /**
     * @var string
     *
     * @ORM\Column(name="bilge_pump", type="string", length=200, nullable=false)
     */
    private $bilgePump;

    /**
     * @var string
     *
     * @ORM\Column(name="fire_supression_system", type="string", length=200, nullable=false)
     */
    private $fireSupressionSystem;

    /**
     * @var string
     *
     * @ORM\Column(name="fume_detector", type="string", length=200, nullable=false)
     */
    private $fumeDetector;

    /**
     * @var string
     *
     * @ORM\Column(name="liferafts", type="string", length=200, nullable=false)
     */
    private $liferafts;

    /**
     * @var string
     *
     * @ORM\Column(name="life_jackets", type="string", length=200, nullable=false)
     */
    private $lifeJackets;

    /**
     * @var string
     *
     * @ORM\Column(name="flares", type="string", length=200, nullable=false)
     */
    private $flares;

    /**
     * @var string
     *
     * @ORM\Column(name="alternator", type="string", length=200, nullable=false)
     */
    private $alternator;

    /**
     * @var string
     *
     * @ORM\Column(name="battery", type="string", length=200, nullable=false)
     */
    private $battery;

    /**
     * @var string
     *
     * @ORM\Column(name="circuit_breaker", type="string", length=200, nullable=false)
     */
    private $circuitBreaker;

    /**
     * @var string
     *
     * @ORM\Column(name="shore_power", type="string", length=200, nullable=false)
     */
    private $shorePower;

    /**
     * @var string
     *
     * @ORM\Column(name="horn", type="string", length=200, nullable=false)
     */
    private $horn;

    /**
     * @var string
     *
     * @ORM\Column(name="night_lighting", type="string", length=200, nullable=false)
     */
    private $nightLighting;

    /**
     * @var string
     *
     * @ORM\Column(name="generator", type="string", length=200, nullable=false)
     */
    private $generator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date", nullable=false)
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="date", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var string
     *
     * @ORM\Column(name="product_page_title", type="text", length=65535, nullable=false)
     */
    private $productPageTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="product_page_desc", type="text", length=65535, nullable=false)
     */
    private $productPageDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="product_page_key", type="text", length=65535, nullable=false)
     */
    private $productPageKey;

    /**
     * @var string
     *
     * @ORM\Column(name="product_status", type="string", length=10, nullable=false)
     */
    private $productStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="product_price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $productPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="featured", type="integer", nullable=false)
     */
    private $featured;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=200, nullable=false)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=20, nullable=true)
     */
    private $contactPhone = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="text", length=65535, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=20, nullable=false)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=20, nullable=false)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=20, nullable=false)
     */
    private $longitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="viewed", type="integer", nullable=false)
     */
    private $viewed;

    /**
     * @var string
     *
     * @ORM\Column(name="activities", type="text", length=65535, nullable=false)
     */
    private $activities;

    /**
     * @var string
     *
     * @ORM\Column(name="downpayment", type="string", length=200, nullable=false)
     */
    private $downpayment;

    /**
     * @var string
     *
     * @ORM\Column(name="loan_tenure", type="string", length=200, nullable=false)
     */
    private $loanTenure;

    /**
     * @var string
     *
     * @ORM\Column(name="est_installment", type="string", length=200, nullable=false)
     */
    private $estInstallment;

    /**
     * @var string
     *
     * @ORM\Column(name="original_listing_id", type="string", length=200, nullable=false)
     */
    private $originalListingId;

    /**
     * @var string
     *
     * @ORM\Column(name="marina_location", type="string", length=50, nullable=true)
     */
    private $marinaLocation = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="propulsion_type", type="string", length=15, nullable=true)
     */
    private $propulsionType = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="hulltype", type="string", length=150, nullable=true)
     */
    private $hulltype = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="colour", type="string", length=100, nullable=true)
     */
    private $colour = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="hull_material", type="string", length=100, nullable=true)
     */
    private $hullMaterial = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="deck_material", type="string", length=100, nullable=true)
     */
    private $deckMaterial = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="displacement", type="string", length=100, nullable=true)
     */
    private $displacement = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="beam", type="string", length=10, nullable=false)
     */
    private $beam;

    /**
     * @var string
     *
     * @ORM\Column(name="max_speed", type="string", length=30, nullable=true)
     */
    private $maxSpeed = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="crusing_speed", type="string", length=30, nullable=true)
     */
    private $crusingSpeed = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="fuel_capacity", type="string", length=30, nullable=true)
     */
    private $fuelCapacity = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="water_capacity", type="string", length=30, nullable=true)
     */
    private $waterCapacity = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="sails_no", type="string", length=150, nullable=true)
     */
    private $sailsNo = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="sails_include", type="string", length=150, nullable=true)
     */
    private $sailsInclude = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="keel_type", type="string", length=150, nullable=true)
     */
    private $keelType = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="keel_meterial", type="string", length=150, nullable=true)
     */
    private $keelMeterial = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="ballast", type="string", length=150, nullable=true)
     */
    private $ballast = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="ruddertype", type="string", length=150, nullable=true)
     */
    private $ruddertype = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="no_rudder", type="string", length=150, nullable=true)
     */
    private $noRudder = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="deck_equipment", type="string", length=150, nullable=true)
     */
    private $deckEquipment = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="anchor_tackle", type="string", length=150, nullable=true)
     */
    private $anchorTackle = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="no_cabins", type="string", length=50, nullable=true)
     */
    private $noCabins = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="no_berth", type="string", length=50, nullable=true)
     */
    private $noBerth = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="gallery", type="string", length=5, nullable=true)
     */
    private $gallery = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="no_head", type="string", length=50, nullable=true)
     */
    private $noHead = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="head_type", type="string", length=50, nullable=true)
     */
    private $headType = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="no_showers", type="string", length=50, nullable=true)
     */
    private $noShowers = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="camper_canvus", type="string", length=5, nullable=true)
     */
    private $camperCanvus = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="boatcover", type="string", length=5, nullable=true)
     */
    private $boatcover = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="stove", type="string", length=5, nullable=true)
     */
    private $stove = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="ais", type="string", length=5, nullable=true)
     */
    private $ais = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="stereo", type="string", length=5, nullable=true)
     */
    private $stereo = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="watermaker", type="string", length=5, nullable=true)
     */
    private $watermaker = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="windgenerator", type="string", length=5, nullable=true)
     */
    private $windgenerator = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="solarpanels", type="string", length=5, nullable=true)
     */
    private $solarpanels = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="tender", type="string", length=5, nullable=true)
     */
    private $tender = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="tenderinfo", type="text", length=65535, nullable=true)
     */
    private $tenderinfo = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="other_feature", type="text", length=65535, nullable=true)
     */
    private $otherFeature = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="safety_equipment", type="text", length=65535, nullable=true)
     */
    private $safetyEquipment = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="item_include_sale", type="text", length=65535, nullable=true)
     */
    private $itemIncludeSale = 'NULL';


}

