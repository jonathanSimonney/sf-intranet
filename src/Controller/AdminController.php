<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Entity\User;
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

    /**
     * displays all user entities.
     *
     * @Route("/user", name="user_index")
     * @Method("GET")
     */
    public function indexUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userList = $em->getRepository('App:User')->findAll();

        return $this->render('views/user/index.html.twig', array(
            'userList'     => $userList
        ));
    }

    /**
     * login as another user.
     *
     * @Route("/impersonate/user/{id}", name="user_impersonate")
     * @Method("GET")
     */
    public function impersonateUser(User $user)
    {
        return $this->redirect($this->generateUrl('homepage', array('_switch_user' => $user->getUsernameCanonical())));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/show/user/{id}", name="user_show")
     */
    public function showAndEditUserAction(Request $request, User $user)
    {
        //todo show the user ; give route to edit his role, impersonate him, and give him his grade (if he is a student).
        //Also, add him a subject, show his subject, his grade, etc.

        //todo add options to know which subjects should be shown.
        $user->setRole($user->getMaxRole());

        $form = $this->createForm('App\Form\UserType', $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles([$user->getRole()]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }
        $user->setRole($user->getMaxRole());

        return $this->render('views/user/show.html.twig', array(
            'user'     => $user,
            'editForm' => $form->createView(),
        ));
    }
}
