<?php
namespace App\Controller\Api;

use App\Service\IpData\IpDataService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IpDataController extends Controller
{
    private const HTTP_STATUS_CODE_SUCCESS = '200';
    private const HTTP_STATUS_SERVER_ERROR = '500';

    /**
     * @Route("/api/ipdata/get/all")
     * @Method("GET")
     *
     * @param IpDataService $ipDataService
     * @return Response
     */
    public function getAllIpData(IpDataService $ipDataService)
    {
        try {
            $result = json_encode($ipDataService->getAllIpData());
            $responseCode = 200;
        } catch (\Throwable $e) {
            $errorMessage = 'Internal error';
            $result = json_encode($errorMessage);
            $responseCode = 500;
        }
        return new Response($result, $responseCode);
    }

    /**
     * @Route("/api/ipdata/get/{ip}")
     * @Method("GET")
     *
     * @param $ip
     * @param IpDataService $ipDataService
     * @return Response
     */
    public function getIpDataByIp($ip, IpDataService $ipDataService)
    {
        try {
            $result = json_encode($ipDataService->getIpDataByIp($ip));
            $responseCode = self::HTTP_STATUS_CODE_SUCCESS;
        } catch (\Throwable $e) {
            $errorMessage = 'Invalid input syntax for type inet';
            $result = json_encode(['error' => $errorMessage]);
            $responseCode = self::HTTP_STATUS_SERVER_ERROR;
        }
        return new Response($result, $responseCode);
    }
}
