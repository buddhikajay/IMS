<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Course View controller.
 *
 * @Route("/courses")
 */
class CourseViewController extends Controller
{

    /**
     * Lists all Course entities.
     *
     * @Route("/", name="courses_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:Course')->findAll();

        return $this->render('custom_views/course_management.html.twig', array('courses' => $courses));
    }

    /**
     * Deletes a Course entity.
     *
     * @Route("/", name="courses_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {

        $code = 200;
        $message = "Record Deleted Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $course = $em->getRepository('AppBundle:Course')->find($request->get('id'));
            if ($course != null) {
                $em->remove($course);
                $em->flush();
            }
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $debug = $request->get('id');
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }


    }


    /**
     * Creates a new Course entity.
     *
     * @Route("/", name="course_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $code = 200;
        $message = "New Course Created Successfully";
        $debug = $request->get('minPoint')."sdjfdshg";
        try {
            $course = new Course();

            $course->setCode($request->get('code'));
            $course->setDescription($request->get('description'));
            $course->setName($request->get('name'));
            $course->setScoreRequired($request->get('minPoint'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($course);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $debug = $request->get('minPoint')."sdjfdshg";
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }


    /**
     * Update a Course entity.
     *
     * @Route("/update", name="course_update")
     * @Method("POST")
     */
    public function updateAction(Request $request)
    {
        $code = 200;
        $message = "Course Updated Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $course = $em->getRepository('AppBundle:Course')->find($request->get('id'));

            $course->setCode($request->get('code'));
            $course->setDescription($request->get('description'));
            $course->setName($request->get('name'));
            $course->setScoreRequired($request->get('minPoint'));


            $em->persist($course);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $debug =$request->get('minPoint');
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

}

