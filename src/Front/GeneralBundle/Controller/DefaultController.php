<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $em=$this->getDoctrine()->getManager();
        $languages=$em->getRepository("BackReferentielBundle:Language")->findBy(array(), array( "name"=>"asc" ));
        $countries=$em->getRepository("BackReferentielBundle:Country")->findBy(array(), array( "libelle"=>"asc" ));
        $programs=$em->getRepository("BackReferentielBundle:Program")->findBy(array(), array( "name"=>"asc" ));
        $levels=$em->getRepository("BackReferentielBundle:Level")->findBy(array(), array( "name"=>"asc" ));
        $studyModes=$em->getRepository("BackReferentielBundle:StudyMode")->findBy(array(), array( "name"=>"asc" ));
        $subjects=$em->getRepository("BackReferentielBundle:Subject")->findBy(array(), array( "name"=>"asc" ));
        $subjectsSchool=$em->getRepository("BackReferentielBundle:SubjectSchoolLocation")->findBy(array(), array( "name"=>"asc" ));
        $typeAccommodations=$em->getRepository("BackReferentielBundle:TypeAccommodation")->findBy(array(), array( "name"=>"asc" ));
        $qualifications=$em->getRepository("BackReferentielBundle:Qualification")->findBy(array(), array( "name"=>"asc" ));
        return $this->render('FrontGeneralBundle::accueil.html.twig', array(
                    'languages'         =>$languages,
                    'countries'         =>$countries,
                    'programs'          =>$programs,
                    'levels'            =>$levels,
                    'studyModes'        =>$studyModes,
                    'subjects'          =>$subjects,
                    'subjectsSchool'    =>$subjectsSchool,
                    'typeAccommodations'=>$typeAccommodations,
                    'qualifications'    =>$qualifications,
        ));
    }
    
    public function contactAction()
    {
        return $this->render('FrontGeneralBundle::contact.html.twig');
    }

    public function ajaxAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $id=$request->get("id");
        $country=$em->getRepository("BackReferentielBundle:Country")->find($id);
        $response=new JsonResponse();
        $cities=$em->getRepository("BackReferentielBundle:City")->findBy(
                array( 'country'=>$country ), array( 'libelle'=>'asc' )
        );
        $tab=array();
        $tab[]='All Cities in '.$country->getLibelle();
        foreach($cities as $city)
            $tab[$city->getId()]=$city->getLibelle();
        $response->setData($tab);
        return $response;
    }

    public function redirectLanguageAction()
    {
        $request=$this->getRequest();
        $language=$this->testValue($request->get('language'));
        $country=$this->testValue($request->get('country'));
        $city=$this->testValue($request->get('city'));
        $stars=$this->testValue($request->get('stars'));
        return $this->redirect($this->generateUrl('front_language_courses', array(
                            'page'    =>1,
                            'language'=>$language,
                            'country' =>$country,
                            'city'    =>$city,
                            'stars'   =>$stars,
                            'keyword' =>urlencode($request->get('keyword')),
        )));
    }

    public function redirectProgramAction()
    {
        $request=$this->getRequest();
        $program=$this->testValue($request->get('program'));
        $langauge=$this->testValue($request->get('langauge'));
        $subject=$this->testValue($request->get('subject'));
        $country=$this->testValue($request->get('country'));
        $city=$this->testValue($request->get('city'));
        $stars=$this->testValue($request->get('stars'));
        $language=$this->testValue($request->get('language'));
        return $this->redirect($this->generateUrl('front_program_courses', array(
                            'page'    =>1,
                            'language'=>$language,
                            'program' =>$program,
                            'subject' =>$subject,
                            'country' =>$country,
                            'city'    =>$city,
                            'stars'   =>$stars,
                            'keyword' =>urlencode($request->get('keyword')),
        )));
    }

    public function redirectUniversityAction()
    {
        $request=$this->getRequest();

        $level=$this->testValue($request->get('level'));
        $qualification=$this->testValue($request->get('qualification'));
        $subject=$this->testValue($request->get('subject'));
        $studymode=$this->testValue($request->get('studymode'));
        $country=$this->testValue($request->get('country'));
        $city=$this->testValue($request->get('city'));
        return $this->redirect($this->generateUrl('front_university', array(
                            'page'         =>1,
                            'level'        =>$level,
                            'qualification'=>$qualification,
                            'subject'      =>$subject,
                            'studymode'    =>$studymode,
                            'country'      =>$country,
                            'city'         =>$city,
                            'keyword'      =>urlencode($request->get('keyword')),
        )));
    }

    public function testValue($obj)
    {
        if(is_null($obj) || $obj == 0)
            return 'all';
        else
            return $obj;
    }

    public function redirectAccommodationAction()
    {
        $request=$this->getRequest();
        $type=$this->testValue($request->get('type'));
        $country=$this->testValue($request->get('country'));
        $city=$this->testValue($request->get('city'));
        return $this->redirect($this->generateUrl('front_accommodations', array(
                            'page'   =>1,
                            'type'   =>$type,
                            'country'=>$country,
                            'city'   =>$city,
                            'keyword'=>urlencode($request->get('keyword')),
        )));
    }

}
