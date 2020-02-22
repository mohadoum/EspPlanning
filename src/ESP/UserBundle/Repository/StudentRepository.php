<?php

namespace ESP\UserBundle\Repository;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getStudentRelatedToThisToken($confirmationToken)
    {
        $qb = $this->createQueryBuilder('stu');
        $qb->where('stu.confirmationToken LIKE :token');
        $qb->setParameter('token', $confirmationToken);

        return $qb->getQuery()->getOneOrNullResult();
    }
}