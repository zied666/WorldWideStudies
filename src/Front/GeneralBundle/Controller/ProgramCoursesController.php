<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Entity\SchoolLocationRepository;
use Back\SchoolBundle\Entity\Course;
use Front\GeneralBundle\Form\ReviewType;
use Front\GeneralBundle\Entity\Review;

class ProgramCoursesController extends Controller
{

    public function listAction($page, $program, $language, $subject, $country, $city, $stars, $keyword, $sort, $desc)
    {
        $em=$this->getDoctrine()->getManager();
        $languages=$em->getRepository("BackReferentielBundle:Language")->findBy(array(), array( "name"=>"asc" ));
        $programs=$em->getRepository("BackReferentielBundle:Program")->findBy(array(), array( "name"=>"asc" ));
        $subjects=$em->getRepository("BackReferentielBundle:SubjectSchoolLocation")->findBy(array(), array( "name"=>"asc" ));
        $countries=$em->getRepository("BackReferentielBundle:Country")->findBy(array(), array( "libelle"=>"asc" ));
        $cities=$em->getRepository("BackReferentielBundle:City")->findBy(array( 'country'=>$em->getRepository("BackReferentielBundle:Country")->find($country) ), array( "libelle"=>"asc" ));
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->getProgramSchool($program, $language, $subject, $country, $city, $stars, $keyword, $sort, $desc);
        $paginator=$this->get('knp_paginator');
        $schools=$paginator->paginate($query, $page, 10);
        return $this->render('FrontGeneralBundle:ProgramCourses:list.html.twig', array(
                    'schools'  =>$schools,
                    'count'    =>count($query),
                    'program'  =>$program,
                    'language' =>$language,
                    'subject'  =>$subject,
                    'country'  =>$country,
                    'city'     =>$city,
                    'stars'    =>$stars,
                    'keyword'  =>$keyword,
                    'sort'     =>$sort,
                    'desc'     =>$desc,
                    'programs' =>$programs,
                    'languages'=>$languages,
                    'subjects' =>$subjects,
                    'countries'=>$countries,
                    'cities'   =>$cities,
        ));
    }

    public function filtreAction($page, $program, $language, $subject, $country, $city, $stars, $keyword, $sort, $desc)
    {
        $request=$this->getRequest();
        if($request->get('programSearch') != null)
            $program=$request->get('programSearch');
        else
            $program='all';
        if($request->get('languageSearch') != null)
            $language=$request->get('languageSearch');
        else
            $language='all';
        if($request->get('subjectSearch') != null)
            $subject=$request->get('subjectSearch');
        else
            $subject='all';
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
        return $this->redirect($this->generateUrl('front_program_courses', array(
                            'page'    =>1,
                            'language'=>$language,
                            'program' =>$program,
                            'subject' =>$subject,
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
        $schools=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array( 'city'=>$school->getCity(), 'type'=>2, 'enabled'=>1 ), array(), 5);
        $review=new Review();
        $reviews=$em->getRepository('FrontGeneralBundle:Review')->findBy(array( 'schoolLocation'=>$schools, 'validated'=>TRUE ), array( 'id'=>'desc' ));
        $form=$this->createForm(new ReviewType(), $review);
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        if($request->isMethod('POST'))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $review=$form->getData();
                $em->persist($review->setValidated(false)->setReviewDate(new \DateTime())->setSchoolLocation($school));
                $em->flush();
                $session->getFlashBag()->add('alert-success', "Your review has been added successfully");
                return $this->redirect($this->generateUrl('front_program_courses_details', array( 'id'=>$school->getId() )));
            }
        }
        return $this->render('FrontGeneralBundle:ProgramCourses:school.html.twig', array(
                    'schools'=>$schools,
                    'school' =>$school,
                    'reviews'=>$reviews,
                    'form'   =>$form->createView(),
        ));
    }

    public function courseAction(Course $course)
    {
        $em=$this->getDoctrine()->getManager();
        return $this->render('FrontGeneralBundle:ProgramCourses:course.html.twig', array(
                    'course'=>$course,
                    'school'=>$course->getSchoolLocation(),
        ));
    }

}
