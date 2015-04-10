<?php

namespace Back\ReferentielBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BackReferentielBundle:Default:index.html.twig');
    }
}
