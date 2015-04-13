<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\SchoolBundle\Entity\School;
use Back\SchoolBundle\Form\SchoolType;

class SchoolController extends Controller
{

    public function addSchoolAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $school=new School();
        else
        {
            $school=$em->getRepository("BackSchoolBundle:School")->find($id);
            $schoolBack=$school;
        }
        $form=$this->createForm(new SchoolType(), $school);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $school=$form->getData();
                $Verif=$em->getRepository("BackSchoolBundle:School")->findOneBy(array( 'city'=>$school->getCity(), 'university'=>$school->getUniversity() ));
                if(!$Verif)
                {
                    $em->persist($school->setEnabled(TRUE));
                    $em->flush();
                    $session->getFlashBag()->add('success', "Your school has been added successfully");
                    return $this->redirect($this->generateUrl("list_school"));
                }
                else
                    $session->getFlashBag()->add('danger', "There is already a school with the same city and univirsity");
            }
        }
        return $this->render('BackSchoolBundle:school:add.html.twig', array(
                    'form'  =>$form->createView(),
                    'school'=>$school
        ));
    }

    public function listSchoolAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $schools=$em->getRepository("BackSchoolBundle:School")->findAll();
        return $this->render('BackSchoolBundle:school:list.html.twig', array(
                    'schools'=>$schools
        ));
    }

    public function deleteSchoolAction(School $school)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();

        try
        {
            $em->remove($school);
            $em->flush();
            $session->getFlashBag()->add('success', " Your school has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This school is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_school"));
    }

    public function enableSchoolAction(School $school)
    {
        $em = $this->getDoctrine()->getManager() ;
        $session = $this->getRequest()->getSession() ;
        if ($school->isEnabled())
            $school->setEnabled(FALSE) ;
        else
            $school->setEnabled(TRUE) ;
        $em->persist($school) ;
        $em->flush() ;
        $session->getFlashBag()->add('success' , "Your school has been updates successfully") ;
        return $this->redirect($this->generateUrl("list_school")) ;
    }
}
