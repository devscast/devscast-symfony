<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\Entity\Post;
use App\Data\SearchData;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{

    /** @var PaginationInterface */
    private $paginator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     * @param PaginatorInterface $pagination
     * @param LoggerInterface $logger
     */
    public function __construct(
        ManagerRegistry $registry,
        PaginatorInterface $pagination,
        LoggerInterface $logger)
    {
        parent::__construct($registry, Post::class);
        $this->paginator = $pagination;
        $this->logger = $logger;
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
                ->setMaxResults(3)
                ->setParameter('now', new \DateTime('now'))
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), $e->getTrace());
            return null;
        }
    }

    /**
     * @param SearchData $searchData
     * @return PaginationInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function findSearch(SearchData $searchData)
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
     * @param SearchData $searchData
     * @return QueryBuilder
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function applyFilters(QueryBuilder $query, SearchData $searchData)
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
