<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\InquiryStatus;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Person;
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
 * @Route("/admissions")
 */
class AdmissionViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="admissions_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->isGranted('ROLE_SAR')) {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();

        $directAdmissionID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'code' => "DAd"
        ));
        $queryDirectAdmission = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.inquiryStatus=" . $directAdmissionID->getId());
        $directAdmissions = $queryDirectAdmission->getResult();

        $inquiryAdmissionID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'code' => "InqAd"
        ));
        $queryInquiryAdmission = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.inquiryStatus=" . $inquiryAdmissionID->getId());
        $inquiryAdmissions = $queryInquiryAdmission->getResult();

        $customEmails = $em->getRepository('AppBundle:CustomEmail')->findAll();

        $alsub = $em->getRepository('AppBundle:ALSubject')->findAll();

        return $this->render('custom_views/admissions.html.twig', array(
            'directAdmissions'  => $directAdmissions,
            'inquiryAdmissions' => $inquiryAdmissions,
            'customEmails'      => $customEmails,
            'alSubjects'        => $alsub
        ));
    }

    /**
     * Grab User profile data
     *
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/grabdata",name="grab_person")
     * @Method("POST")
     */
    public function grabUserData(Request $request)
    {
        $code = 200;
        $message = "Course Updated Successfully";
        $debug = "";
        $person = new Person();
        $serializedPerson = "";
        try {
            $em = $this->getDoctrine()->getManager();
            $person = $em->getRepository('AppBundle:Person')->find($request->get('id'));

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());

            $serializer = new Serializer($normalizers, $encoders);
            $serializedPerson = $serializer->serialize($person, 'json');
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug, 'person' => $serializedPerson));
        }
    }

    /**
     * Create new Admission
     *
     *
     * @Route("/admission/new",name="new_admission")
     * @Method("POST")
     */
    public function newAdmissionAction(Request $request)
    {
        $code = 200;
        $message = "Course Updated Successfully";
        $debug = "";
        $offer = new Offer();
        try {
            $em = $this->getDoctrine()->getManager();
            $offer->setTimestamp(new \DateTime('now'));

            $inquiry = $em->getRepository('AppBundle:Inquiry')->find($request->get('inquiry'));

            $inquiryStatus = new InquiryStatus();
            if ($request->get('type') == 'inq') {
                $inquiryStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                    'code' => 'IOS'
                ));
            } else if ($request->get('type') == 'direct') {
                $inquiryStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                    'code' => 'DOS'
                ));
            }

            $inquiry->setInquiryStatus($inquiryStatus);
            $em->persist($inquiry);
            $em->flush();

            $offer->setInquiry($inquiry);
            $offer->setAccepted(false);
            $offer->setOpened(false);
            $debug .= $request->get('inquiry');
            $em->persist($offer);
            $em->flush();
        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

}

