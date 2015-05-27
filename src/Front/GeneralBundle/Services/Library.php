<?php

namespace Front\GeneralBundle\Services;

class Library
{
    public function convertDate($date,$format='m/d/Y')
    {
        $date=\DateTime::createFromFormat($format, $date);
        if($date!='')
            return $date->format('Y-m-d');
    }
}
