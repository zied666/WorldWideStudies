<?php

namespace Back\ReferentielBundle\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use Symfony\Component\HttpFoundation\Session\Session ;
use Back\ReferentielBundle\Entity\Country ;
use Back\ReferentielBundle\Form\CountryType ;
use Back\ReferentielBundle\Entity\City ;
use Back\ReferentielBundle\Form\CityType ;
use Back\ReferentielBundle\Entity\University;
use Back\ReferentielBundle\Form\UniversityType;

class ReferentielController extends Controller
{

    public function countryAction($id)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        if ($id == NULL)
            $country = new Country () ;
        else
            $country = $em->getRepository("BackReferentielBundle:Country")->find($id) ;
        $countrys = $em->getRepository("BackReferentielBundle:Country")->findAll() ;
        $form = $this->createForm(new CountryType() , $country) ;
        $request = $this->getRequest() ;
        if ($request->isMethod("POST"))
        {
            $form->submit($request) ;
            if ($form->isValid())
            {
                $country = $form->getData() ;
                $em->persist($country) ;
                $em->flush() ;
                $session->getFlashBag()->add('success' , "Your country has been added successfully") ;
                return $this->redirect($this->generateUrl("country")) ;
            }
        }
        return $this->render('BackReferentielBundle:Ref:country.html.twig' , array (
                    'form' => $form->createView() ,
                    'country' => $country ,
                    'countrys' => $countrys
                )) ;
    }

    public function deleteCountryAction(Country $country)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        try
        {
            $em->remove($country) ;
            $em->flush() ;
            $session->getFlashBag()->add('success' , " Your object has been successfully removed ") ;
        } catch (\Exception $ex)
        {
            $session->getFlashBag()->add('danger' , 'This object is used by another table ') ;
        }
        return $this->redirect($this->generateUrl("country")) ;
    }

    public function cityAction($id)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        if ($id == NULL)
            $city = new City () ;
        else
            $city = $em->getRepository("BackReferentielBundle:City")->find($id) ;
        $citys = $em->getRepository("BackReferentielBundle:City")->findAll() ;
        $form = $this->createForm(new CityType() , $city) ;
        $request = $this->getRequest() ;
        if ($request->isMethod("POST"))
        {
            $form->submit($request) ;
            if ($form->isValid())
            {
                $city = $form->getData() ;
                $em->persist($city) ;
                $em->flush() ;
                $session->getFlashBag()->add('success' , "Your city has been added successfully") ;
                return $this->redirect($this->generateUrl("city")) ;
            }
        }
        return $this->render('BackReferentielBundle:Ref:city.html.twig' , array (
                    'form' => $form->createView() ,
                    'city' => $city ,
                    'citys' => $citys
                )) ;
    }

    public function deleteCityAction(City $city)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        try
        {
            $em->remove($city) ;
            $em->flush() ;
            $session->getFlashBag()->add('success' , " Your object has been successfully removed ") ;
        } catch (\Exception $ex)
        {
            $session->getFlashBag()->add('danger' , 'This object is used by another table ') ;
        }
        return $this->redirect($this->generateUrl("city")) ;
    }

    public function universityAction($id)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        if ($id == NULL)
            $university = new University () ;
        else
            $university = $em->getRepository("BackReferentielBundle:University")->find($id) ;
        $universitys = $em->getRepository("BackReferentielBundle:University")->findAll() ;
        $form = $this->createForm(new UniversityType() , $university) ;
        $request = $this->getRequest() ;
        if ($request->isMethod("POST"))
        {
            $form->submit($request) ;
            if ($form->isValid())
            {
                $university = $form->getData() ;
                $em->persist($university) ;
                $em->flush() ;
                $session->getFlashBag()->add('success' , "Your university has been added successfully") ;
                return $this->redirect($this->generateUrl("university")) ;
            }
        }
        return $this->render('BackReferentielBundle:Ref:university.html.twig' , array (
                    'form' => $form->createView() ,
                    'university' => $university ,
                    'universitys' => $universitys
                )) ;
    }

    public function deleteUniversityAction(University $university)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        try
        {
            $em->remove($university) ;
            $em->flush() ;
            $session->getFlashBag()->add('success' , " Your object has been successfully removed ") ;
        } catch (\Exception $ex)
        {
            $session->getFlashBag()->add('danger' , 'This object is used by another table ') ;
        }
        return $this->redirect($this->generateUrl("university")) ;
    }

}
