<?php

namespace Back\SchoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityRepository;
use Back\SchoolBundle\Entity\Extra;
use Back\SchoolBundle\Form\ExtraType;
use Back\SchoolBundle\Entity\SchoolLocation;

class ExtrasController extends Controller
{

    public function listAction(SchoolLocation $schoolLocation, $extra)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($extra == null)
            $extra=new Extra();
        else
            $extra=$em->getRepository("BackSchoolBundle:Extra")->find($extra);
        $extra->setSchoolLocation($schoolLocation);
        $form=$this->createForm(new ExtraType(), $extra);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $extra=$form->getData();
                $em->persist($extra);
                $em->flush();
                $session->getFlashBag()->add('success', "Your extra has been added successfully");
                return $this->redirect($this->generateUrl("list_extras", array( 'id'=>$schoolLocation->getId() )));
            }
        }
        return $this->render("BackSchoolBundle:extras:list.html.twig", array(
                    'form'  =>$form->createView(),
                    'school'=>$schoolLocation,
                    'extra'=>$extra,
        ));
    }

    public function deleteExtraAction(Extra $extra)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($extra);
            $em->flush();
            $session->getFlashBag()->add('success', " Your extra has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This extra is used by another table ');
        }
        return $this->redirect($this->generateUrl("list_extras", array( 'id'=>$extra->getSchoolLocation()->getId() )));
    }

}
