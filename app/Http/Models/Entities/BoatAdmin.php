<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatAdmin
 *
 * @ORM\Table(name="boat_admin")
 * @ORM\Entity
 */
class BoatAdmin
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
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=50, nullable=false)
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=20, nullable=false)
     */
    private $pwd;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="header_text", type="text", length=65535, nullable=false)
     */
    private $headerText;

    /**
     * @var string
     *
     * @ORM\Column(name="paypal_email", type="string", length=200, nullable=false)
     */
    private $paypalEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="default_desc", type="text", length=65535, nullable=false)
     */
    private $defaultDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="default_keywords", type="text", length=65535, nullable=false)
     */
    private $defaultKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="footer_text", type="text", length=65535, nullable=false)
     */
    private $footerText;

    /**
     * @var string
     *
     * @ORM\Column(name="google_analytic", type="text", length=65535, nullable=false)
     */
    private $googleAnalytic;

    /**
     * @var string
     *
     * @ORM\Column(name="percentage", type="string", length=10, nullable=false)
     */
    private $percentage;

    /**
     * @var string
     *
     * @ORM\Column(name="site_title", type="string", length=200, nullable=false)
     */
    private $siteTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_photo", type="string", length=200, nullable=false)
     */
    private $profilePhoto;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=30, nullable=false)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=30, nullable=false)
     */
    private $lname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="date", nullable=false)
     */
    private $lastLogin;


}

