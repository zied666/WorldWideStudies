<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SchoolLocationRepository extends EntityRepository
{

    public function getLanguageSchool($language, $country, $city, $stars, $keyword, $sort, $desc)
    {
        $query=$this->createQueryBuilder('s');
        $query->where('s.type=:type')->setParameter('type', 1);
        if($language != 'all')
        {
            $query->join("s.courses", "c");
            $query->andWhere('c.language=:language')->setParameter('language', $language);
        }
        if($city != 'all')
            $query->andWhere('s.city=:city')->setParameter('city', $city);
        if($country != 'all')
        {
            $query->join("s.city", "ci");
            $query->andWhere('ci.country=:country')->setParameter('country', $country);
        }
        if($stars != 'all')
            $query->andWhere('s.stars=:stars')->setParameter('stars', $stars);
        if($keyword != ''  && !is_null($keyword))
        {
            $query->andWhere(
                    $query->expr()->orX(
                            $query->expr()->like("s.name", ":keyword"),
                            $query->expr()->like("s.shortDescription", ":keyword"),
                            $query->expr()->like("s.longDescription", ":keyword")
                    )
            )->setParameter('keyword', '%'.$keyword.'%');
        }
        $query->orderBy("s." . $sort, $desc);
        return $query->getQuery()->getResult();
    }

}
