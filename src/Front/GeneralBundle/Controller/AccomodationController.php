<?php

namespace Front\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Back\AccommodationBundle\Entity\Accommodation;
class AccomodationController extends Controller
{

    public function listAction($page, $type, $country, $city, $sort, $desc, $keyword)
    {
        $em=$this->getDoctrine()->getManager();
        $types=$em->getRepository("BackReferentielBundle:TypeAccommodation")->findBy(array(), array( "name"=>"asc" ));
        $countries=$em->getRepository("BackReferentielBundle:Country")->findBy(array(), array( "libelle"=>"asc" ));
        $cities=$em->getRepository("BackReferentielBundle:City")->findBy(array( 'country'=>$em->getRepository("BackReferentielBundle:Country")->find($country) ), array( "libelle"=>"asc" ));
        $query=$em->getRepository("BackAccommodationBundle:Accommodation")->getAccommodations($type, $country, $city, $sort, $desc, $keyword);
        $paginator=$this->get('knp_paginator');
        $accommodations=$paginator->paginate($query, $page, 10);
        return $this->render('FrontGeneralBundle:Accommodations:list.html.twig', array(
                    'accommodations'=>$accommodations,
                    'count'         =>count($query),
                    'type'          =>$type,
                    'country'       =>$country,
                    'city'          =>$city,
                    'keyword'       =>$keyword,
                    'sort'          =>$sort,
                    'desc'          =>$desc,
                    'types'         =>$types,
                    'countries'     =>$countries,
                    'cities'        =>$cities,
        ));
    }

    public function filtreAction($page, $type, $country, $city, $sort, $desc, $keyword)
    {
        $request=$this->getRequest();
        $type=$this->testValue($request->get('typeSearch'));
        $country=$this->testValue($request->get('countrySearch'));
        $city=$this->testValue($request->get('citySearch'));
        return $this->redirect($this->generateUrl('front_accommodations', array(
                            'page'   =>1,
                            'type'   =>$type,
                            'city'   =>$city,
                            'keyword'=>urlencode($request->get('keywordSearch')),
                            'sort'   =>$sort,
                            'desc'   =>$desc,
        )));
    }

    public function testValue($obj)
    {
        if(is_null($obj) || $obj == 0)
            return 'all';
        else
            return $obj;
    }

    public function accommodationAction(Accommodation $accommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $accommodations=$em->getRepository("BackAccommodationBundle:Accommodation")->findBy(array('city'=>$accommodation->getCity(),'enabled'=>1), array(), 5);
        return $this->render('FrontGeneralBundle:Accommodations:accommodation.html.twig', array(
                    'accommodation'=>$accommodation,
                    'accommodations' =>$accommodations,
        ));
    }

}
