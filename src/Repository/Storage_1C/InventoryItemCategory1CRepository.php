<?php

namespace App\Repository\Storage_1C;

use App\Entity\Storage_1C\InventoryItemCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InventoryItemCategory1CRepository extends ServiceEntityRepository
{
    private const EMPTY = '';
    private const APPLIANCE = 'appliance';
    private const MODULE = 'module';


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InventoryItemCategory::class);
    }


    /**
     * @return InventoryItemCategory
     * @throws \Doctrine\ORM\ORMException
     */
    public function getEmptyInstance(): InventoryItemCategory
    {
        $category = self::findOneBy(['title' => self::EMPTY]);
        if (is_null($category)) {
            $category = new InventoryItemCategory();
            $category->setTitle(self::EMPTY);
            self::getEntityManager()->persist($category);
        }
        return $category;
    }

    /**
     * @return InventoryItemCategory
     * @throws \Doctrine\ORM\ORMException
     */
    public function getApplianceCategory(): InventoryItemCategory
    {
        $category = self::findOneBy(['title' => self::APPLIANCE]);
        if (is_null($category)) {
            $category = new InventoryItemCategory();
            $category->setTitle(self::APPLIANCE);
            self::getEntityManager()->persist($category);
        }
        return $category;
    }

    /**
     * @return InventoryItemCategory
     * @throws \Doctrine\ORM\ORMException
     */
    public function getModuleCategory(): InventoryItemCategory
    {
        $category = self::findOneBy(['title' => self::MODULE]);
        if (is_null($category)) {
            $category = new InventoryItemCategory();
            $category->setTitle(self::MODULE);
            self::getEntityManager()->persist($category);
        }
        return $category;
    }
}
