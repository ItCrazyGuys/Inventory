<?php

namespace App\Entity\Hds;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class WeeklyAgentsDnStats
 * @package App\Entity\Hds
 *
 * @ORM\Entity(repositoryClass="App\Repository\Hds\WeeklyAgentsDnStatsRepository")
 * @ORM\Table(name="hds_weekly_agents_dn_statistics", schema="hds")
 */
class WeeklyAgentsDnStats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $week;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="`lotusId`", type="integer")
     */
    private $lotusId;

    /**
     * @ORM\Column(type="text")
     */
    private $prefix;

    /**
     * @ORM\Column(type="text")
     */
    private $dn;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week): void
    {
        $this->week = $week;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getLotusId()
    {
        return $this->lotusId;
    }

    /**
     * @param mixed $lotusId
     */
    public function setLotusId($lotusId): void
    {
        $this->lotusId = $lotusId;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $prefix
     */
    public function setPrefix($prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function getDn()
    {
        return $this->dn;
    }

    /**
     * @param mixed $dn
     */
    public function setDn($dn): void
    {
        $this->dn = $dn;
    }
}
