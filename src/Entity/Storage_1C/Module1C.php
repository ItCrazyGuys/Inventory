<?php

namespace App\Entity\Storage_1C;

use App\Entity\Equipment\ModuleItem;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Module1CRepository")
 * @ORM\Table(name="`modules1C`", schema="storage_1c")
 * @UniqueEntity("`inventoryData`")
 * @UniqueEntity("`voiceModule`")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Storage_1C\InventoryItem1C", fetch="EAGER")
     * @ORM\JoinColumn(name="__inventory_item_id", referencedColumnName="__id", unique=true)
     */
    private $inventoryData;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment\ModuleItem", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__voice_module_id", referencedColumnName="__id", unique=true, nullable=true)
     */
    private $voiceModule;




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
