<?php

namespace Back\GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackGeneralBundle:Default:index.html.twig');
    }
}
