<?php

namespace Back\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $SchoolsLocations=$em->getRepository("BackSchoolBundle:SchoolLocation")->findAll();
        $Accommodations=$em->getRepository("BackAccommodationBundle:Accommodation")->findAll();
        $Universitys=$em->getRepository("BackUniversityBundle:University")->findAll();
        $admins=$this->findByRoleAdmin();
        return $this->render('BackGeneralBundle::dashboard.html.twig', array(
                    'countSchoolLocations'=>count($SchoolsLocations),
                    'countAccommodations'=>count($Accommodations),
                    'countUniversitys'=>count($Universitys),
                    'countAdmins'=>count($admins),
        ));
    }

    public function findByRoleAdmin()
    {
        $qb=$this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('u')
                ->from('BackUserBundle:User', 'u')
                ->where('u.roles LIKE :role')
                ->orWhere('u.roles LIKE :role1')
                ->orWhere('u.roles LIKE :role2')
                ->orWhere('u.roles LIKE :role3')
                ->orWhere('u.roles LIKE :role4')
                ->orWhere('u.roles LIKE :role5')
                ->setParameter('role', '%ROLE_ADMIN%')
                ->setParameter('role1', '%ROLE_SUPER_ADMIN%')
                ->setParameter('role2', '%ROLE_ADMIN_UNIVERSITY%')
                ->setParameter('role3', '%ROLE_ADMIN_ACCOMMODATION%')
                ->setParameter('role4', '%ROLE_ADMIN_SCHOOL%')
                ->setParameter('role5', '%ROLE_ADMIN_CONFIG%');
        return $qb->getQuery()->getResult();
    }

}
