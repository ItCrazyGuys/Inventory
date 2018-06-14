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
    public function index(InventoryImporter $inventoryImporter)
    {

//        dump(empty(''));
//        die;

//        $line = '415949;FCH16439C50;Телефон Cisco 7942G (без блока питания);29.04.2013 0:00:00;МБП;Малчевский А.Л.;29387734614;Воронежский РО, г.Воронеж, Текстильщиков д. 2И, место хранения ТМЦ (Головной офис Воронеж);131465';

        $inventoryImporter->iFCsv();

        die;
    }

}
