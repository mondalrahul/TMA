<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblContact
 *
 * @ORM\Table(name="boat_tbl_contact")
 * @ORM\Entity
 */
class BoatTblContact
{
    /**
     * @var integer
     *
     * @ORM\Column(name="contact_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $contactId;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=200, nullable=false)
     */
    private $contactName;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=200, nullable=false)
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_address", type="string", length=200, nullable=false)
     */
    private $contactAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_phone", type="string", length=100, nullable=false)
     */
    private $contactPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_meassge", type="text", length=65535, nullable=false)
     */
    private $contactMeassge;

    /**
     * @var string
     *
     * @ORM\Column(name="send_message", type="text", nullable=false)
     */
    private $sendMessage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="date", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="send_date", type="date", nullable=false)
     */
    private $sendDate;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_time", type="text", length=65535, nullable=false)
     */
    private $contactTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     */
    private $productId;

    /**
     * @var integer
     *
     * @ORM\Column(name="reply_or_not", type="integer", nullable=false)
     */
    private $replyOrNot;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=200, nullable=false)
     */
    private $productName;


}

