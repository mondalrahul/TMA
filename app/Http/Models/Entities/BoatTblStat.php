<?php
namespace App\Http\Models\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoatTblStat
 *
 * @ORM\Table(name="boat_tbl_stat")
 * @ORM\Entity
 */
class BoatTblStat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="link_name", type="string", length=250, nullable=true)
     */
    private $linkName = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="file_data", type="text", nullable=true)
     */
    private $fileData = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="pgnm", type="string", length=250, nullable=true)
     */
    private $pgnm = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=true)
     */
    private $rank = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="m1", type="text", length=65535, nullable=true)
     */
    private $m1 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="m2", type="text", length=65535, nullable=true)
     */
    private $m2 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="m3", type="text", length=65535, nullable=true)
     */
    private $m3 = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="mcat", type="string", length=1, nullable=true)
     */
    private $mcat = '\'b\'';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status = '\'y\'';

    /**
     * @var string
     *
     * @ORM\Column(name="pgnm_php", type="string", length=250, nullable=true)
     */
    private $pgnmPhp = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="imgpath", type="string", length=255, nullable=false)
     */
    private $imgpath;

    /**
     * @var string
     *
     * @ORM\Column(name="substatus", type="string", length=255, nullable=false)
     */
    private $substatus = '\'n\'';

    /**
     * @var string
     *
     * @ORM\Column(name="display_in", type="string", length=20, nullable=false)
     */
    private $displayIn;

    /**
     * @var string
     *
     * @ORM\Column(name="parent", type="string", length=10, nullable=false)
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="display_to", type="string", length=20, nullable=false)
     */
    private $displayTo;

    /**
     * @var string
     *
     * @ORM\Column(name="external", type="text", length=65535, nullable=false)
     */
    private $external;

    /**
     * @var boolean
     *
     * @ORM\Column(name="product_cat_page", type="boolean", nullable=false)
     */
    private $productCatPage = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="session_id", type="string", length=50, nullable=false)
     */
    private $sessionId;


}

