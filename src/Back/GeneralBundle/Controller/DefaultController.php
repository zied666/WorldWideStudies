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
        $admins=$this->findByRole("ROLE_ADMIN");
        return $this->render('BackGeneralBundle::dashboard.html.twig', array(
                    'countSchoolLocations'=>count($SchoolsLocations),
                    'countAccommodations'=>count($Accommodations),
                    'countUniversitys'=>count($Universitys),
                    'countAdmins'=>count($admins),
        ));
    }

    public function findByRole($role)
    {
        $qb=$this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('u')
                ->from('BackUserBundle:User', 'u')
                ->where('u.roles LIKE :roles')
                ->setParameter('roles', '%"'.$role.'"%');
        return $qb->getQuery()->getResult();
    }

}
