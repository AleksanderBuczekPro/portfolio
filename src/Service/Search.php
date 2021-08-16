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

    public function getPrevious($project){

        $qb = $this->manager->createQueryBuilder();

        $qb->select('p')
            ->from('App\Entity\Project', 'p')
            ->where('p.date < :date')
            ->orderBy('p.date', 'DESC')
            ->setParameter('date', $project->getDate())
            ->setMaxResults(1);

        $query = $qb->getQuery();

        $previous = $query->execute();
        
        if(!$previous){
            return null;
        }
        return $previous[0];
        
    }

    public function getNext($project){

        $qb = $this->manager->createQueryBuilder();

        $qb->select('p')
            ->from('App\Entity\Project', 'p')
            ->where('p.date > :date')
            ->orderBy('p.date', 'ASC')
            ->setParameter('date', $project->getDate())
            ->setMaxResults(1);

        $query = $qb->getQuery();

        $next = $query->execute();

        if(!$next){
            return null;
        }
        return $next[0];
        
    }


}