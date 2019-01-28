<?php

namespace App\Repository\Hds;

use App\Entity\Hds\WeeklyAgentsDnStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class WeeklyAgentsDnStatsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WeeklyAgentsDnStats::class);
    }

}
