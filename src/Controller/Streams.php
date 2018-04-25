<?php


namespace App\Controller;

use App\Component\Forms\Endpoint as EndpointForm;
use App\Component\Forms\Streams as StreamsForm;
use App\Component\ServiceManager;
use App\Entity\Endpoint;
use App\Entity\User;
use App\Repository\EndpointRepository;
use App\Repository\StreamsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Streams
 * @Route("/api/streams")
 * @author Soner Sayakci <shyim@posteo.de>
 */
class Streams extends Controller
{
    /**
     * @var StreamsRepository
     */
    private $repository;

    /**
     * @var EndpointRepository
     */
    private $endpointRepository;

    /**
     * Streams constructor.
     * @param StreamsRepository $repository
     * @param EndpointRepository $endpointRepository
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(StreamsRepository $repository, EndpointRepository $endpointRepository)
    {
        $this->repository = $repository;
        $this->endpointRepository = $endpointRepository;
    }

    /**
     * @Route(path="/list")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function streams() : Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse($this->repository->getStreams($user));
    }

    /**
     * @Route(path="/one")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function one(Request $request) : Response
    {
        $stream = $this->repository->find($request->query->get('id'));

        if ($stream === null || $stream->getUserId() !== $this->getUser()->getId()) {
            return new Response('Access denied', 401);
        }

        $host = parse_url($this->container->getParameter('appHost'), PHP_URL_HOST);
        $data = $stream->jsonSerialize();
        $data['streamUrl'] = sprintf('rtmp://%s/%s', $host, $stream->getUser()->getUsername() . '_' . $stream->getName());

        return new JsonResponse($data);
    }

    /**
     * @Route(path="/update")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function update(Request $request) : Response
    {
        $requestBody = $request->request->all();

        $stream = !empty($requestBody['id']) ? $this->repository->find($requestBody['id']) : new \App\Entity\Streams();

        if ($stream->getUserId() && $stream->getUserId() !== $this->getUser()->getId()) {
            return new Response('Access denied', 401);
        }

        $stream->setUser($this->getUser());
        $stream->setName($requestBody['name']);
        $stream->setActive($requestBody['active']);

        $manager = $this->get('doctrine.orm.entity_manager');

        $manager->persist($stream);
        $manager->flush();

        return new JsonResponse($stream);
    }

    /**
     * @Route(path="/regenerate")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function regenerate(Request $request) : Response
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $streams = $manager->find(\App\Entity\Streams::class, $request->request->get('id'));

        if ($streams && $streams->getUserId() === $this->getUser()->getId()) {
            $streams->setStreamKey(uniqid('', true));
            $manager->persist($streams);
            $manager->flush();
        }

        return new JsonResponse();
    }

    /**
     * @Route(path="/delete")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function delete(Request $request) : Response
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $streams = $manager->find(\App\Entity\Streams::class, $request->request->get('id'));

        if ($streams && $streams->getUserId() === $this->getUser()->getId()) {
            $manager->remove($streams);
            $manager->flush();
        }

        return new JsonResponse();
    }

    /**
     * @Route(path="/services")
     * @param ServiceManager $manager
     * @return JsonResponse
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function services(ServiceManager $manager): JsonResponse
    {
        return new JsonResponse($manager->getTemplateData());
    }

    /**
     * @Route(path="/{id}/endpoints/")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param int $id
     * @return JsonResponse
     */
    public function listEndpoints(int $id): JsonResponse
    {
        return new JsonResponse($this->endpointRepository->getEndpoints($this->getUser(), $id));
    }

    /**
     * @Route(path="/endpoint/{id}")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param int $id
     * @return JsonResponse
     */
    public function endpoint(int $id)
    {
        return new JsonResponse($this->endpointRepository->find($id));
    }

    /**
     * @Route(path="/{id}/endpoints/update")
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function updateEndpoint(Request $request, int $id): Response
    {
        $requestBody = $request->request->all();

        $stream = $this->repository->find($id);

        if ($stream === null || $stream->getUserId() !== $this->getUser()->getId()) {
            return new JsonResponse([]);
        }

        $endpoint = !empty($requestBody['id']) ? $this->endpointRepository->find($requestBody['id']) : new Endpoint();

        $endpoint->setName($requestBody['name']);
        $endpoint->setType($requestBody['type']);
        $endpoint->setServer($requestBody['server']);
        $endpoint->setStreamKey($requestBody['streamKey']);
        $endpoint->setStream($stream);

        $manager = $this->get('doctrine.orm.entity_manager');

        $manager->persist($endpoint);
        $manager->flush();

        return new JsonResponse($endpoint);
    }

    /**
     * @Route(path="/deleteEndpoint")
     * @author Soner Sayakci <shyim@posteo.de>
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function deleteEndpoint(Request $request) : Response
    {
        $manager = $this->get('doctrine.orm.entity_manager');
        $endpoint = $manager->find(Endpoint::class, $request->request->get('id'));

        if ($endpoint && $endpoint->getStream()->getUserId() === $this->getUser()->getId()) {
            $manager->remove($endpoint);
            $manager->flush();
        }

        return new JsonResponse();
    }
}