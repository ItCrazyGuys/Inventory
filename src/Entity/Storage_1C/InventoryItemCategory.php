<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\InventoryItemCategory1CRepository")
 * @ORM\Table(name="categories", schema="storage_1c")
 * @UniqueEntity("title")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class InventoryItemCategory
{
    const MAX_LEN_TYPE = 255;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\InventoryItem1C", mappedBy="category", fetch="EXTRA_LAZY")
     */
    private $inventoryItems;




    public function __construct()
    {
        $this->inventoryItems = new ArrayCollection();
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        // Title check
        if (is_null($this->title)) {
            throw new \Exception('This value of Title should not be null.');
        }
        $foundInventoryItemCategories = $event->getEntityManager()->getRepository(self::class)->findBy(['title' => $this->title]);
        if (count($foundInventoryItemCategories) > 1) {
            throw new \Exception('This value ('.$this->title.') of Title has duplicate in InventoryItemCategory.');
        }
        if (count($foundInventoryItemCategories) == 1 && $foundInventoryItemCategories[0]->getId() != $this->getId()) {
            throw new \Exception('This value ('.$this->title.') of Title is already used in InventoryItemCategory.');
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
     * @param $title
     * @throws \Exception
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return ArrayCollection|InventoryItem1C[]
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }
}
