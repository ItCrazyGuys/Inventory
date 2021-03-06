<?php

namespace App\Entity\Storage_1C;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\InventoryItem1CRepository")
 * @ORM\Table(name="`inventoryItem1C`", schema="storage_1c")
 * @UniqueEntity("serialNumber")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class InventoryItem1C
{
    const EMPTY = '';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="`inventoryNumber`", type="string")
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $inventoryNumber;

    /**
     * @ORM\Column(name="`serialNumber`", type="string")
     * @Assert\Length(max="255")
     */
    private $serialNumber;

    /**
     * @ORM\Column(name="`dateOfRegistration`", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateOfRegistration;

    /**
     * @ORM\Column(name="`lastUpdate`", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $lastUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\InventoryItemCategory", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__category_id", referencedColumnName="__id")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Nomenclature1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__nomenclature_id", referencedColumnName="__id")
     */
    private $nomenclature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Mol", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__mol_id", referencedColumnName="__id")
     */
    private $mol;

    /**
     * Офис в котором находилось данное оборудование на момент даты его регистрации
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Storage_1C\Rooms1C", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="__rooms_1c_id", referencedColumnName="__id")
     */
    private $rooms1C;




    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        if (is_null($this->inventoryNumber)) {
            throw new \Exception('This value of InventoryNumber should not be null.');
        }

        if (!is_null($this->dateOfRegistration) && !($this->dateOfRegistration instanceof \DateTime)) {
            throw new \Exception('Invalid type of DateOfRegistration');
        }

        if (is_null($this->lastUpdate)) {
            throw new \Exception('This value of LastUpdate should not be null.');
        }

        if (!($this->lastUpdate instanceof \DateTime)) {
            throw new \Exception('Invalid type of LastUpdate');
        }

        if (!($this->category instanceof InventoryItemCategory)) {
            throw new \Exception('Invalid type of InventoryItemCategory');
        }

        if (!($this->nomenclature instanceof Nomenclature1C)) {
            throw new \Exception('Invalid type of Nomenclature1C');
        }

        if (!($this->mol instanceof Mol)) {
            throw new \Exception('Invalid type of Mol');
        }

        if (!($this->rooms1C instanceof Rooms1C)) {
            throw new \Exception('Invalid type of Rooms1C');
        }

        // Serial number check
        if (!empty($this->serialNumber)) {
            $foundInventoryItems1C = $event->getEntityManager()->getRepository(self::class)->findBy(['serialNumber' => $this->serialNumber]);
            if (count($foundInventoryItems1C) > 1) {
                throw new \Exception('This value ('.$this->serialNumber.') of SerialNumber has duplicate in InventoryItem1C.');
            }
            if (count($foundInventoryItems1C) == 1 && $foundInventoryItems1C[0]->getId() != $this->getId()) {
                throw new \Exception('This value ('.$this->serialNumber.') of SerialNumber is already used in InventoryItem1C.');
            }
        }

        // Inventory number check
        $foundInventoryItems1C = $event->getEntityManager()->getRepository(self::class)->findByInventoryNumberAndNomenclatureType($this->inventoryNumber, $this->nomenclature->getType()->getType());
        if (count($foundInventoryItems1C) > 1) {
            throw new \Exception('This value ('.$this->inventoryNumber.') of InventoryNumber has duplicate in NomenclatureType '.$this->nomenclature->getType()->getType());
        }
        if (count($foundInventoryItems1C) == 1 && $foundInventoryItems1C[0]->getId() != $this->getId()) {
            throw new \Exception('This value ('.$this->serialNumber.') of InventoryNumber is already used in NomenclatureType '.$this->nomenclature->getType()->getType());
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
    public function getInventoryNumber()
    {
        return $this->inventoryNumber;
    }

    /**
     * @param string $inventoryNumber
     */
    public function setInventoryNumber($inventoryNumber)
    {
        $this->inventoryNumber = $inventoryNumber;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    /**
     * @param string $serialNumber
     */
    public function setSerialNumber($serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }

    /**
     * @return mixed
     */
    public function getDateOfRegistration()
    {
        return $this->dateOfRegistration;
    }

    /**
     * @param \DateTime $dateOfRegistration
     */
    public function setDateOfRegistration(\DateTime $dateOfRegistration)
    {
        $this->dateOfRegistration = $dateOfRegistration;
    }

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime $lastUpdate
     */
    public function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return Nomenclature1C
     */
    public function getNomenclature()
    {
        return $this->nomenclature;
    }

    /**
     * @param Nomenclature1C $nomenclature
     */
    public function setNomenclature(Nomenclature1C $nomenclature)
    {
        $this->nomenclature = $nomenclature;
    }

    /**
     * @return Mol
     */
    public function getMol()
    {
        return $this->mol;
    }

    /**
     * @param Mol $mol
     */
    public function setMol(Mol $mol)
    {
        $this->mol = $mol;
    }

    /**
     * @return Rooms1C
     */
    public function getRooms1C()
    {
        return $this->rooms1C;
    }

    /**
     * @param Rooms1C $rooms1C
     */
    public function setRooms1C(Rooms1C $rooms1C)
    {
        $this->rooms1C = $rooms1C;
    }

    /**
     * @return InventoryItemCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param InventoryItemCategory $category
     */
    public function setCategory(InventoryItemCategory $category)
    {
        $this->category = $category;
    }
}
