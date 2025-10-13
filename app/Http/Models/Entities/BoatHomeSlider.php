<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatHomeSlider
 *
 * @ORM\Table(name="boat_home_slider")
 * @ORM\Entity
 */
class BoatHomeSlider
{
    /**
     * @var integer
     *
     * @ORM\Column(name="photo_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $photoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_image", type="text", length=65535, nullable=false)
     */
    private $photoImage;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="link_target", type="text", length=65535, nullable=false)
     */
    private $linkTarget;

    /**
     * @var string
     *
     * @ORM\Column(name="banneralt", type="string", length=200, nullable=true)
     */
    private $banneralt = 'NULL';


}

