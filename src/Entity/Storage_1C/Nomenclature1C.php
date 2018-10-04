<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\Nomenclature1CRepository")
 * @ORM\Table(name="`nomenclature1C`", schema="storage_1c")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Nomenclature1C
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotNull()
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\NomenclatureType", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__type_id", referencedColumnName="__id")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\InventoryItem1C", mappedBy="nomenclature", fetch="EXTRA_LAZY")
     */
    private $inventoryItems1C;




    public function __construct()
    {
        $this->inventoryItems1C = new ArrayCollection();
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        // Type check
        if (!($this->type instanceof NomenclatureType)) {
            throw new \Exception('Invalid type of NomenclatureType');
        }

        // Title check
        if (is_null($this->title)) {
            throw new \Exception('This value of Title should not be null.');
        }
        $foundNomenclature1C = $event->getEntityManager()->getRepository(self::class)->findByTitleAndNomenclatureType($this->title, $this->type->getType());
        if (count($foundNomenclature1C) > 1) {
            throw new \Exception('This value ('.$this->title.') of Title with value ('.$this->type->getType().') of NomenclatureType has duplicate in Nomenclature1C.');
        }
        if (count($foundNomenclature1C) == 1 && $foundNomenclature1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value ('.$this->title.') of Title with value ('.$this->type->getType().') of NomenclatureType is already used in Nomenclature1C.');
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return NomenclatureType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param NomenclatureType $type
     */
    public function setType(NomenclatureType $type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection|InventoryItem1C[]
     */
    public function getInventoryItems1C()
    {
        return $this->inventoryItems1C;
    }
}
