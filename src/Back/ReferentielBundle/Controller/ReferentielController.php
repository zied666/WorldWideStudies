<?php

namespace Back\ReferentielBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\ReferentielBundle\Entity\Country;
use Back\ReferentielBundle\Form\CountryType;
use Back\ReferentielBundle\Entity\City;
use Back\ReferentielBundle\Form\CityType;
use Back\ReferentielBundle\Entity\University;
use Back\ReferentielBundle\Form\UniversityType;
use Back\UserBundle\Entity\User;
use Back\UserBundle\Form\RegistrationFormType;
use Back\ReferentielBundle\Entity\Language;
use Back\ReferentielBundle\Form\LanguageType;
use Back\ReferentielBundle\Entity\Program;
use Back\ReferentielBundle\Form\ProgramType;

class ReferentielController extends Controller
{

    public function countryAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $country=new Country ();
        else
            $country=$em->getRepository("BackReferentielBundle:Country")->find($id);
        $countrys=$em->getRepository("BackReferentielBundle:Country")->findAll();
        $form=$this->createForm(new CountryType(), $country);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $country=$form->getData();
                $em->persist($country);
                $em->flush();
                $session->getFlashBag()->add('success', "Your country has been added successfully");
                return $this->redirect($this->generateUrl("country"));
            }
        }
        return $this->render('BackReferentielBundle:Ref:country.html.twig', array(
                    'form'    =>$form->createView(),
                    'country' =>$country,
                    'countrys'=>$countrys
        ));
    }

    public function deleteCountryAction(Country $country)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($country);
            $em->flush();
            $session->getFlashBag()->add('success', " Your object has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This object is used by another table ');
        }
        return $this->redirect($this->generateUrl("country"));
    }

    public function cityAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $city=new City ();
        else
            $city=$em->getRepository("BackReferentielBundle:City")->find($id);
        $citys=$em->getRepository("BackReferentielBundle:City")->findAll();
        $form=$this->createForm(new CityType(), $city);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $city=$form->getData();
                $em->persist($city);
                $em->flush();
                $session->getFlashBag()->add('success', "Your city has been added successfully");
                return $this->redirect($this->generateUrl("city"));
            }
        }
        return $this->render('BackReferentielBundle:Ref:city.html.twig', array(
                    'form' =>$form->createView(),
                    'city' =>$city,
                    'citys'=>$citys
        ));
    }

    public function deleteCityAction(City $city)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($city);
            $em->flush();
            $session->getFlashBag()->add('success', " Your object has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This object is used by another table ');
        }
        return $this->redirect($this->generateUrl("city"));
    }

    public function universityAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $university=new University ();
        else
            $university=$em->getRepository("BackReferentielBundle:University")->find($id);
        $universitys=$em->getRepository("BackReferentielBundle:University")->findAll();
        $form=$this->createForm(new UniversityType(), $university);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $university=$form->getData();
                $em->persist($university);
                $em->flush();
                $session->getFlashBag()->add('success', "Your university has been added successfully");
                return $this->redirect($this->generateUrl("university"));
            }
        }
        return $this->render('BackReferentielBundle:Ref:university.html.twig', array(
                    'form'       =>$form->createView(),
                    'university' =>$university,
                    'universitys'=>$universitys
        ));
    }

    public function deleteUniversityAction(University $university)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($university);
            $em->flush();
            $session->getFlashBag()->add('success', " Your university has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This university is used by another table ');
        }
        return $this->redirect($this->generateUrl("university"));
    }

    public function administratorAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $currentUser=$this->container->get('security.context')->getToken()->getUser();
        if($id == NULL)
            $user=new User ();
        else
            $user=$em->getRepository("BackUserBundle:User")->find($id);
        $users=$this->findByRole("ROLE_ADMIN");
        $form=$this->createForm(new RegistrationFormType(), $user);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $user=$form->getData();
                $em->persist($user->addRole("ROLE_ADMIN")->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your administrator has been added successfully");
                return $this->redirect($this->generateUrl("administrator"));
            }
        }
        return $this->render('BackReferentielBundle:Ref:user.html.twig', array(
                    'form'       =>$form->createView(),
                    'user'       =>$user,
                    'users'      =>$users,
                    'currentUser'=>$currentUser,
        ));
    }

    public function deleteAdministratorAction(User $user)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($user);
            $em->flush();
            $session->getFlashBag()->add('success', " Your administrator has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This administrator is used by another table ');
        }
        return $this->redirect($this->generateUrl("administrator"));
    }

    public function enableUserAction(User $user)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($user->isEnabled())
            $user->setEnabled(FALSE);
        else
            $user->setEnabled(TRUE);
        $em->persist($user);
        $em->flush();
        $session->getFlashBag()->add('success', "Your administrator has been updated successfully");
        return $this->redirect($this->generateUrl("administrator"));
    }

    public function findByRole($role)
    {
        $qb=$this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('u')
                ->from('BackUserBundle:User', 'u')
                ->where('u.roles LIKE :roles')
                ->setParameter('roles', '%"'.$role.'"%');
        return $qb->getQuery()->getResult();
    }

    public function languageAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == null)
            $language=new Language();
        else
            $language=$em->getRepository("BackReferentielBundle:Language")->find($id);

        $form=$this->createForm(new LanguageType(), $language);
        $languages=$em->getRepository("BackReferentielBundle:Language")->findAll();
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $language=$form->getData();
                $em->persist($language);
                $em->flush();
                $session->getFlashBag()->add('success', "Your language has been added successfully");
                return $this->redirect($this->generateUrl("language"));
            }
        }
        return $this->render("BackReferentielBundle:Ref:language.html.twig", array(
                    'form'    =>$form->createView(),
                    'language'=>$language,
                    'languages'=>$languages
        ));
    }

    public function deleteLanguageAction(Language $language)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($language);
            $em->flush();
            $session->getFlashBag()->add('success', " Your language has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This language is used by another table ');
        }
        return $this->redirect($this->generateUrl("language"));
    }

    public function programAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == null)
            $program=new Program();
        else
            $program=$em->getRepository("BackReferentielBundle:Program")->find($id);
        $programs=$em->getRepository("BackReferentielBundle:Program")->findAll();

        $form=$this->createForm(new ProgramType(), $program);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $program=$form->getData();
                $em->persist($program);
                $em->flush();
                $session->getFlashBag()->add('success', "Your program has been added successfully");
                return $this->redirect($this->generateUrl("program"));
            }
        }
        return $this->render("BackReferentielBundle:Ref:program.html.twig", array(
                    'form'   =>$form->createView(),
                    'program'=>$program,
                    'programs'=>$programs
        ));
    }

    public function deleteProgramAction(Program $program)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($program);
            $em->flush();
            $session->getFlashBag()->add('success', " Your program has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This program is used by another table ');
        }
        return $this->redirect($this->generateUrl("program"));
    }

}
