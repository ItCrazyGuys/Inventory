<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{

    /**
     * @Route("/test", name="test")
     * @param EntityManagerInterface $em
     * @throws \Doctrine\DBAL\DBALException
     */
    public function index(EntityManagerInterface $em)
    {

        $sql = '';
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $r = $stmt->fetchAll();
        dump($r);

        die;
    }

}
