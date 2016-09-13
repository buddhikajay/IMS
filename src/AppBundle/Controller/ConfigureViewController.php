<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\ALSubject;
use AppBundle\Entity\CustomEmail;
use AppBundle\Entity\InquiryMode;
use AppBundle\Entity\InquiryStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inquiry view controller.
 *
 * @Route("/configure")
 */
class ConfigureViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="configure_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('homepage');
        }

        // @ToDo Grab data from DB and pass to frontend

        $em = $this->getDoctrine()->getManager();

        $alsubjects = $em->getRepository('AppBundle:ALSubject')->findAll();
        $ises = $em->getRepository('AppBundle:InquiryStatus')->findAll();
        $inquiryModes = $em->getRepository('AppBundle:InquiryMode')->findAll();
        $emails = $em->getRepository('AppBundle:CustomEmail')->findAll();

        return $this->render('custom_views/configure.html.twig', array('alsubjects' => $alsubjects, 'ises' => $ises, 'inquiryModes' => $inquiryModes, 'emails' => $emails));
    }

    /**
     * Deletes a Course entity.
     *
     * @Route("/", name="configure_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        $code = 200;
        $message = "Record Deleted Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $dataType = $request->get('Dtype');
            $debug .= $dataType;
            if ($dataType == "alsub") {
                $alsubjects = $em->getRepository('AppBundle:ALSubject')->find($request->get('id'));
                if ($alsubjects != null) {
                    $em->remove($alsubjects);
                    $em->flush();
                }
            } elseif ($dataType == "is") {
                $ises = $em->getRepository('AppBundle:InquiryStatus')->find($request->get('id'));
                if ($ises != null) {
                    $em->remove($ises);
                    $em->flush();
                }
            } elseif ($dataType == "im") {
                $inquiryMode = $em->getRepository('AppBundle:InquiryMode')->find($request->get('id'));
                if ($inquiryMode != null) {
                    $em->remove($inquiryMode);
                    $em->flush();
                }
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
     * @Route("/", name="configure_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $code = 200;
        $message = "New Course Created Successfully";
        $Dtype = $request->get('Dtype');
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();
            if ($Dtype == "alsub") {
                $alsubject = new ALSubject();

                $alsubject->setCode($request->get('code'));
                $alsubject->setName($request->get('name'));

                $em->persist($alsubject);
                $em->flush();
            } elseif ($Dtype == "is") {
                $inquirystatus = new InquiryStatus();

                $inquirystatus->setCode($request->get('code'));
                $inquirystatus->setName($request->get('name'));
                $inquirystatus->setComplete($request->get('complete'));

                $em->persist($inquirystatus);
                $em->flush();
            } elseif ($Dtype == "im") {
                $inquirymode = new InquiryMode();

                $inquirymode->setCode($request->get('code'));
                $inquirymode->setName($request->get('name'));

                $em->persist($inquirymode);
                $em->flush();
            }
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Update a Course entity.
     *
     * @Route("/update", name="configure_update")
     * @Method("POST")
     */
    public function updateAction(Request $request)
    {
        $code = 200;
        $message = "Course Updated Successfully";
        $debug = "";
        $Dtype = $request->get('Dtype');
        try {
            $em = $this->getDoctrine()->getManager();
            if ($Dtype == 'alsub') {
                $alsubject = $em->getRepository('AppBundle:ALSubject')->find($request->get('id'));

                $alsubject->setCode($request->get('code'));
                $alsubject->setName($request->get('name'));

                $debug = $request->get('name') . " " . $request->get('code');
                $em->persist($alsubject);
                $em->flush();
            } elseif ($Dtype == 'is') {
                $inquirystatus = $em->getRepository('AppBundle:InquiryStatus')->find($request->get('id'));

                $inquirystatus->setName($request->get('name'));
                $inquirystatus->setCode($request->get('code'));
                $inquirystatus->setComplete($request->get('complete'));

                $em->persist($inquirystatus);
                $em->flush();
            } elseif ($Dtype == 'im') {
                $inquiryMode = $em->getRepository('AppBundle:InquiryMode')->find($request->get('id'));

                $inquiryMode->setName($request->get('name'));
                $inquiryMode->setCode($request->get('code'));

                $em->persist($inquiryMode);
                $em->flush();
            }
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Create new Email Template
     * @Route("/email/new",name="configure_new_email")
     * @Method("POST")
     */
    public function newEmailAction(Request $request)
    {
        $code = 200;
        $message = "Template Created Successfully";
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $email = new CustomEmail();
            $email->setTitle($request->get('title'));
            $email->setBody($request->get('body'));
            $email->setName($request->get('name'));

            $em->persist($email);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Update Email Template
     * @Route("/email/update",name="configure_update_email")
     * @Method("POST")
     */
    public function updateEmailAction(Request $request)
    {
        $code = 200;
        $message = "Template Updated Successfully";
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $email = $em->getRepository('AppBundle:CustomEmail')->find($request->get('id'));
            $email->setTitle($request->get('title'));
            $email->setBody($request->get('body'));
            $email->setName($request->get('name'));

            $em->persist($email);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Delete Email Template
     * @Route("/email/delete",name="configure_delete_email")
     * @Method("DELETE")
     */
    public function deleteEmailAction(Request $request)
    {
        $code = 200;
        $message = "Template Deleted Successfully";
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $email = $em->getRepository('AppBundle:CustomEmail')->find($request->get('id'));

            $em->remove($email);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }
}

