<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Index extends Controller
{
    /**
     * @Route(path="/")
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function index()
    {
        return $this->render('index.twig');
    }
}