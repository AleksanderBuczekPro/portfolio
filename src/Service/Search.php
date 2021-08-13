<?php

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Search{

    private $manager;

    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;

    }

    public function getFrontProjects(){

        $qb = $this->manager->createQueryBuilder();

        $qb->select('p')
            ->from('App\Entity\Project', 'p')
            ->where('p.front = :front')
            ->orderBy('p.updatedAt', 'DESC')
            ->setParameter('front', 1)
            ->setMaxResults(3);

        $query = $qb->getQuery();

        return $query->execute();
        
    }


}