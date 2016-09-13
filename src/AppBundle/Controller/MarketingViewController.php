<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Course;
use AppBundle\Entity\Inquiry;
use AppBundle\Entity\InquiryStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Marketing View controller.
 *
 * @Route("/dashboard")
 */
class MarketingViewController extends Controller
{

    /**
     * Lists all ALSubject entities.
     *
     * @Route("/", name="marketing_dashboard")
     * @Method("GET")
     */
    public function indexAction()
    {
        $debug = "";
        $em = $this->getDoctrine()->getManager();
        $counselor = $this->get('security.token_storage')->getToken()->getUser();

        //pending inquiries
        $inquiryPendingStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => "Pending"
        ));
        $pendingInquiriesNumber = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($inquiryPendingStatus->getId(), $counselor->getId());

        //completed inquries
        $completedInquiries = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByCompleteStatusAndUserID(InquiryStatus::COMPLETE, $counselor->getId());

        //following inquiries
        $followingState = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => 'Following'
        ));
        $followingInquiries = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($followingState->getId(), $counselor->getId());

        //targets
        $target = $em->getRepository('AppBundle:Target')->findBy(array(
            'councellor' => $counselor->getId()
        ));

        $targets = [];

        $currentTarget = null;
        $previousEndDate = new \DateTime("now");
        $today = new \DateTime("now");
        foreach ($target as $tg) {

            if ($tg->getEndDate() > $today) {
                array_push($targets, $tg);
                $debug .= $tg->getAmount() . " ";

                if ($tg->getEndDate() > $previousEndDate && $tg->getStartDate() <= $today) {
                    $currentTarget = $tg;
                }
            }
            $previousEndDate = $tg->getEndDate();
        }

        $currentTargetSize = 0;
        if ($currentTarget != null) {
            $currentTargetSize = $currentTarget->getAmount();
        }

        $achievedTarget = 0;
        if ($currentTarget != null) {
            $achievedTarget = $em->getRepository('AppBundle:Inquiry')
                ->countCompletedInquiriesByUserAndTimePeriod($currentTarget->getStartDate(), $today, $counselor->getId());
        }

        /*
         * Course summery
         */
        $courses = $em->getRepository('AppBundle:Course')->findAll();
        $courseSummery = array();

        foreach ($courses as $course) {
            $completed = $em->getRepository('AppBundle:Inquiry')
                ->countCompletedInquiriesByCourseAndUserID($course->getId(), $counselor->getId());
            array_push($courseSummery, array('name' => $course->getName(), 'count' => $completed));
        }

        /*
         * Last week summery
         */
        $dayBeforeAWeek = new \DateTime("now");
        date_modify($dayBeforeAWeek, '-7 days');
        $weekSummery = $em->getRepository('AppBundle:Inquiry')->countCompletedInquiriesByUserAndTimePeriodGroupedByDate($counselor->getId(), $dayBeforeAWeek, $today);

        $days = array();
        $count = array();
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('now');
            $date->modify('-' . $i . 'days');
            array_push($days, $date->format('Y-m-d'));
            $found = false;
            foreach ($weekSummery as $day) {
                if ($day['modifiedDate'] == $date->format('Y-m-d')) {
                    array_push($count, $day['completed']);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                array_push($count, 0);
            }
        }

        $summeryGraph = array('days' => $days, 'count' => $count);

        return $this->render('custom_views/marketing_dashboard.html.twig', array(
            'pendingInquiriesNumber'   => $pendingInquiriesNumber,
            'followingInquiriesNumber' => $followingInquiries,
            'completeInquiriesNumber'  => $completedInquiries,
            'targets'                  => $targets,
            'currentTarget'            => $currentTargetSize,
            'achieved'                 => $achievedTarget,
            'coursesSummery'           => $courseSummery,
            'weekSummery'              => $summeryGraph

        ));
    }
}

