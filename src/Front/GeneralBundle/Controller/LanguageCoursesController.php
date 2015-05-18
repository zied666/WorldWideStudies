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
        $languages=$em->getRepository("BackReferentielBundle:Language")->findBy(array(), array( "name"=>"asc" ));
        $countries=$em->getRepository("BackReferentielBundle:Country")->findBy(array(), array( "libelle"=>"asc" ));
        $cities=$em->getRepository("BackReferentielBundle:City")->findBy(array( 'country'=>$em->getRepository("BackReferentielBundle:Country")->find($country) ), array( "libelle"=>"asc" ));
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->getLanguageSchool($language, $country, $city, $stars, $keyword, $sort, $desc);
        $paginator=$this->get('knp_paginator');
        $schools=$paginator->paginate($query, $page, 20);
        return $this->render('FrontGeneralBundle:LanguageCourses:list.html.twig', array(
                    'schools'  =>$schools,
                    'count'    =>count($query),
                    'language' =>$language,
                    'country'  =>$country,
                    'city'     =>$city,
                    'stars'    =>$stars,
                    'keyword'  =>$keyword,
                    'sort'     =>$sort,
                    'desc'     =>$desc,
                    'languages'=>$languages,
                    'countries'=>$countries,
                    'cities'   =>$cities,
        ));
    }

    public function filtreAction($page, $language, $country, $city, $stars, $keyword, $sort, $desc)
    {
        $request=$this->getRequest();
        if($request->get('languageSearch') != null)
            $language=$request->get('languageSearch');
        else
            $language='all';
        if($request->get('countrySearch') != null)
            $country=$request->get('countrySearch');
        else
            $country='all';
        if(!is_null($request->get('citySearch')) && $request->get('citySearch') != 0)
            $city=$request->get('citySearch');
        else
            $city='all';

        if($request->get('starsSearch') != null)
            $stars=$request->get('starsSearch');
        else
            $stars='all';
        return $this->redirect($this->generateUrl('front_language_courses', array(
                            'page'    =>1,
                            'language'=>$language,
                            'country' =>$country,
                            'city'    =>$city,
                            'stars'   =>$stars,
                            'keyword' =>urlencode($request->get('keywordSearch')),
                            'sort'    =>$sort,
                            'desc'    =>$desc,
        )));
    }

    public function schoolAction(SchoolLocation $school)
    {
        $em=$this->getDoctrine()->getManager();
        $schools=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array('city'=>$school->getCity(),'type'=>1,'enabled'=>1), array(), 5);
        return $this->render('FrontGeneralBundle:LanguageCourses:school.html.twig', array(
                    'schools'  =>$schools,
                    'school'  =>$school,
        ));
    }
}
