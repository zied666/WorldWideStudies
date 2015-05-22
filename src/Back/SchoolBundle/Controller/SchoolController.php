<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Form\SchoolLocationType;
use Back\ReferentielBundle\Entity\Media;
use Back\ReferentielBundle\Form\MediaType;

class SchoolController extends Controller
{

    public function addSchoolAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $schoolLocation=new SchoolLocation();
        $form=$this->createForm(new SchoolLocationType(), $schoolLocation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $schoolLocation=$form->getData();
                $em->persist($schoolLocation->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your school has been added successfully");
                return $this->redirect($this->generateUrl("list_school"));
            }
        }
        return $this->render('BackSchoolBundle:school:add.html.twig', array(
                    'form'=>$form->createView(),
        ));
    }

    public function editSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $form=$this->createForm(new SchoolLocationType(), $schoolLocation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $schoolLocation=$form->getData();
                $em->persist($schoolLocation->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your school has been added successfully");
                return $this->redirect($this->generateUrl("edit_school", array( 'id'=>$schoolLocation->getId() )));
            }
        }
        return $this->render('BackSchoolBundle:school:edit.html.twig', array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation
        ));
    }

    public function listSchoolLanguageAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array( 'type'=>1 ), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $schoolLocations=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackSchoolBundle:school:list.html.twig', array(
                    'schools'=>$schoolLocations
        ));
    }

    public function listSchoolPathwayAction()
    {
        $em=$this->getDoctrine()->getManager();
        $request=$this->getRequest();
        $session=$this->getRequest()->getSession();
        $query=$em->getRepository("BackSchoolBundle:SchoolLocation")->findBy(array( 'type'=>2 ), array( 'id'=>'desc' ));
        $paginator=$this->get('knp_paginator');
        $schoolLocations=$paginator->paginate($query, $request->query->get('page', 1), 10);
        return $this->render('BackSchoolBundle:school:list.html.twig', array(
                    'schools'=>$schoolLocations
        ));
    }

    public function deleteSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();

        try
        {
            $em->remove($schoolLocation);
            $em->flush();
            $session->getFlashBag()->add('success', " Your school has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This school is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_school"));
    }

    public function enableSchoolAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($schoolLocation->isEnabled())
            $schoolLocation->setEnabled(FALSE);
        else
            $schoolLocation->setEnabled(TRUE);
        $em->persist($schoolLocation);
        $em->flush();
        $session->getFlashBag()->add('success', "Your school has been updates successfully");
        return $this->redirect($this->generateUrl("list_school"));
    }

    public function galleryAction(SchoolLocation $schoolLocation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $media=new Media();
        $media->setSchoolLocation($schoolLocation);
        $form=$this->createForm(new MediaType, $media);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $media=$form->getData();
                $em->persist($media);
                $em->flush();
                $session->getFlashBag()->add('success', "Your photo has been added successfully");
                return $this->redirect($this->generateUrl("gallery_school", array(
                                    'id'=>$schoolLocation->getId()
                )));
            }
        }
        return $this->render('BackSchoolBundle:school:gallery.html.twig', array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation
        ));
    }

    public function deletePhotoAction(Media $media)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $em->remove($media);
        $em->flush();
        $session->getFlashBag()->add('success', "Your photo has been deleted successfully");
        return $this->redirect($this->generateUrl("gallery_school", array(
                            'id'=>$media->getSchoolLocation()->getId()
        )));
    }

}
