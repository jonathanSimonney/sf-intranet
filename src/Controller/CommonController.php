<?php

namespace App\Controller;

use App\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        $arrayFormAssignment = [];
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->getMaxRole() === 'ROLE_TEACHER'){
            $subjectList = $this->getUser()->getTaughtSubjects();
        }else{
            $subjectList = $em->getRepository('App:Subject')->findAll();
            if ($this->getUser()->getMaxRole() === 'ROLE_USER'){
                foreach ($subjectList as $subject){
                    /** @var $subject Subject */
                    if ($subject->hasStudent($this->getUser())){
                        $arrayFormAssignment[$subject->getId()] = $this->createUnassignForm($subject);
                    }else{
                        $arrayFormAssignment[$subject->getId()] = $this->createAssignForm($subject);
                    }
                }
            }
        }

        return $this->render('views/subject/index.html.twig', array(
            'subjectList'     => $subjectList,
            'assignmentForms' => $arrayFormAssignment
        ));
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

    /**
     * assign a student to a subject.
     *
     * @Route("/assign/to/subject/{id}", name="subject_assign")
     * @Method("POST")
     */
    public function assignToSubjectAction(Request $request, Subject $subject)
    {
        $form = $this->createAssignForm($subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject->addStudent($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
        }

        return $this->redirectToRoute('subject_index');
    }

    /**
     * assign a student to a subject.
     *
     * @Route("/unassign/to/subject/{id}", name="subject_unassign")
     * @Method("POST")
     */
    public function unassignToSubjectAction(Request $request, Subject $subject)
    {
        $form = $this->createUnassignForm($subject);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject->removeStudent($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();
        }

        return $this->redirectToRoute('subject_index');
    }

    //todo these two form creation should be in a service, but no time left.
    /**
     * Creates a form to assign a user to a subject entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createAssignForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_assign', array('id' => $subject->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }

    /**
     * Creates a form to delete a ticket entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createUnassignForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_unassign', array('id' => $subject->getId())))
            ->setMethod('POST')
            ->getForm()
            ;
    }
}
