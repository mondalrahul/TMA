<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatSampleFile
 *
 * @ORM\Table(name="boat_sample_file")
 * @ORM\Entity
 */
class BoatSampleFile
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
     * @ORM\Column(name="boat_certificate", type="text", length=65535, nullable=false)
     */
    private $boatCertificate;

    /**
     * @var string
     *
     * @ORM\Column(name="charter_certificate", type="text", length=65535, nullable=false)
     */
    private $charterCertificate;

    /**
     * @var string
     *
     * @ORM\Column(name="account_certificate", type="text", length=65535, nullable=false)
     */
    private $accountCertificate;


}

