<?php


namespace App\Controller;

use Doctrine\DBAL\Connection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Dashboard
 * @Route("/api")
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Dashboard extends Controller
{
    /**
     * @Route(path="/stats")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Connection $connection
     * @return JsonResponse
     * @throws \Doctrine\DBAL\DBALException
     */
    public function index(Connection $connection)
    {
        $data = [];
        $data['streams'] = $connection->fetchColumn('SELECT COUNT(*) FROM streams');
        $data['liveStreams'] = $connection->fetchColumn('SELECT COUNT(*) FROM streams WHERE live = 1');
        $data['users'] = $connection->fetchColumn('SELECT COUNT(*) FROM `user`');
        $data['endpoints'] = $connection->fetchColumn('SELECT COUNT(*) FROM endpoint');

        return new JsonResponse($data);
    }
}