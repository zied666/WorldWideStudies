<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CourseTitleRepository extends EntityRepository
{

    public function getCourses($level, $qualification, $subject, $studymode, $country, $city, $sort, $desc, $keyword)
    {
        $query=$this->createQueryBuilder('c');
        $query->join("c.university", "u");
        $query->where('u.enabled=:enabled')->setParameter('enabled', TRUE);
        if($level != 'all')
            $query->andWhere('c.level=:level')->setParameter('level', $level);
        if($qualification != 'all')
            $query->andWhere('c.qualification=:qualification')->setParameter('qualification', $qualification);
        if($studymode != 'all')
            $query->andWhere('c.studyMode=:studymode')->setParameter('studymode', $studymode);
        if($subject != 'all')
            $query->andWhere('c.subject=:subject')->setParameter('subject', $subject);
        if($city != 'all')
            $query->andWhere('u.city=:city')->setParameter('city', $city);
        if($country != 'all')
        {
            $query->join("u.city", "ci");
            $query->andWhere('ci.country=:country')->setParameter('country', $country);
        }
        if($keyword != '' && !is_null($keyword))
        {
            $query->andWhere(
                    $query->expr()->orX(
                            $query->expr()->like("c.name", ":keyword"), $query->expr()->like("u.name", ":keyword"), $query->expr()->like("c.description", ":keyword")
                    )
            )->setParameter('keyword', '%'.$keyword.'%');
        }
        $query->orderBy("c.".$sort, $desc);
        return $query->getQuery()->getResult();
    }

}
