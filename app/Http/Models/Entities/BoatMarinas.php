<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatMarinas
 *
 * @ORM\Table(name="boat_marinas")
 * @ORM\Entity
 */
class BoatMarinas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="marinas_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $marinasId;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_name", type="string", length=200, nullable=false)
     */
    private $marinasName;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_status", type="string", length=10, nullable=false)
     */
    private $marinasStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_title", type="string", length=200, nullable=false)
     */
    private $marinasTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_address", type="text", length=65535, nullable=false)
     */
    private $marinasAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_external", type="text", length=65535, nullable=false)
     */
    private $marinasExternal;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_log", type="string", length=30, nullable=false)
     */
    private $marinasLog;

    /**
     * @var string
     *
     * @ORM\Column(name="marinas_lat", type="string", length=30, nullable=false)
     */
    private $marinasLat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=200, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="marina_img", type="string", length=200, nullable=false)
     */
    private $marinaImg;


}

