<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class UniversityController extends Controller
{

    public function listAction($page, $level, $qualification, $subject, $studymode, $country, $city, $sort, $desc, $keyword)
    {
        $em=$this->getDoctrine()->getManager();
        $levels=$em->getRepository("BackReferentielBundle:Level")->findBy(array(), array( "name"=>"asc" ));
        $qualifications=$em->getRepository("BackReferentielBundle:Qualification")->findBy(array(), array( "name"=>"asc" ));
        $subjects=$em->getRepository("BackReferentielBundle:Subject")->findBy(array(), array( "name"=>"asc" ));
        $studymodes=$em->getRepository("BackReferentielBundle:StudyMode")->findBy(array(), array( "name"=>"asc" ));
        $countries=$em->getRepository("BackReferentielBundle:Country")->findBy(array(), array( "libelle"=>"asc" ));
        $cities=$em->getRepository("BackReferentielBundle:City")->findBy(array( 'country'=>$em->getRepository("BackReferentielBundle:Country")->find($country) ), array( "libelle"=>"asc" ));
        $query=$em->getRepository("BackUniversityBundle:CourseTitle")->getCourses($level, $qualification, $subject, $studymode, $country, $city, $sort, $desc, $keyword);
        $paginator=$this->get('knp_paginator');
        $courses=$paginator->paginate($query, $page, 20);
        return $this->render('FrontGeneralBundle:Universities:list.html.twig', array(
                    'courses'       =>$courses,
                    'count'         =>count($query),
                    'level'         =>$level,
                    'qualification' =>$qualification,
                    'subject'       =>$subject,
                    'country'       =>$country,
                    'studymode'     =>$studymode,
                    'city'          =>$city,
                    'keyword'       =>$keyword,
                    'sort'          =>$sort,
                    'desc'          =>$desc,
                    'levels'        =>$levels,
                    'qualifications'=>$qualifications,
                    'subjects'      =>$subjects,
                    'studymodes'    =>$studymodes,
                    'countries'     =>$countries,
                    'cities'        =>$cities,
        ));
    }

    public function filtreAction($page, $level, $qualification, $subject, $studymode, $country, $city, $sort, $desc, $keyword)
    {
        $request=$this->getRequest();
        $level=$this->testValue($request->get('levelSearch'));
        $qualification=$this->testValue($request->get('qualificationSearch'));
        $subject=$this->testValue($request->get('subjectSearch'));
        $studymode=$this->testValue($request->get('studymodeSearch'));
        $country=$this->testValue($request->get('countrySearch'));
        $city=$this->testValue($request->get('citySearch'));
        return $this->redirect($this->generateUrl('front_university', array(
                            'page'          =>1,
                            'level'        =>$level,
                            'qualification'=>$qualification,
                            'subject'       =>$subject,
                            'studymode'     =>$studymode,
                            'country'       =>$country,
                            'city'          =>$city,
                            'keyword'       =>urlencode($request->get('keywordSearch')),
                            'sort'    =>$sort,
                            'desc'    =>$desc,
        )));
    }

    public function testValue($obj)
    {
        if(is_null($obj) || $obj == 0)
            return 'all';
        else
            return $obj;
    }

}
