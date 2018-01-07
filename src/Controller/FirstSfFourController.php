<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FirstSfFourController extends Controller
{
    /**
     * @Route("/", name="redirector")
     */
    public function index()
    {
        if ($this->isGranted('ROLE_USER')){
            return $this->redirectToRoute('homepage');
        }
        return $this->redirectToRoute('fos_user_security_login');
    }
}
