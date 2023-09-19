<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface
)
    {
        parent::__construct($registry, Article::class);
    }

    public function findPublished(int $page, ?Category $category = null): PaginationInterface {
        $data = $this->createQueryBuilder('a')
            ->where('a.state LIKE :state')
            ->setParameter('state', '%publier%')
            ->addOrderBy('a.createdAt', 'DESC');

        if (isset($category)) {
            $data = $data
                ->join('a.categories', 'c')
                ->andWhere(':category IN (c)')
                ->setParameter('category', $category);
        }
        $data->getQuery()
            ->getResult();

        $posts = $this->paginatorInterface->paginate($data, $page, 6);

        return $posts;
    }


    public function findPublishedLasted($limit)
    {
        return $this->createQueryBuilder('p')
                ->where('p.state LIKE :state')
                ->setParameter('state', '%publier%')
                ->orderBy('p.createdAt', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

    }

    public function findBySearch(SearchData $searchData) : PaginationInterface
    {
        $data = $this->createQueryBuilder('a')
            ->where('a.state LIKE :state')
            ->setParameter('state', '%publier%')
            ->addOrderBy('a.createdAt', 'DESC');
        
            if(!empty($searchData->q)) {
                $data = $data
                    ->andWhere('a.title LIKE :q')
                    ->orWhere('a.content LIKE :q')
                    ->setParameter('q', "%{$searchData->q}%");
                

            }
            if(!empty($searchData->categories)) {
                $data = $data
                    ->join('a.categories', 'c')
                    ->andWhere('c.id IN (:categories)')
                    ->setParameter('categories', $searchData->categories);
                

            }
        
            $data = $data
                ->getQuery()
                ->getResult();

            $articles = $this->paginatorInterface->paginate($data, $searchData->page, 6);
            return $articles;
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
