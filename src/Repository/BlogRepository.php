<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Repository;

use App\Data\SearchRequestData;
use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BlogRepository
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @package App\Repository
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class BlogRepository extends ServiceEntityRepository
{

    private PaginatorInterface $paginator;
    private LoggerInterface $logger;

    /**
     * BlogRepository constructor.
     * @param LoggerInterface $logger
     * @param ManagerRegistry $registry
     * @param PaginatorInterface $paginator
     */
    public function __construct(
        LoggerInterface $logger,
        ManagerRegistry $registry,
        PaginatorInterface $paginator
    ) {
        parent::__construct($registry, Blog::class);
        $this->paginator = $paginator;
        $this->logger = $logger;
    }

    /**
     * @param SearchRequestData $searchData
     * @return PaginationInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function findSearch(SearchRequestData $searchData)
    {
        $query = $this->joinTablesQuery();
        $query = $this->applyFilters($query, $searchData);
        $query = $query->getQuery()->getResult();
        return $this->paginator->paginate(
            $query,
            $searchData->page,
            12
        );
    }

    /**
     * @param int $page
     * @return PaginationInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function findPaginated(int $page)
    {
        return $this->paginator->paginate(
            $this->joinTablesQuery()->getQuery()->getResult(),
            $page,
            12
        );
    }

    /**
     * @param QueryBuilder $query
     * @param SearchRequestData $searchData
     * @return QueryBuilder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function applyFilters(QueryBuilder $query, SearchRequestData $searchData)
    {
        if (!empty($searchData->q)) {
            $query = $query
                ->andWhere('b.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }
        return $query;
    }

    /**
     * @return QueryBuilder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function joinTablesQuery()
    {
        return $this->createQueryBuilder('b')
            ->select('b', 'c', 't')
            ->leftJoin('b.category', 'c')
            ->leftJoin('b.tags', 't')
            ->where('b.is_archived = 0')
            ->orderBy('b.created_at', 'DESC');
    }

    /**
     * @return mixed
     * @author scotttresor <scotttresor@gmail.com>
     */
    public function findForSidebar()
    {
        try {
            return $this->createQueryBuilder('b')
                ->where('b.created_at <= :now')
                ->andWhere('b.is_archived = 0')
                ->orderBy('b.created_at', 'DESC')
                ->setMaxResults(3)
                ->setParameter('now', new \DateTime('now'))
                ->getQuery()
                ->getResult();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return null;
        }
    }
}
