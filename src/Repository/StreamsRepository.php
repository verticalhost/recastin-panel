<?php

namespace App\Repository;

use App\Entity\Streams;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Streams|null find($id, $lockMode = null, $lockVersion = null)
 * @method Streams|null findOneBy(array $criteria, array $orderBy = null)
 * @method Streams[]    findAll()
 * @method Streams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Streams::class);
    }

    /**
     * @param User $user
     * @author Soner Sayakci <shyim@posteo.de>
     * @return array
     */
    public function getStreams(User $user) : array
    {
        $qb = $this->createQueryBuilder('streams')
            ->addSelect('endpoints')
            ->where('streams.userId = :userId')
            ->leftJoin('streams.endpoints', 'endpoints')
            ->setParameter('userId', $user->getId())
            ->getQuery();

        return $qb->getResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @return Streams[]
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function getActiveStreams(): array
    {
        $qb = $this->createQueryBuilder('streams')
            ->addSelect('endpoints')
            ->addSelect('user')
            ->leftJoin('streams.endpoints', 'endpoints')
            ->leftJoin('streams.user', 'user')
            ->andWhere('streams.active = true')
            ->andWhere('endpoints.active = true')
            ->getQuery();

        return $qb->getResult();
    }
}
