<?php

namespace App\Controller;

use App\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

    /**
     * displays all subject entities.
     *
     * @Route("/subject", name="subject_index")
     * @Method("GET")
     */
    public function indexSubjectAction()
    {
        //TODO forbid from teachers, AND do a good list according to role.
        die;
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/subject/{id}", name="subject_show")
     * @Method("GET")
     */
    public function showSubjectAction(Subject $subject)
    {
        die(var_dump($subject));
        //todo use this action to show the subject ACCORDING TO WHO IS LOOKING AT IT (and do not forget to check he has the right to do so...)
    }
}
