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
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;

/**
 * Class PostRepository
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @package App\Repository
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class PostRepository extends ServiceEntityRepository
{

    private PaginatorInterface $paginator;

    private LoggerInterface $logger;

    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     * @param PaginatorInterface $pagination
     * @param LoggerInterface $logger
     */
    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $pagination,
        LoggerInterface $logger
    )
    {
        parent::__construct($registry, Post::class);
        $this->paginator = $pagination;
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
            $searchData->page ?? 1,
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
     * @return mixed
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function findForSidebar()
    {
        try {
            return $this->createQueryBuilder('p')
                ->where('p.created_at <= :now')
                ->andWhere('p.is_archived = 0')
                ->orderBy('p.created_at', 'DESC')
                ->setMaxResults(4)
                ->setParameter('now', new \DateTime('now'))
                ->getQuery()
                ->getResult();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return null;
        }
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
                ->andWhere('p.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }
        return $query;
    }

    /**
     * @return QueryBuilder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function joinTablesQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'c', 't')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.tags', 't')
            ->where('p.is_archived = 0')
            ->orderBy('p.created_at', 'DESC');
    }
}
