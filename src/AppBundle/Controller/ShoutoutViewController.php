<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Broadcast;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Inquiry view controller.
 *
 * @Route("/shoutouts")
 */
class ShoutoutViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="shoutout_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        // @ToDo Grab data from DB and pass to frontend
        $em = $this->getDoctrine()->getManager();
        $inquiryModes = $em->getRepository("AppBundle:InquiryMode")->findAll();
        $courses = $em->getRepository("AppBundle:Course")->findAll();
        $inquiryStatuses = $em->getRepository("AppBundle:InquiryStatus")->findAll();
        $shoutoutLog = $em->getRepository("AppBundle:Broadcast")->findAll();

        return $this->render('custom_views/shoutout.html.twig', array(
            'inquiryModes' => $inquiryModes,
            'courses' => $courses,
            'inquiryStatuses' => $inquiryStatuses,
            'shoutoutLog' => $shoutoutLog
        ));
    }

    /**
     * Creates a new Inquiry entity.
     *
     * @Route("/shoutout/new", name="shoutout_new")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {

        $code = 200;
        $message = "New Shoutout Created Successfully";
        $debug = "";
        $inquiryPhoneNumbers = null;
        $inquiryEmailsNumbers = null;
        try {
            $em = $this->getDoctrine()->getManager();
            $broadcast = new Broadcast();

            $broadcast->setName($request->get('name'));

            $type = $request->get('type');

            $broadcast->setAction($request->get('type'));
            if ($type == 'SMS')
                $broadcast->setDescription($request->get('smsBody'));
            elseif ($type == 'Email')
                $broadcast->setDescription($request->get('emailSubject') . " " . $request->get('emailBody'));

            $criteria = 'Inquiry Type: ' . $request->get('inquiryType') . ", " .
                'Course: ' . $request->get('course') . ", " .
                'Inquiry Date: ' . $request->get('inquiryDate') . ", " .
                'Inquiry Status: ' . $request->get('inquiryStatus') . ", " .
                'Number of Shoutouts: ' . $request->get('number');

            $broadcast->setCriteria($criteria);
            $broadcast->setTimestamp(new \DateTime("now"));
            $broadcast->setSentCount($request->get('number'));

            // the recieved count will not be kept in DB, but taken from Shoutout API.

            $em->persist($broadcast);
            $em->flush();


            //send sms'es
            $inqType = $em->getRepository('AppBundle:InquiryMode')->findOneBy(array(
                'code' => $request->get('inquiryType')
            ));
            $typeID = null;
            if ($inqType != null) {
                $typeID = $inqType->getId();
            }
            $course = $em->getRepository('AppBundle:Course')->findOneBy(array(
                'code' => $request->get('course')
            ));
            $courseID = null;
            if ($course != null) {
                $courseID = $course->getId();
            }

            $status = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                'code' => $request->get('inquiryStatus')
            ));
            $statusID = null;
            if ($status != null) {
                $statusID = $status->getId();
            }

            if ($type == "SMS") {
                $inquiryPhoneNumbers = $em->getRepository('AppBundle:Inquiry')->getPhoneNumbers($typeID, $courseID, $request->get('inquiryDate'), $statusID);
                foreach ($inquiryPhoneNumbers as $phone){
                    $debug .= " " . $phone['telephone'];
                }

            } else if ($type == "Email") {
                $debug .= "in EMAIL";
                $inquiryEmailsNumbers = $em->getRepository('AppBundle:Inquiry')->getEmails($typeID, $courseID, $request->get('inquiryDate'), $statusID);
                foreach ($inquiryEmailsNumbers as $email){
                    $debug .= " " . $email['email'];

                    $data = array(
                        'email' => $email['email'],
                        'subject' => $request->get('emailSubject'),
                        'body' => $request->get('emailBody')
                    );

                    $_request = Request::create(
                        '/email',
                        'GET',
                        $data
                    );

                    $resp = $this->sendEmail($_request);

                    //$emailResp = $resp->get('debug');
                }
            }
        } catch
        (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

    /**
     * Calculates shoutout number
     *
     * @Route("/shoutout/evaluate", name="shoutout_evaluate")
     * @Method("POST")
     */
    public function shoutoutEvaluateAction(Request $request)
    {

        $code = 200;
        $message = "New Shoutout Created Successfully";
        $debug = "";
        $value = 0;
        try {
            $em = $this->getDoctrine()->getManager();

            $type = $em->getRepository('AppBundle:InquiryMode')->findOneBy(array(
                'code' => $request->get('type')
            ));
            $typeID = null;
            if ($type != null) {
                $typeID = $type->getId();
            }

            $course = $em->getRepository('AppBundle:Course')->findOneBy(array(
                'code' => $request->get('course')
            ));
            $courseID = null;
            if ($course != null) {
                $courseID = $course->getId();
            }

            $status = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                'code' => $request->get('status')
            ));
            $statusID = null;
            if ($status != null) {
                $statusID = $status->getId();
            }

            $value = $em->getRepository('AppBundle:Inquiry')->findNumberForShourout($typeID, $courseID, $request->get('date'), $statusID);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('value' => $value, 'code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }


    /**
     * send emails through swift-mailer
     * @param Request $request
     * @return JsonResponse
     * @Route("/email",name="send_email")
     */
    public function sendEmail(Request $request)
    {
        $code = 200;
        $message = "Email send Successfully";
        $debug = "";

        try {
            $email = $request->get('email');
            $subject = $request->get('subject');
            $body = $request->get('body');

            $debug .= $email . ", ";

            $message = \Swift_Message::newInstance()//email params are configured in parameters.yml
            ->setSubject($subject)
                //change from address this is temporary
                ->setFrom('noreply@previewvr.xyz')
                //in development version to email address is fixed to delivery_address in config_dev.yml
                ->setTo($email)
                //email body can be rendered using twig, it'll make life easier to customize templates. if time permits that feature should be implemented
                ->setBody($body);
            $this->get('mailer')->send($message);


        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }
}

