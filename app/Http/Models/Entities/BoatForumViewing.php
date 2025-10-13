<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatForumViewing
 *
 * @ORM\Table(name="boat_forum_viewing")
 * @ORM\Entity
 */
class BoatForumViewing
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
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="sess", type="string", length=50, nullable=false)
     */
    private $sess;

    /**
     * @var integer
     *
     * @ORM\Column(name="timing", type="integer", nullable=false)
     */
    private $timing;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_id", type="integer", nullable=false)
     */
    private $catId;


}

