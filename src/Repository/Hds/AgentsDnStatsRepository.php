<?php

namespace App\Repository\Hds;

use App\Entity\Hds\AgentsDnStats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AgentsDnStatsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AgentsDnStats::class);
    }
}
