<?php

namespace App\Repository\Storage_1C;

use App\Entity\Equipment\ModuleItem;
use App\Entity\Storage_1C\Module1C;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class Module1CRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Module1C::class);
    }


    /**
     * @param ModuleItem $voiceModule
     * @return Module1C|null
     */
    public function findOneByVoiceModule(ModuleItem $voiceModule)
    {
        $query = $this->getEntityManager()->createQuery('SELECT m FROM App\Entity\Storage_1C\Module1C m JOIN m.voiceModule vm WHERE vm.id = :id');
        $query->setParameter('id', $voiceModule->getId());
        return $query->getOneOrNullResult();
    }
}
