<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AccommodationRepository extends EntityRepository
{

    public function getAccommodations($type, $country, $city, $sort, $desc, $keyword)
    {
        $query=$this->createQueryBuilder('a');
        $query->where('a.enabled=:enabled')->setParameter('enabled', TRUE);
        if($type != 'all')
            $query->andWhere('a.typeAccommodation=:type')->setParameter('type', $type);
        if($city != 'all')
            $query->andWhere('a.city=:city')->setParameter('city', $city);
        if($country != 'all')
        {
            $query->join("a.city", "ci");
            $query->andWhere('ci.country=:country')->setParameter('country', $country);
        }
        if($keyword != '' && !is_null($keyword))
        {
            $query->andWhere(
                    $query->expr()->orX(
                            $query->expr()->like("a.name", ":keyword"), $query->expr()->like("a.shortDescription", ":keyword"), $query->expr()->like("a.longDescription", ":keyword")
                    )
            )->setParameter('keyword', '%'.$keyword.'%');
        }
        $query->orderBy("a.".$sort, $desc);
        return $query->getQuery()->getResult();
    }

}
