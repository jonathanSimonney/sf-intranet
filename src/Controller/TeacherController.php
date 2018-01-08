<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/teacher")
 */
class TeacherController extends Controller
{
    /**
     * @Route("/", name="teacher_index")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    protected function createGrade(Grade $grade, Request $request)
    {
        $grade->setGivenBy($this->getUser());

        $options = array('isAdmin' => $this->isGranted('ROLE_ADMIN'));

        $em = $this->getDoctrine()->getManager();

        if ($options['isAdmin']){
            $options['students'] = $em->getRepository(User::class)->findByRole('ROLE_USER');
        }else{
            $options['students'] = $this->getUser()->getStudents();
            $options['subjects'] = $this->getUser()->getTaughtSubjects();
        }

        $form = $this->createForm('App\Form\GradeType', $grade, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($grade);
            $em->flush();

            return $this->redirectToRoute('grade_show', array('id' => $grade->getId()));
        }

        return $this->render('views/grade/new.html.twig', array(
            'grade' => $grade,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/grade/new", name="new_grade")
     */
    public function newGradeAction(Request $request)
    {
        $grade = new Grade();

        return $this->createGrade($grade, $request);
    }

    /**
     * Finds and displays a grade entity.
     *
     * @Route("/grade/{id}", name="grade_show")
     * @Method("GET")
     */
    public function showGradeAction(Grade $grade)
    {
        die(var_dump($grade));
        //todo use this action to show the grade ACCORDING TO WHO IS LOOKING AT IT (and do not forget to check he has the right to do so...)
    }
}
