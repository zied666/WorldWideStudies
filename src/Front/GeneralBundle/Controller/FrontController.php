<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{

    public function currencyAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if(!$session->has('currency'))
        {
            $ipDetails=$this->ip_details($_SERVER['SERVER_ADDR']);
            if(isset($ipDetails->country))
                $code=$ipDetails->country;
            else
                $code='TN';
            $country=$em->getRepository('BackReferentielBundle:Country')->findOneBy(array( 'code'=>$code ));
            if($country && !is_null($country->getCurrency()))
                $session->set('currency', array( 'code'=>$country->getCurrency()->getCode(), 'scale'=>$country->getCurrency()->getScale() ));
            else
                $session->set('currency', array( 'code'=>'USD', 'scale'=>2 ));
        }
        $currencies=$em->getRepository("BackReferentielBundle:Currency")->findAll();
        $sess=$session->get('currency');
        return $this->render('FrontGeneralBundle:Front:currency.html.twig', array(
                    'currencies'=>$currencies,
                    'currency'  =>$sess['code'],
        ));
    }

    function ip_details($ip)
    {
        $json=file_get_contents("http://ipinfo.io/{$ip}");
        return json_decode($json);
    }

    public function changeCurrencyAction($code)
    {
        $em=$this->getDoctrine()->getManager();
        $currency=$em->getRepository('BackReferentielBundle:Currency')->findOneBy(array( 'code'=>$code ));
        $session=$this->getRequest()->getSession();
        $session->set('currency', array( 'code'=>$code, 'scale'=>$currency->getScale() ));
        return $this->redirect($this->getRequest()->server->get('HTTP_REFERER'));
    }

    public function changeLocaleAction($locale)
    {
        $session=$this->getRequest()->getSession();
        $request=$this->getRequest();
        $route=str_ireplace('/'.$request->getLocale().'/', '/'.$locale.'/', $this->getRequest()->server->get('HTTP_REFERER'));
        return $this->redirect($route);
    }

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
                    'route'   =>$route,
                    'homepage'=>$homePage,
                    'contact' =>$contact,
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
