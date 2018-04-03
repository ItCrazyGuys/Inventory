<?php

namespace App\Controller;

use App\Entity\Storage_1C\Appliance1C;
use App\Entity\Storage_1C\City1C;
use App\Entity\Storage_1C\Mol;
use App\Entity\Storage_1C\Nomenclature1C;
use App\Entity\Storage_1C\Rooms1C;
use App\Entity\Storage_1C\Region1C;
use App\InventoryImporter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use function PHPSTORM_META\type;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends Controller
{

    /**
     * @Route("/test", name="test")
     */
    public function index()
    {

        die;
    }

}
