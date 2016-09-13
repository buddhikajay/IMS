<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Inquiry view controller.
 *
 * @Route("/inquirymanagement")
 */
class InquiryManagementViewController extends Controller{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="inquirymanagement_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $inquiryUnassignedStatusID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'code' => "UnA"
        ));

        $inquiryBulkModeID = $em->getRepository('AppBundle:InquiryMode')->findOneBy(array(
            'code' => "bulk"
        ));

        $queryUnassignedInquiries = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.inquiryStatus=".$inquiryUnassignedStatusID->getId()." AND u.inquiryMode !=".$inquiryBulkModeID->getId());
        $unassignedInquiries = $queryUnassignedInquiries->getResult();

        $queryUnassignedInquiriesNumber = $em->createQuery("SELECT COUNT(u) as unassigned_number, u.id FROM AppBundle:Inquiry u WHERE u.inquiryStatus=".$inquiryUnassignedStatusID->getId()." AND u.inquiryMode !=".$inquiryBulkModeID->getId());
        $unassignedInquiriesNumber = $queryUnassignedInquiriesNumber->getResult();

        $queryUnassignedBulkNumber = $em->createQuery("SELECT COUNT(u) as unassigned_number, u.id FROM AppBundle:Inquiry u WHERE u.inquiryStatus=".$inquiryUnassignedStatusID->getId()." AND u.inquiryMode =".$inquiryBulkModeID->getId());
        $unassignedBulkNumber = $queryUnassignedBulkNumber->getResult();

        $qb = $em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'."ROLE_COUNSELOR".'"%');
        $counsellors = $qb->getQuery()->getResult();

        return $this->render('custom_views/inquirymanagement.html.twig',array(
            'unassignedInquiriesNumber' => $unassignedInquiriesNumber,
            'unassignedInquiries' => $unassignedInquiries,
            'unassignedBulkNumber' => $unassignedBulkNumber,
            'counsellors' => $counsellors
        ));
    }

    /**
     * assign inquiry
     * @Route("/assign/inquiry",name="assign_inquiry")
     * @Method("POST")
     */

    public function assignInquiryAction(Request $request)
    {
        $code = 200;
        $message = "Followup created successfully";
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $inquiries = $request->get('selected');
            foreach ($inquiries as $inq){
                $inquiry = $em->getRepository('AppBundle:Inquiry')->find($inq);
                $counselor = $em->getRepository('AppBundle:User')->findOneBy(array(
                    'username' => $request->get('counselor')
                ));
                $status = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                    'name' => 'Pending'
                ));

                $inquiry->setCounsellor($counselor);
                $inquiry->setInquiryStatus($status);

                $em->persist($inquiry);
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
     * assign inquiry
     * @Route("/assign/bulk",name="assign_bulk")
     * @Method("POST")
     */

    public function assignBulkAction(Request $request)
    {
        $code = 200;
        $message = "Followup created successfully";
        $debug = "";

        try {
            $em = $this->getDoctrine()->getManager();
            $inquiryUnassignedStatusID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                'code' => "UnA"
            ));
            $inquiryPendingStatusID = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
                'name' => "Pending"
            ));

            $inquiryBulkModeID = $em->getRepository('AppBundle:InquiryMode')->findOneBy(array(
                'code' => "bulk"
            ));
            $queryUnassignedBulk = $em->createQuery("SELECT u FROM AppBundle:Inquiry u WHERE u.inquiryStatus=".$inquiryUnassignedStatusID->getId()." AND u.inquiryMode =".$inquiryBulkModeID->getId());
            $unassignedBulk = $queryUnassignedBulk->getResult();

            $counselor = $em->getRepository('AppBundle:User')->findOneBy(array(
                'username' => $request->get('counselor')
            ));

            for ($x = 0; $x < $request->get('amount'); $x++) {
                $unassignedBulk[$x]->setCounsellor($counselor);
                $unassignedBulk[$x]->setInquiryStatus($inquiryPendingStatusID);
                //$debug .= $x." ".$unassignedBulk[$x].getCounsellor()->getUsername()." ".$counselor->getUsername();
                $em->persist($unassignedBulk[$x]);
                $em->flush();
            }


        } catch (\Exception $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
        } finally {
            return new JsonResponse(array('code' => $code, 'message' => $message, 'debug' => $debug));
        }
    }

}

