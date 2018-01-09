<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\Subject;
use App\Entity\User;
use Psr\Log\InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    protected function createGrade(Grade $grade, Request $request, $options=array())
    {
        $grade->setGivenBy($this->getUser());

        $options['isAdmin'] = $this->isGranted('ROLE_ADMIN');

        $em = $this->getDoctrine()->getManager();

        if ($options['isAdmin']){
            $options['students'] = $em->getRepository(User::class)->findByRole('ROLE_USER');
        }else{
            $options['students'] = $this->getUser()->getStudents();
            $options['subjects'] = $this->getUser()->getTaughtSubjects();
        }

        if ($options['ownerDisabled']){
            $options['students'] = $this->getSubjectStudent($grade->getSubject());
        }

        if ($options['subjectDisabled']){
            $options['subjects'] = $this->getStudentSubjects($grade->getOwner());
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
     * @Route("/grade/new/from/subject/{id}", name="new_grade_from_subject")
     */
    public function newGradeFromSubjectAction(Request $request, Subject $subject)
    {
        $grade = new Grade();
        $grade->setSubject($subject);

        $options = ['subjectDisabled' => true];
        return $this->createGrade($grade, $request, $options);
    }

    /**
     * @Route("/grade/new/from/student/{id}", name="new_grade_from_student")
     */
    public function newGradeFromStudentAction(Request $request, User $student)
    {
        $grade = new Grade();
        $grade->setOwner($student);

        $options = ['ownerDisabled' => true];
        return $this->createGrade($grade, $request, $options);
    }

    /**
     * @Route("/grade/new", name="new_grade")
     */
    public function newGradeAction(Request $request)
    {
        throw new Exception("still no js workaround found to create grade from nothing.");

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

    /**
     * Finds and displays the subjects of a student.
     *
     */
    protected function getStudentSubjects(User $student)
    {
        $userRole = $student->getMaxRole();
        if ($userRole !== 'ROLE_USER'){
            throw new InvalidArgumentException("Student expected, ".$userRole." given");
        }

        if (!$this->isGranted('ROLE_ADMIN') && !\in_array($student, $this->getUser()->getStudents())){
            throw new AccessDeniedException();
        }

        $subjects = $student->getLearnedSubjects();
         if (!$this->isGranted('ROLE_ADMIN')){
             $subjects = array_intersect($subjects, $this->getUser()->getTaughtSubjects());
         }

        return $subjects;
    }

    /**
     * Finds and displays the subjects of a student.
     *
     */
    protected function getSubjectStudent(Subject $subject)
    {
        if (!$this->isGranted('ROLE_ADMIN') && !\in_array($subject, $this->getUser()->getTaughtSubjects())){
            throw new AccessDeniedException();
        }

        return $subject->getStudents();
    }
}
