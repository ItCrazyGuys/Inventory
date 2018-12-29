<?php

namespace App\Controller;

use App\Entity\Hds\AgentsDnStats;
use App\Entity\Storage_1C\InventoryItem1C;
use App\Entity\Storage_1C\Nomenclature1C;
use App\Entity\View\InvItem1C;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{

    /**
     * @Route("/test", name="test")
     *
     * @param EntityManagerInterface $em
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function index(EntityManagerInterface $em)
    {
//        $invItem1CView = $em->getRepository(InventoryItem1C::class)->findBy(['serialNumber' => 'PUC16450N0K']);
        $invItem1CView = $em->getRepository(InventoryItem1C::class)->findBy(['inventoryNumber' => '437261']);

        dump($invItem1CView);

        die;

        $agentsPhones = null;
        dump(is_array($agentsPhones));

        die;

        $s = $em->getRepository(AgentsDnStats::class)->findAll();
        $s = $s[0];
        dump($s);
//        dump($s->getStats());
        dump(json_decode($s->getStats()));
//        dump(json_decode($s->getAgentsPhones));
        die;

        $location = $em->getRepository("Company:Office")->find(410);

        $stats = [
            ['prefix' => 559, 'min' => 1, 'max' =>8],
            ['prefix' => 558, 'min' => 4, 'max' =>18],
            ['prefix' => 555, 'min' => 8, 'max' =>33],
        ];
        $stats = json_encode($stats);

        $agentsPhones = [1122, 432, 5673, 22];
        $agentsPhones = json_encode($agentsPhones);

//        dump($stats);
//        dump($agentsPhones);

        $agentsDnStats = new AgentsDnStats();
        $agentsDnStats->setLocation($location);
        $agentsDnStats->setStats($stats);
        $agentsDnStats->setAgentsPhones($agentsPhones);
        $agentsDnStats->setLastUpdate(new \DateTime('now', new \DateTimeZone('UTC')));
//        $agentsDnStats->setLastUpdate(new \DateTime('now'));
        $em->persist($agentsDnStats);
        $em->flush();


        die;

        $v = [
            [
                'region' => '',
                'city' => '',
                'office' => '',
                'employees' => '',
                'hwactiv' => '',

                'agentsDnStats' => [
                    'byCucms' => [
                        'cc-559' => [
                            'min' => 1,
                            'max' => 10,
                            'yesterday' => 8
                        ],
                        'cc-558' => [
                            'cucm_hostname' => 'cc-558',
                            'min' => 3,
                            'max' => 12,
                            'yesterday' => 5
                        ]
                    ],
                    'byPhoneModel' => [
                        'model1' => 4,
                        'model2' => 14,
                    ]
                ]
            ]
        ];

        $a = [
            'office_id' => '',
            'agents_dn_stats' => [
                'cc-559' => [
                    'min' => 1,
                    'max' => 10,
                ],
                'cc-558' => [
                    'min' => 3,
                    'max' => 12,
                ]
            ],
            'yesterday_agents_phones_id' => ['id1', 'id2'],
        ];

        dump(json_encode($a));
        die;

        $sql = '';
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $r = $stmt->fetchAll();
        dump($r);

        die;
    }

}
