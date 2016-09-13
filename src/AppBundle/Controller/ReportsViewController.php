<?php
/**
 * Created by PhpStorm.
 * User: vipula
 * Date: 7/7/2016
 * Time: 3:13 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\InquiryStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Report view controller.
 *
 * @Route("/reports")
 */
class ReportsViewController extends Controller
{

    /**
     * Show Reports
     *
     * @Route("/", name="reports_view")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime('now');

        $dayBeforeAWeek = new \DateTime("now");
        date_modify($dayBeforeAWeek, '-7 days');

        /*
        * Last week summery :New Inquiries
        */

        $weekSummery = $em->getRepository('AppBundle:Inquiry')
            ->countNewInquiriesByTimePeriodGroupedByDate($dayBeforeAWeek, $today);

        $days = array();
        $count = array();
        for ($i = 6; $i >= 0; $i--) {
            $date = new \DateTime('now');
            $date->modify('-' . $i . 'days');
            array_push($days, $date->format('Y-m-d'));
            $found = false;
            foreach ($weekSummery as $day) {
                if ($day['createdDate'] == $date->format('Y-m-d')) {
                    array_push($count, $day['newInq']);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                array_push($count, 0);
            }
        }
        $dailyNewInquiries = array('days' => $days, 'count' => $count);

        /*
        * Last week summery : Conversions
        */
        $weekSummery = $em->getRepository('AppBundle:Inquiry')
            ->countCompletedInquiriesByTimePeriodGroupedByDate($dayBeforeAWeek, $today);

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
        $dailyConversion = array('days' => $days, 'count' => $count);

        /*
        * Last week summery : Inquiry Mode
        */
        $weekSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryMode($dayBeforeAWeek, $today);

        $mode = array();
        $count = array();
        foreach ($weekSummery as $inqMode) {
            array_push($mode, $inqMode['mode']);
            array_push($count, $inqMode['modeCount']);
        }
        $weeklyDistribution = array('mode' => $mode, 'count' => $count);

        /*
        *  Last Month summery : Inquiry Mode
        */
        $dayBeforeAMonth = new \DateTime('now');
        date_modify($dayBeforeAMonth, '-1 month');
        $monthSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryMode($dayBeforeAMonth, $today);

        $mode = array();
        $count = array();
        foreach ($monthSummery as $inqMode) {
            array_push($mode, $inqMode['mode']);
            array_push($count, $inqMode['modeCount']);
        }
        $monthlyDistribution = array('mode' => $mode, 'count' => $count);

        /*
        *  Last year summery : Inquiry Mode
        */
        $dayBeforeAYear = new \DateTime('now');
        date_modify($dayBeforeAYear, '-1 year');
        $annualSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryMode($dayBeforeAYear, $today);

        $mode = array();
        $count = array();
        foreach ($annualSummery as $inqMode) {
            array_push($mode, $inqMode['mode']);
            array_push($count, $inqMode['modeCount']);
        }
        $annualDistribution = array('mode' => $mode, 'count' => $count);

        /*
        *  Overall summery : Inquiry Mode
        */
        $beginningOfTime = new \DateTime('now');
        date_modify($beginningOfTime, '-50 year');
        $overallSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryMode($beginningOfTime, $today);

        $mode = array();
        $count = array();
        foreach ($overallSummery as $inqMode) {
            array_push($mode, $inqMode['mode']);
            array_push($count, $inqMode['modeCount']);
        }
        $overallDistribution = array('mode' => $mode, 'count' => $count);

        /*
       *  Overall summery : Inquiry Mode vs Month
       */
        $beginningOfTime = new \DateTime('now');
        date_modify($beginningOfTime, '-50 year');
        $overallSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryModeAndMonth($beginningOfTime, $today);

        $mode = array();
        $count = array();
        $month = array();
        $year = array();
        foreach ($overallSummery as $inqMode) {
            array_push($mode, $inqMode['mode']);
            array_push($count, $inqMode['modeCount']);
            array_push($month, $inqMode['monthOfCreation']);
            array_push($year, $inqMode['yearOfCreation']);
        }
        $overallDistributionByMonth = array('mode' => $mode, 'count' => $count, 'month' => $month, 'year' => $year);

        /*
        * Last week summery : Course
        */
        $weekSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByCourse($dayBeforeAWeek, $today);

        $courses = array();
        $count = array();
        foreach ($weekSummery as $course) {
            array_push($courses, $course['courseName']);
            array_push($count, $course['courseCount']);
        }
        $weeklyDistributionCourse = array('course' => $courses, 'count' => $count);

        /*
        *  Last Month summery : Course
        */
        $dayBeforeAMonth = new \DateTime('now');
        date_modify($dayBeforeAMonth, '-1 month');
        $monthSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByCourse($dayBeforeAMonth, $today);

        $courses = array();
        $count = array();
        foreach ($monthSummery as $course) {
            array_push($courses, $course['courseName']);
            array_push($count, $course['courseCount']);
        }
        $monthlyDistributionCourse = array('course' => $courses, 'count' => $count);

        /*
        *  Last year summery : Course
        */
        $dayBeforeAYear = new \DateTime('now');
        date_modify($dayBeforeAYear, '-1 year');
        $annualSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByCourse($dayBeforeAYear, $today);

        $courses = array();
        $count = array();
        foreach ($annualSummery as $course) {
            array_push($courses, $course['courseName']);
            array_push($count, $course['courseCount']);
        }
        $annualDistributionCourse = array('course' => $courses, 'count' => $count);

        /*
        *  Overall summery : Course
        */
        $beginningOfTime = new \DateTime('now');
        date_modify($beginningOfTime, '-50 year');
        $overallSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByCourse($beginningOfTime, $today);

        $courses = array();
        $count = array();
        foreach ($overallSummery as $course) {
            array_push($courses, $course['courseName']);
            array_push($count, $course['courseCount']);
        }
        $overallDistributionCourse = array('course' => $courses, 'count' => $count);

        /*
      *  Overall summery : Course vs Month
      */
        $beginningOfTime = new \DateTime('now');
        date_modify($beginningOfTime, '-50 year');
        $overallSummery = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByTimePeriodGroupedByInquiryCourseAndMonth($beginningOfTime, $today);

        $courses = array();
        $count = array();
        $month = array();
        $year = array();
        foreach ($overallSummery as $course) {
            array_push($courses, $course['courseName']);
            array_push($count, $course['courseCount']);
            array_push($month, $course['monthOfCreation']);
            array_push($year, $course['yearOfCreation']);
        }
        $overallDistributionCourseByMonth = array('course' => $courses, 'count' => $count, 'month' => $month, 'year' => $year);

        $inquiryModes = $em->getRepository('AppBundle:InquiryMode')->findAll();
        $allInquiryModes = array();
        foreach ($inquiryModes as $inquiryMode) {
            $allInquiryModes[$inquiryMode->getName()] = array();
        }

        $courses = $em->getRepository('AppBundle:Course')->findAll();
        $allCourses = array();
        foreach ($courses as $course) {
            $allCourses[$course->getName()] = array();
        }

        $profiles = $em->getRepository('AppBundle:UserProfile')->findAll();
        $counselorPerformance = array();
        foreach ($profiles as $profile) {
            $performance = $this->getUserPerformance($profile->getUserId());
            $entry = array(
                'name'        => $profile->getFirstName() . ' ' . $profile->getLastName(),
                'profilePic'  => $profile->getProfilePic(),
                'performance' => $performance
            );
            array_push($counselorPerformance, $entry);
        }

        // @ToDo Grab data from DB and pass to frontend
        return $this->render('custom_views/reports.html.twig', array(
            'dailyNewInquiries'                         => $dailyNewInquiries,
            'dailyConversion'                           => $dailyConversion,
            'weeklyInquiryModeDistribution'             => $weeklyDistribution,
            'monthlyInquiryModeDistribution'            => $monthlyDistribution,
            'annualInquiryModeDistribution'             => $annualDistribution,
            'overallInquiryModeDistribution'            => $overallDistribution,
            'overallInquiryModeDistributionOverMonth'   => $overallDistributionByMonth,
            'weeklyInquiryCourseDistribution'           => $weeklyDistributionCourse,
            'monthlyInquiryCourseDistribution'          => $monthlyDistributionCourse,
            'annualInquiryCourseDistribution'           => $annualDistributionCourse,
            'overallInquiryCourseDistribution'          => $overallDistributionCourse,
            'overallInquiryCourseDistributionOverMonth' => $overallDistributionCourseByMonth,
            'allInquiryModes'                           => $allInquiryModes,
            'allCourses'                                => $allCourses,
            'performance'                               => $counselorPerformance

        ));
    }

