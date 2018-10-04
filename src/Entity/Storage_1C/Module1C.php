<?php

namespace App\Entity\Storage_1C;

use App\Entity\Equipment\ModuleItem;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Module1CRepository")
 * @ORM\Table(name="`modules1C`", schema="storage_1c")
 * @UniqueEntity("`inventoryData`")
 * @UniqueEntity("`voiceModule`")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Module1C
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
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\ModuleItem", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__voice_module_id", referencedColumnName="__id", unique=true, nullable=true)
     */
    private $voiceModule;




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

        if (!($this->voiceModule instanceof ModuleItem)) {
            throw new \Exception('Invalid type of ModuleItem');
        }

        // InventoryData check
        $foundModule1C = $event->getEntityManager()->getRepository(self::class)->findBy(['inventoryData' => $this->inventoryData]);
        if (count($foundModule1C) > 1) {
            throw new \Exception('This value (id='.$this->inventoryData->getId().') of InventoryItem1C has duplicate in Module1C.');
        }
        if (count($foundModule1C) == 1 && $foundModule1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value (id='.$this->inventoryData->getId().') of InventoryItem1C is already used in Module1C.');
        }

        // VoiceModule check
        $foundModule1C = $event->getEntityManager()->getRepository(self::class)->findBy(['voiceModule' => $this->voiceModule]);
        if (count($foundModule1C) > 1) {
            throw new \Exception('This value (id='.$this->voiceModule->getId().') of Module has duplicate in Module1C.');
        }
        if (count($foundModule1C) == 1 && $foundModule1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value (id='.$this->voiceModule->getId().') of Module is already used in Module1C.');
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
     * @return ModuleItem
     */
    public function getVoiceModule()
    {
        return $this->voiceModule;
    }

    /**
     * @param ModuleItem $voiceModule
     */
    public function setVoiceModule($voiceModule)
    {
        $this->voiceModule = $voiceModule;
    }
}
