<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/student/only")
*/
class StudentController extends Controller
{
    /**
     * @Route("/", name="student_only_index")
     */
    public function index()
    {
        // replace this line with your own code!
        return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    /**
     * @Route("/grades", name="grade_index")
     */

    public function indexGradeAction() {

        $em = $this->getDoctrine()->getManager();
        $gradeList = $em->getRepository('App:Grade')->getGroupedGrade($this->getUser());

        //should be done in query builder...
        $gradeGroupedBySubject = array();
        $sum = 0;

        foreach ($gradeList as $grade){
            if (isset($gradeGroupedBySubject[$grade['subjectName']])){
                $gradeGroupedBySubject[$grade['subjectName']][] = $grade['value'].'/20';
            }else{
                $gradeGroupedBySubject[$grade['subjectName']] = [$grade['value'].'/20'];
            }
            $sum += $grade['value'];
        }

        $average = $sum / count($gradeList);

        return $this->render('views/grade/index.html.twig', array(
            'gradeGroupedBySubject'     => $gradeGroupedBySubject,
            'average'                   => $average,
        ));
    }

}
