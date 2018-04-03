<?php

namespace App\Entity\Equipment;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`softwareItems`", schema="equipment")
 */
class SoftwareItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $version;

    /**
     * @ORM\Column(type="json")
     */
    private $details;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment\Software", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__software_id", referencedColumnName="__id")
     */
    private $software;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\Appliance", mappedBy="software", fetch="EXTRA_LAZY")
     */
    private $appliance;




    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Software
     */
    public function getSoftware()
    {
        return $this->software;
    }

    /**
     * @param Software $software
     */
    public function setSoftware(Software $software)
    {
        $this->software = $software;
    }

    /**
     * @return Appliance
     */
    public function getAppliance()
    {
        return $this->appliance;
    }






}
