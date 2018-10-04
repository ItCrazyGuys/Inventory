<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\MolRepository")
 * @ORM\Table(name="mols", schema="storage_1c")
 * @UniqueEntity("molTabNumber")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Mol
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(max="255")
     */
    private $fio;

    /**
     * @ORM\Column(name="`molTabNumber`", type="integer", unique=true)
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     */
    private $molTabNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\InventoryItem1C", mappedBy="mol", fetch="EXTRA_LAZY")
     */
    private $inventoryItems1C;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Storage_1C\Rooms1C", inversedBy="mols", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="`mol_rooms1C`", schema="storage_1c",
     *     joinColumns={@ORM\JoinColumn(name="__mol_id", referencedColumnName="__id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="__rooms_1c_id", referencedColumnName="__id")})
     */
    private $rooms1C;




    public function __construct()
    {
        $this->inventoryItems1C = new ArrayCollection();
        $this->rooms1C = new ArrayCollection();
    }

    /**
     * @ORM\PreFlush()
     *
     * @param PreFlushEventArgs $event
     * @throws \Exception
     */
    public function validate(PreFlushEventArgs $event)
    {
        // MolTabNumber check
        if (is_null($this->molTabNumber)) {
            throw new \Exception('This value of MolTabNumber should not be null.');
        }
        $foundMols = $event->getEntityManager()->getRepository(self::class)->findBy(['molTabNumber' => $this->molTabNumber]);
        if (count($foundMols) > 1) {
            throw new \Exception('This value ('.$this->molTabNumber.') of molTabNumber has duplicate in Mol.');
        }
        if (count($foundMols) == 1 && $foundMols[0]->getId() != $this->getId()) {
            throw new \Exception('This value ('.$this->molTabNumber.') of molTabNumber is already used in Mol.');
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * @param string $fio
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    }

    /**
     * @return int
     */
    public function getMolTabNumber()
    {
        return $this->molTabNumber;
    }

    /**
     * @param int $molTabNumber
     */
    public function setMolTabNumber($molTabNumber)
    {
        $this->molTabNumber = $molTabNumber;
    }

    /**
     * @return ArrayCollection|InventoryItem1C[]
     */
    public function getInventoryItems1C()
    {
        return $this->inventoryItems1C;
    }

    /**
     * @return ArrayCollection|Rooms1C[]
     */
    public function getRooms1C()
    {
        return $this->rooms1C;
    }

    public function addOffice1C(Rooms1C $rooms1C)
    {
        if ($this->rooms1C->contains($rooms1C)) {
            return;
        }
        $this->rooms1C[] = $rooms1C;
        $rooms1C->addMol($this);
    }

    public function removeOffice1C(Rooms1C $rooms1C)
    {
        if (!$this->rooms1C->contains($rooms1C)) {
            return;
        }
        $this->rooms1C->removeElement($this->rooms1C);
        $rooms1C->removeMol($this);
    }
}
