<?php

namespace App\Entity\Storage_1C;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Storage_1C\NomenclatureTypeRepository")
 * @ORM\Table(name="`nomenclatureTypes`", schema="storage_1c")
 * @UniqueEntity("type")
 *
 * @ORM\HasLifecycleCallbacks()
 */
class NomenclatureType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="__id", type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotNull()
     * @Assert\Length(max="255")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storage_1C\Nomenclature1C", mappedBy="type", fetch="EXTRA_LAZY")
     */
    private $nomenclature;




    public function __construct()
    {
        $this->nomenclature = new ArrayCollection();
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
        if (is_null($this->type)) {
            throw new \Exception('This value should not be null.');
        }
        $foundNomenclatureTypes = $event->getEntityManager()->getRepository(self::class)->findBy(['type' => $this->type]);
        if (count($foundNomenclatureTypes) > 1) {
            throw new \Exception('This value ('.$this->type.') of Type has duplicate in NomenclatureType.');
        }
        if (count($foundNomenclatureTypes) == 1 && $foundNomenclatureTypes[0]->getId() != $this->getId()) {
            throw new \Exception('This value ('.$this->type.') of Type is already used in NomenclatureType.');
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return ArrayCollection|Nomenclature1C[]
     */
    public function getNomenclature()
    {
        return $this->nomenclature;
    }
}