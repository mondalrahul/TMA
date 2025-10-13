<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblNews
 *
 * @ORM\Table(name="boat_tbl_news")
 * @ORM\Entity
 */
class BoatTblNews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="news_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $newsId;

    /**
     * @var string
     *
     * @ORM\Column(name="news_author", type="string", length=200, nullable=false)
     */
    private $newsAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="news_details", type="text", nullable=false)
     */
    private $newsDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="add_date", type="date", nullable=false)
     */
    private $addDate;

    /**
     * @var string
     *
     * @ORM\Column(name="news_status", type="string", length=10, nullable=false)
     */
    private $newsStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="news_external", type="text", length=65535, nullable=false)
     */
    private $newsExternal;

    /**
     * @var string
     *
     * @ORM\Column(name="news_title", type="text", length=65535, nullable=false)
     */
    private $newsTitle;


}

