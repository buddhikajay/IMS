<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserProfile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Base controller.
 *
 * @Route("/base")
 */
class BaseController extends Controller
{
    /**
     * Gets data for Base
     *
     * @Route("/baseData", name="base_data")
     * @Method("GET")
     */
    public function getBaseDataAction()
    {
        $em = $this->getDoctrine()->getManager();
        $counselor = $this->get('security.token_storage')->getToken()->getUser();

        //pending inquiries
        $inquiryPendingStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => "Pending"
        ));
        $pendingInquiriesNumber = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($inquiryPendingStatus->getId(), $counselor->getId());

        $followingState = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => 'Following'
        ));
        $followingInquiries = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($followingState->getId(), $counselor->getId());

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $profile = $em->getRepository('AppBundle:UserProfile')->findOneBy(array('userId' => $user));

        if ($profile == null)
            $profile = new UserProfile();

        return new JsonResponse(array(
            'pending'    => $pendingInquiriesNumber,
            'following'  => $followingInquiries,
            'profilePic' => $profile->getProfilePic()
        ));
    }
}
