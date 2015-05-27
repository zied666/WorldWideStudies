<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{

    public function menuAction($route)
    {
        $em=$this->getDoctrine()->getManager();
        $languages=$em->getRepository("BackReferentielBundle:Language")->findBy(array(), array( 'name'=>'asc' ));
        $programs=$em->getRepository("BackReferentielBundle:Program")->findBy(array(), array( 'name'=>'asc' ));
        $sujectSchools=$em->getRepository("BackReferentielBundle:SubjectSchoolLocation")->findBy(array(), array( 'name'=>'asc' ));
        $subjects=$em->getRepository("BackReferentielBundle:Subject")->findBy(array(), array( 'name'=>'asc' ));
        $qualfications=$em->getRepository("BackReferentielBundle:Qualification")->findBy(array(), array( 'name'=>'asc' ));
        $studymodes=$em->getRepository("BackReferentielBundle:StudyMode")->findBy(array(), array( 'name'=>'asc' ));
        $levels=$em->getRepository("BackReferentielBundle:Level")->findBy(array(), array( 'name'=>'asc' ));
        $types=$em->getRepository("BackReferentielBundle:TypeAccommodation")->findBy(array(), array( 'name'=>'asc' ));
        return $this->render('FrontGeneralBundle:Front:menu.html.twig', array(
                    'route'         =>$route,
                    'languages'     =>$languages,
                    'programs'      =>$programs,
                    'sujectSchools' =>$sujectSchools,
                    'subjects'      =>$subjects,
                    'qualifications'=>$qualfications,
                    'studymodes'    =>$studymodes,
                    'levels'        =>$levels,
                    'types'         =>$types,
        ));
    }
    
    public function footerAction($route)
    {
        $em=$this->getDoctrine()->getManager();
        $homePage=$em->getRepository("BackGeneralBundle:HomePage")->find(1);
        $contact=$em->getRepository("BackGeneralBundle:Contact")->find(1);
        return $this->render('FrontGeneralBundle:Front:footer.html.twig', array(
                    'route'         =>$route,
                    'homepage'     =>$homePage,
                    'contact'      =>$contact,
        ));
    }

    public function logoAction()
    {
        $em=$this->getDoctrine()->getManager();
        $homePage=$em->getRepository("BackGeneralBundle:HomePage")->find(1);
        return $this->render('FrontGeneralBundle:Front:logo.html.twig', array(
                    'homepage'=>$homePage,
        ));
    }

}
