<?php
/**
 * Created by PhpStorm.
 * User: �������
 * Date: 29.01.2017
 * Time: 17:31
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HistoryRepository")
 */

class History
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="browsers", type="text")
     */
    private $browsers;

    /**
     * @var string
     *
     * @ORM\Column(name="referrers", type="text")
     */
    private $referrers;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="text")
     */
    private $ip;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Url", inversedBy="history")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    private $url;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;





    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set browsers
     *
     * @param string $browsers
     *
     * @return History
     */
    public function setBrowsers($browsers)
    {
        $this->browsers = $browsers;

        return $this;
    }

    /**
     * Get browsers
     *
     * @return string
     */
    public function getBrowsers()
    {
        return $this->browsers;
    }

    /**
     * Set referrers
     *
     * @param string $referrers
     *
     * @return History
     */
    public function setReferrers($referrers)
    {
        $this->referrers = $referrers;

        return $this;
    }

    /**
     * Get referrers
     *
     * @return string
     */
    public function getReferrers()
    {
        return $this->referrers;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return History
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return History
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set url
     *
     * @param \AppBundle\Entity\Url $url
     *
     * @return History
     */
    public function setUrl(\AppBundle\Entity\Url $url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return \AppBundle\Entity\Url
     */
    public function getUrl()
    {
        return $this->url;
    }
}
