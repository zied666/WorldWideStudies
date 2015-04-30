<?php

namespace Back\ReferentielBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Back\ReferentielBundle\Entity\Country;
use Back\ReferentielBundle\Form\CountryType;
use Back\ReferentielBundle\Entity\City;
use Back\ReferentielBundle\Form\CityType;
use Back\ReferentielBundle\Entity\School;
use Back\ReferentielBundle\Form\SchoolType;
use Back\UserBundle\Entity\User;
use Back\UserBundle\Form\RegistrationFormType;
use Back\ReferentielBundle\Entity\Language;
use Back\ReferentielBundle\Form\LanguageType;
use Back\ReferentielBundle\Entity\Program;
use Back\ReferentielBundle\Form\ProgramType;
use Back\ReferentielBundle\Entity\TypeAccommodation;
use Back\ReferentielBundle\Form\TypeAccommodationType;
use Back\ReferentielBundle\Entity\Currency;
use Back\ReferentielBundle\Form\CurrencyType;

class ReferentielController extends Controller
{

    public function currencyAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $currency=new Currency ();
        else
            $currency=$em->getRepository("BackReferentielBundle:Currency")->find($id);
        $currencys=$em->getRepository("BackReferentielBundle:Currency")->findAll();
        $form=$this->createForm(new CurrencyType(), $currency);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $currency=$form->getData();
                $em->persist($currency);
                $em->flush();
                $session->getFlashBag()->add('success', "Your currency has been added successfully");
                return $this->redirect($this->generateUrl("currency"));
            }
        }
        return $this->render('BackReferentielBundle::currency.html.twig', array(
                    'form'     =>$form->createView(),
                    'currency' =>$currency,
                    'currencys'=>$currencys
        ));
    }

    public function deleteCurrencyAction(Currency $currency)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($currency);
            $em->flush();
            $session->getFlashBag()->add('success', " Your object has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This object is used by another table ');
        }
        return $this->redirect($this->generateUrl("currency"));
    }

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
        return $this->render('BackReferentielBundle::country.html.twig', array(
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
        return $this->render('BackReferentielBundle::city.html.twig', array(
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

    public function schoolAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == NULL)
            $school=new School ();
        else
            $school=$em->getRepository("BackReferentielBundle:School")->find($id);
        $schools=$em->getRepository("BackReferentielBundle:School")->findAll();
        $form=$this->createForm(new SchoolType(), $school);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $school=$form->getData();
                $em->persist($school);
                $em->flush();
                $session->getFlashBag()->add('success', "Your school has been added successfully");
                return $this->redirect($this->generateUrl("school"));
            }
        }
        return $this->render('BackReferentielBundle::school.html.twig', array(
                    'form'   =>$form->createView(),
                    'school' =>$school,
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
        return $this->redirect($this->generateUrl("school"));
    }

    public function administratorAction($id,$password)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        $currentUser=$this->container->get('security.context')->getToken()->getUser();
        if($id == NULL)
            $user=new User ();
        else
            $user=$em->getRepository("BackUserBundle:User")->find($id);
        $users=$this->findByRoleAdmin();
        $form=$this->createForm(new RegistrationFormType(), $user);
        $form->add('roles', 'choice', array( 'choices' =>
            array(
                'ROLE_SUPER_ADMIN'        =>'SUPER ADMIN',
                'ROLE_ADMIN_CONFIG'       =>'CONFIGURATION',
                'ROLE_ADMIN_UNIVERSITY'   =>'UNIVERSITY',
                'ROLE_ADMIN_ACCOMMODATION'=>'ACCOMMODATION',
                'ROLE_ADMIN_SCHOOL'       =>'SCHOOL',
            ),
            'required'=>true,
            'expanded'=>true,
            'multiple'=>true
        ));
        $form->add("Submit","submit",array('attr'=>array('class'=>'btn btn-primary btn-wide pull-right')));
        if($id!=NULL  && $password==NULL)
            $form->remove("plainPassword");
        elseif($id!=NULL)
            $form->remove("roles")->remove("email");
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $user=$form->getData();
                $em->persist($user->setEnabled(TRUE));
                $em->flush();
                $session->getFlashBag()->add('success', "Your administrator has been added successfully");
                return $this->redirect($this->generateUrl("administrator"));
            }
        }
        return $this->render('BackReferentielBundle::user.html.twig', array(
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

    public function findByRoleAdmin()
    {
        $qb=$this->getDoctrine()->getManager()->createQueryBuilder();
        $qb->select('u')
                ->from('BackUserBundle:User', 'u')
                ->where('u.roles LIKE :role')
                ->orWhere('u.roles LIKE :role1')
                ->orWhere('u.roles LIKE :role2')
                ->orWhere('u.roles LIKE :role3')
                ->orWhere('u.roles LIKE :role4')
                ->orWhere('u.roles LIKE :role5')
                ->setParameter('role', '%ROLE_ADMIN%')
                ->setParameter('role1', '%ROLE_SUPER_ADMIN%')
                ->setParameter('role2', '%ROLE_ADMIN_UNIVERSITY%')
                ->setParameter('role3', '%ROLE_ADMIN_ACCOMMODATION%')
                ->setParameter('role4', '%ROLE_ADMIN_SCHOOL%')
                ->setParameter('role5', '%ROLE_ADMIN_CONFIG%');
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
        return $this->render("BackReferentielBundle::language.html.twig", array(
                    'form'     =>$form->createView(),
                    'language' =>$language,
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
        return $this->render("BackReferentielBundle::program.html.twig", array(
                    'form'    =>$form->createView(),
                    'program' =>$program,
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

    public function typeAccomodationAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        if($id == null)
            $typeAccommodation=new TypeAccommodation();
        else
            $typeAccommodation=$em->getRepository("BackReferentielBundle:TypeAccommodation")->find($id);
        $typeAccommodations=$em->getRepository("BackReferentielBundle:TypeAccommodation")->findAll();

        $form=$this->createForm(new TypeAccommodationType(), $typeAccommodation);
        $request=$this->getRequest();
        if($request->isMethod("POST"))
        {
            $form->submit($request);
            if($form->isValid())
            {
                $typeAccommodation=$form->getData();
                $em->persist($typeAccommodation);
                $em->flush();
                $session->getFlashBag()->add('success', "Your program has been added successfully");
                return $this->redirect($this->generateUrl("type_accommodation"));
            }
        }
        return $this->render("BackReferentielBundle::type_accomodation.html.twig", array(
                    'form'              =>$form->createView(),
                    'typeAccommodation' =>$typeAccommodation,
                    'typeAccommodations'=>$typeAccommodations
        ));
    }

    public function deleteTypeAccomodationAction(TypeAccommodation $typeAccommodation)
    {
        $em=$this->getDoctrine()->getManager();
        $session=$this->getRequest()->getSession();
        try
        {
            $em->remove($typeAccommodation);
            $em->flush();
            $session->getFlashBag()->add('success', " Your type of Accommodation has been successfully removed ");
        }
        catch(\Exception $ex)
        {
            $session->getFlashBag()->add('danger', 'This program is used by another table ');
        }
        return $this->redirect($this->generateUrl("type_accommodation"));
    }

}
