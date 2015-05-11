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

    public function redirectAction()
    {
        $request=$this->getRequest();
        if($request->get('language') != null)
            $language=$request->get('language');
        else
            $language='all';

        if($request->get('country') != null)
            $country=$request->get('country');
        else
            $country='all';

        if(!is_null($request->get('city')) && $request->get('city') != 0)
            $city=$request->get('city');
        else
            $city='all';

        if($request->get('stars') != null)
            $stars=$request->get('stars');
        else
            $stars='all';

        return $this->redirect($this->generateUrl('front_language_courses', array(
                            'page'    =>1,
                            'language'=>$language,
                            'country' =>$country,
                            'city'    =>$city,
                            'stars'   =>$stars,
                            'keyword' =>urlencode($request->get('keyword')),
        )));
    }

}
