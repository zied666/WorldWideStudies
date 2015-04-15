<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\SchoolLocation;
use Back\SchoolBundle\Form\SchoolLocationType;

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
                $Verif=$em->getRepository("BackSchoolBundle:SchoolLocation")->findOneBy(array( 'city'=>$schoolLocation->getCity(), 'school'=>$schoolLocation->getSchool() ));
                if(!$Verif)
                {
                    $em->persist($schoolLocation->setEnabled(TRUE));
                    $em->flush();
                    $session->getFlashBag()->add('success', "Your school has been added successfully");
                    return $this->redirect($this->generateUrl("list_school"));
                }
                else
                    $session->getFlashBag()->add('danger', "There is already a school with the same city and univirsity");
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

    public function listSchoolAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $schoolLocations=$em->getRepository("BackSchoolBundle:SchoolLocation")->findAll();
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

}