    private function getUserPerformance($user)
    {
        $em = $this->getDoctrine()->getManager();

        //pending inquiries
        $inquiryPendingStatus = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => "Pending"
        ));
        $pendingInquiriesNumber = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($inquiryPendingStatus->getId(), $user);

        //completed inquires
        $completedInquiries = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByCompleteStatusAndUserID(InquiryStatus::COMPLETE, $user);

        //following inquiries
        $followingState = $em->getRepository('AppBundle:InquiryStatus')->findOneBy(array(
            'name' => 'Following'
        ));
        $followingInquiries = $em->getRepository('AppBundle:Inquiry')
            ->countInquiriesByStatusAndUser($followingState->getId(), $user);

        //targets
        $target = $em->getRepository('AppBundle:Target')->findBy(array(
            'councellor' => $user
        ));

        $targets = [];

        $currentTarget = null;
        $previousEndDate = new \DateTime("now");
        $today = new \DateTime("now");
        foreach ($target as $tg) {

            if ($tg->getEndDate() > $today) {
                array_push($targets, $tg);

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
                ->countCompletedInquiriesByUserAndTimePeriod($currentTarget->getStartDate(), $today, $user);
        }
        $percentage = round($achievedTarget * 100 / $currentTargetSize);

        $performance = array(
            'pending'    => $pendingInquiriesNumber,
            'following'  => $followingInquiries,
            'complete'   => $completedInquiries,
            'target'     => $currentTargetSize,
            'achieved'   => $achievedTarget,
            'percentage' => $percentage
        );

        return $performance;
    }
}

