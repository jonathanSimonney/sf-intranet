<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/common")
 */
class CommonController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('common/homepage.html.twig');
    }
}
