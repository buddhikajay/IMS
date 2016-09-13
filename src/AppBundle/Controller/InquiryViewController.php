<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\ALSubject;
use AppBundle\Entity\Followup;
use AppBundle\Entity\InquiryMode;
use AppBundle\Entity\Person;
use AppBundle\Entity\Inquiry;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Inquiry view controller.
 *
 * @Route("/inquiries")
 */
class InquiryViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="inquiries_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        // @ToDo Grab data from DB and pass to frontend
        $em = $this->getDoctrine()->getManager();
        $alsubjets = $em->getRepository('AppBundle:ALSubject')->findAll();
        $courses = $em->getRepository('AppBundle:Course')->findAll();
        $inquiryModes = $em->getRepository('AppBundle:InquiryMode')->findAll();
        $myInquiries = $em->getRepository('AppBundle:Inquiry')->findBy(array(
            'counsellor' => $this->get('security.token_storage')->getToken()->getUser()
        ));

        $userID = $this->get('security.token_storage')->getToken()->getUser()->getID();

        $pendingID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => "Pending"
        ));

        $unassignedID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => "Unassigned"
        ));

        $queryPending = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.counsellor=" . $userID . " AND u.inquiryStatus=" . $pendingID->getId());
        $myInquiriesPending = $queryPending->getResult();

        $queryIncompleteComplete = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.counsellor=" . $userID . " AND u.inquiryStatus!=" . $pendingID->getId() . "AND u.inquiryStatus !=" . $unassignedID->getId());
        $myInquiriesIncompleteComplete = $queryIncompleteComplete->getResult();

        $inquiryStatuses = $em->getRepository('AppBundle:InquiryStatus')->findAll();

        return $this->render('custom_views/inquiries.html.twig', array('alsubjects' => $alsubjets,
            'courses' => $courses,
            'inquiryModes' => $inquiryModes,
            'pendingInquiries' => $myInquiriesPending,
            'allInquiries' => $myInquiriesIncompleteComplete,
            'inquiryStatuses' => $inquiryStatuses
        ));
    }

    /**
     * Creates a new Inquiry entity.
     *
     * @Route("/", name="inquiries_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $code = 200;
        $message = "New Inquiry Created Successfully";
        $debug = "";
        try {
            $em = $this->getDoctrine()->getManager();

            if($request->get('nic') == null)
                $person = $em->getRepository('AppBundle:Person')->findOneBy(array('telephone' => $request->get('tel')));
            else
                $person = $em->getRepository('AppBundle:Person')->findOneBy(array('nic' => $request->get('nic')));

            if ($person == null) {
                $person = new Person();
                $person->setNic($request->get('nic'));
                $person->setName($request->get('name'));
                $person->setTelephone($request->get('tel'));
                $person->setEmail($request->get('email'));
                $person->setSchool($request->get('school'));
                $person->setDistrict($request->get('add_district'));
                $person->setOlEnglish($request->get('oleng'));
                $person->setOlMaths($request->get('olmath'));
                $person->setLanguage($request->get('lang'));
                $person->setAlGrades(array(
                    $request->get('al1') => $request->get('al1result'),
                    $request->get('al2') => $request->get('al2result'),
                    $request->get('al3') => $request->get('al3result')));
                $debug .= $request->get('dob');
                //$debug .= DateTime::createFromFormat('d/m/Y', "21-2-1991")->format('Y-m-d');
                //$person->setDob(DateTime::createFromFormat('d/m/Y', "21-2-1991"));
                $date = date_create();
                $date->setTime(4, 3, 2);

                $debug .= " " . $request->get('freeTime');
                // $person->setAvailableTime($date);
                $person->setEduQualification($request->get('quali'));
                $person->setWorkExperience($request->get('work'));
                $person->setStreet1($request->get('add_st1'));
                $person->setStreet2($request->get('add_st2'));
                $person->setCity($request->get('add_city'));
                $person->setDescription($request->get('description'));

                $em->persist($person);
                $em->flush();
            } else {
                $debug .= $person->getTelephone();
            }

            $inquiry = new Inquiry();
            $inquiry->setPerson($person);
            $course = $em->getRepository('AppBundle:Course')->findOneBy(array(
                'code' => $request->get('course')));
            if ($course != null)
                $inquiry->setCourse($course);
            else
                $debug .= "course for code " . $request->get('course') . " was null";

            $inquiryMode = $em->getRepository('AppBundle:InquiryMode')->findOneBy(array(
                'code' => $request->get('moi')
            ));
            if ($inquiryMode != null)
                $inquiry->setInquiryMode($inquiryMode);
            else
                $debug .= "Inquiry Mode for code " . $request->get('moi') . " was null";

            $inquiryStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                'name' => 'Following'
            ));
            if ($inquiryStatus != null)
                $inquiry->setInquiryStatus($inquiryStatus);
            else
                $debug .= "Inquiry Status called Following is required";

            $inquiry->setCounsellor($this->get('security.token_storage')->getToken()->getUser());

            // year and semester will be set when the student is registered.

            $inquiry->setProbability($request->get('prob'));
            $inquiry->setLastModified(new \DateTime("now"));
            $inquiry->setCreated(new \DateTime("now"));

            $em->persist($inquiry);
            $em->flush();

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Create new Email Template
     * @Route("/followup/index",name="get_followup")
     * @Method("POST")
     */
    public function getFollowupAction(Request $request)
    {
        $code = 200;
        $message = "Followup: " . $request->get('inquiry') . " Fetched Successfully";
        $debug = "";

        $followup = new Followup();
        $serializedFollowup = "";
        $serializedInquiry = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $followup = $em->getRepository('AppBundle:Followup')->findBy(array('inquiry' => $request->get('inquiry')));

            $inquiry = $em->getRepository('AppBundle:Inquiry')->find($request->get('inquiry'));

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);
            $serializedFollowup = $serializer->serialize($followup, 'json');
            $serializedInquiry = $serializer->serialize($inquiry, 'json');

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('inquiry' => $serializedInquiry, 'followup' => $serializedFollowup, 'code' => $code, 'message' => $message, 'debug' => $debug));
        }

    }

    /**
     * Create new Followup
     * @Route("/followup/call",name="set_followup_call")
     * @Method("POST")
     */
    public function setFollowupCallAction(Request $request)
    {
        $code = 200;
        $message = "Followup created successfully";
        $debug = "";

        $followup = new Followup();

        try {
            $em = $this->getDoctrine()->getManager();
            $followup->setAction($request->get('code'));
            $followup->setDescription($request->get('summary'));
            $followup->setConcellor($this->get('security.token_storage')->getToken()->getUser());
            $followup->setTimestamp(new \DateTime('now'));

            $inquiry = $em->getRepository('AppBundle:Inquiry')->find($request->get('inquiryID'));
            $followup->setInquiry($inquiry);

            $em->persist($followup);
            $em->flush();

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Create new Followup
     * @Route("/inquirystatuschange",name="inquiry_status_change")
     * @Method("POST")
     */
    public function changeInquiryStatusAction(Request $request)
    {
        $code = 200;
        $message = "Followup created successfully" ;
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $inquiry = $em->getRepository('AppBundle:Inquiry')->find($request->get('id'));
            $followingStatusID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                "name" => $request->get('status')
            ));

            $inquiry->setInquiryStatus($followingStatusID);
            $debug .= "prob set to: ".$request->get('prob');
            $inquiry->setProbability($request->get('prob'));
            $em->persist($inquiry);
            $em->flush();

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        }finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }
    
}



