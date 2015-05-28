<?php

namespace Front\GeneralBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Library
{

    public function __construct(EntityManager $entityManager, Session$session)
    {
        $this->em=$entityManager;
        $this->session=$session;
    }

    public function convertDate($date, $format='m/d/Y')
    {
        $date=\DateTime::createFromFormat($format, $date);
        if($date != '')
            return $date->format('Y-m-d');
    }

    function convertCurrency($amount, $from)
    {
        $session=$this->session->get('currency');
        if($from == $session['code'])
            return number_format($amount, $session['scale'], '.', '').' '.$session['code'];
        $url="https://www.google.com/finance/converter?a=$amount&from=$from&to=".$session['code'];
        $data=file_get_contents($url);
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        if(isset($converted[1]))
        {
            $converted=preg_replace("/[^0-9.]/", "", $converted[1]);
            return number_format($converted, $session['scale'], '.', '').' '.$session['code'];
        }
        return '';
    }

}
