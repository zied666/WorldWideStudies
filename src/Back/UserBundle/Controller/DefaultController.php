<?php

namespace Back\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Back\UserBundle\Entity\User;
use Back\UserBundle\Form\UserType;

class DefaultController extends Controller
{

    public function editprofileAction()
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $user=$this->get('security.context')->getToken()->getUser();
        $form=$this->createForm(new UserType(), $user);
        if($this->getRequest()->isMethod('POST'))
        {
            $form->submit($this->getRequest());
            if($form->isValid())
            {
                $user=$form->getData();
                $em->persist($user);
                $em->flush();
                $session->getFlashBag()->add('success', "Your profile has been updated successfully");
                return $this->redirect($this->generateUrl("change_profile_user"));
            }
        }
        return $this->render('BackUserBundle::change_profile.html.twig', array( 'form'=>$form->createView() ));
    }

}
