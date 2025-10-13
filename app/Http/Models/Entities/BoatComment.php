<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatComment
 *
 * @ORM\Table(name="boat_comment")
 * @ORM\Entity
 */
class BoatComment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="comment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $commentId;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_title", type="string", length=200, nullable=true)
     */
    private $commentTitle = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="comment_from", type="integer", nullable=false)
     */
    private $commentFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="boat_id", type="integer", nullable=false)
     */
    private $boatId;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent", type="integer", nullable=false)
     */
    private $parent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=2, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer", nullable=false)
     */
    private $rate;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=false)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="invoice", type="string", length=12, nullable=true)
     */
    private $invoice = 'NULL';


}

