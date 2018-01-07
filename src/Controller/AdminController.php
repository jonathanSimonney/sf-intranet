<?php

namespace App\Controller;

use App\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    /**
     * Creates a new subject entity.
     *
     * @Route("/subject/new", name="subject_new")
     * @Method({"GET", "POST"})
     */
    public function newSubjectAction(Request $request)
    {
        $subject = new Subject();

        $form = $this->createForm('App\Form\SubjectType', $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return $this->render('views/subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }
}
