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

use App\Entity\Blog;
use App\Data\SearchData;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{

    /** @var ManagerRegistry */
    private $registry;

    /** @var PaginatorInterface */
    private $paginator;

    /**
     * BlogRepository constructor.
     * @param ManagerRegistry $registry
     * @param PaginatorInterface $paginator
     */
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Blog::class);
        $this->registry = $registry;
        $this->paginator = $paginator;
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
            ->where('b.is_archived = 0');
    }
}
