<?php

namespace App\Controller;

use App\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Finder\Exception\AccessDeniedException;

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
    public function indexSubjectAction(Subject $subject)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$user) {
            throw new \Exception('Vous n\'êtes pas connecté');
        }
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/subject/{id}", name="subject_show")
     * @Method("GET")
     */
    public function showSubjectAction(Subject $subject)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!$this->isGranted('ROLE_USER')) {
            $subject = $student->getLearnedSubjects();
        }

        if (!$this->isGranted('ROLE_ADMIN')) {
            $subject = array_intersect($subject, $this->getUser()->getTaughtSubjects());
        }

        return $this->render('common/homepage.html.twig');
    }

}
