<?php

namespace App\Entity\Storage_1C;

use App\Entity\Equipment\Appliance;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Appliance1CRepository")
 * @ORM\Table(name="`appliances1C`", schema="storage_1c")
 * @UniqueEntity("`inventoryData`")
 * @UniqueEntity("`voiceAppliance`")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Appliance1C
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Storage_1C\InventoryItem1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__inventory_item_id", referencedColumnName="__id", unique=true)
     */
    private $inventoryData;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\Appliance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__voice_appliance_id", referencedColumnName="__id", unique=true, nullable=true)
     */
    private $voiceAppliance;




    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        if (!($this->inventoryData instanceof InventoryItem1C)) {
            throw new \Exception('Invalid type of InventoryItem1C');
        }

        if (!($this->voiceAppliance instanceof Appliance)) {
            throw new \Exception('Invalid type of Appliance');
        }

        // InventoryData check
        $foundAppliance1C = $event->getEntityManager()->getRepository(self::class)->findBy(['inventoryData' => $this->inventoryData]);
        if (count($foundAppliance1C) > 1) {
            throw new \Exception('This value (id='.$this->inventoryData->getId().') of InventoryItem1C has duplicate in Appliance1C.');
        }
        if (count($foundAppliance1C) == 1 && $foundAppliance1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value (id='.$this->inventoryData->getId().') of InventoryItem1C is already used in Appliance1C.');
        }

        // VoiceAppliance check
        $foundAppliance1C = $event->getEntityManager()->getRepository(self::class)->findBy(['voiceAppliance' => $this->voiceAppliance]);
        if (count($foundAppliance1C) > 1) {
            throw new \Exception('This value (id='.$this->voiceAppliance->getId().') of Appliance has duplicate in Appliance1C.');
        }
        if (count($foundAppliance1C) == 1 && $foundAppliance1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value (id='.$this->voiceAppliance->getId().') of Appliance is already used in Appliance1C.');
        }
    }

    /**
     * @return InventoryItem1C
     */
    public function getInventoryData()
    {
        return $this->inventoryData;
    }

    /**
     * @param InventoryItem1C $inventoryData
     */
    public function setInventoryData(InventoryItem1C $inventoryData)
    {
        $this->inventoryData = $inventoryData;
    }

    /**
     * @return Appliance
     */
    public function getVoiceAppliance()
    {
        return $this->voiceAppliance;
    }

    /**
     * @param Appliance $voiceAppliance
     */
    public function setVoiceAppliance($voiceAppliance)
    {
        $this->voiceAppliance = $voiceAppliance;
    }
}
