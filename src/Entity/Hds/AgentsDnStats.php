<?php

namespace App\Entity\Hds;

use App\Entity\Company\Office;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="agents_dn_stats", schema="hds")
 * @UniqueEntity("`location`")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class AgentsDnStats
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $stats;

    /**
     * Yesterday agent's phones id
     *
     * @ORM\Column(name="agents_phones", type="json")
     */
    private $agentsPhones;

    /**
     * @ORM\Column(name="`lastUpdate`", type="datetime")
     */
    private $lastUpdate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Company\Office", mappedBy="voiceAppliance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__location_id", referencedColumnName="__id", unique=true)
     */
    private $location;


    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        if (!($this->location instanceof Office)) {
            throw new \Exception('Invalid type of location');
        }

        if (!is_null($this->stats) && !is_array($this->stats)) {
            throw new \Exception('Invalid type of stats. Stats must be an array');
        }

        if (!is_null($this->agentsPhones) && !is_array($this->agentsPhones)) {
            throw new \Exception('Invalid type of agentsPhones. AgentsPhones must be an array');
        }

        // Location check
        $agentsDnStats = $event->getEntityManager()->getRepository(self::class)->findBy(['location' => $this->location]);
        if (count($agentsDnStats) > 1) {
            throw new \Exception('This value (id='.$this->location->getId().') of Location has duplicate in AgentsDnStats.');
        }
        if (count($agentsDnStats) == 1 && $agentsDnStats[0]->getId() != $this->getId()) {
            throw new \Exception('This value (id='.$this->location->getId().') of Location is already used in AgentsDnStats.');
        }
    }


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
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param mixed $stats
     */
    public function setStats($stats): void
    {
        $this->stats = $stats;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param mixed $lastUpdate
     */
    public function setLastUpdate($lastUpdate): void
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getAgentsPhones()
    {
        return $this->agentsPhones;
    }

    /**
     * @param mixed $agentsPhones
     */
    public function setAgentsPhones($agentsPhones): void
    {
        $this->agentsPhones = $agentsPhones;
    }
}
