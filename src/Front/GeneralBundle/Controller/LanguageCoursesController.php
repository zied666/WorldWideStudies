<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\SchoolLocationRepository;

class LanguageCoursesController extends Controller
{

    public function listAction($page, $language, $country, $city, $stars, $keyword, $sort, $desc)
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->getLanguageSchool($language, $country, $city, $stars, $keyword, $sort, $desc);
        $paginator=$this->get('knp_paginator');
        $schools=$paginator->paginate($query, $page, 20);
        return $this->render('FrontGeneralBundle:LanguageCourses:list.html.twig', array(
                    'schools'=>$schools,
                    'count'=>count($query)
        ));
    }

}
