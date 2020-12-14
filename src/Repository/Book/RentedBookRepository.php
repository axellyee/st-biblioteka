<?php

namespace App\Repository\Book;

use App\Entity\Book\RentedBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentedBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentedBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentedBook[]    findAll()
 * @method RentedBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentedBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentedBook::class);
    }
}
