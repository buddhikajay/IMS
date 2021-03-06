<?php

namespace AppBundle\Repository;

use Proxies\__CG__\AppBundle\Entity\InquiryStatus;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * InquiryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InquiryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * count number of inquiries based on user and status
     *
     * @param $status (1=> complete, 0=>incomplete)
     * @param $userId
     *
     * @return int count
     */
    public function countInquiriesByCompleteStatusAndUserID($status, $userId)
    {
        $ret = 0;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id)')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->where('status.complete=:status')
                ->andWhere('inquiry.counsellor=:user')
                ->setParameter('status', $status)
                ->setParameter('user', $userId)
                ->getQuery();
            $ret = $query->getSingleScalarResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    public function getEmails($type, $course, $date, $status)
    {
        $ret = null;
        try {
            //$ret .= $type . " " . $course . " " . $status. ' ';
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('person.email')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.person', 'person')
                ->where('(:type IS NULL) OR (inquiry.inquiryMode=:type)')
                ->andWhere('(:course IS NULL) OR (inquiry.course=:course)')
                ->andWhere('(:status IS NULL) OR (inquiry.inquiryStatus=:status)')
                ->setParameter('type', $type)
                ->setParameter('course', $course)
                ->setParameter('status', $status)
                ->getQuery();
            //$ret .= $query->getDQL();
            $ret = $query->getResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    public function getPhoneNumbers($type, $course, $date, $status)
    {
        $ret = null;
        try {
            //$ret .= $type . " " . $course . " " . $status. ' ';
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('person.telephone')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.person', 'person')
                ->where('(:type IS NULL) OR (inquiry.inquiryMode=:type)')
                ->andWhere('(:course IS NULL) OR (inquiry.course=:course)')
                ->andWhere('(:status IS NULL) OR (inquiry.inquiryStatus=:status)')
                ->setParameter('type', $type)
                ->setParameter('course', $course)
                ->setParameter('status', $status)
                ->getQuery();
            //$ret .= $query->getDQL();
            $ret = $query->getResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * @param $type
     * @param $course
     * @param $date
     * @param $status
     *
     * @return int|mixed
     */
    public function findNumberForShourout($type, $course, $date, $status)
    {
        $ret = 0;
        try {
            //$ret .= $type . " " . $course . " " . $status. ' ';
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id)')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->where('(:type IS NULL) OR (inquiry.inquiryMode=:type)')
                ->andWhere('(:course IS NULL) OR (inquiry.course=:course)')
                ->andWhere('(:status IS NULL) OR (inquiry.inquiryStatus=:status)')
                ->setParameter('type', $type)
                ->setParameter('course', $course)
                ->setParameter('status', $status)
                ->getQuery();
            //$ret .= $query->getDQL();
            $ret = $query->getSingleScalarResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count number of inquiries by the status code and userID
     *
     * @param $status
     * @param $userID
     *
     * @return int
     */
    public function countInquiriesByStatusAndUser($status, $userID)
    {
        $ret = 0;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id)')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->where('inquiry.inquiryStatus=:status')
                ->andWhere('inquiry.counsellor=:user')
                ->setParameter('status', $status)
                ->setParameter('user', $userID)
                ->getQuery();

            $ret = $query->getSingleScalarResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count completed inquiries by given user in given time period
     *
     * @param $startDate
     * @param $endDate
     * @param $userId
     *
     * @return int
     */
    public function countCompletedInquiriesByUserAndTimePeriod($startDate, $endDate, $userId)
    {
        $ret = 0;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id)')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->where('status.complete=:status')
                ->andWhere('inquiry.counsellor=:user')
                ->andWhere('inquiry.lastModified<:endDate')
                ->andWhere('inquiry.lastModified>:startDate')
                ->setParameter('status', InquiryStatus::COMPLETE)
                ->setParameter('user', $userId)
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getSingleScalarResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count Completed Inquiries by course and user
     *
     * @param $course
     * @param $userId
     *
     * @return int
     */
    public function countCompletedInquiriesByCourseAndUserID($course, $userId)
    {
        $ret = 0;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id)')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->where('status.complete=:status')
                ->andWhere('inquiry.counsellor=:user')
                ->andWhere('inquiry.course=:course')
                ->setParameter('status', InquiryStatus::COMPLETE)
                ->setParameter('course', $course)
                ->setParameter('user', $userId)
                ->getQuery();
            $ret = $query->getSingleScalarResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count completed inquiries of user in given time period, group by the day of completion
     *
     * @param $userId
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countCompletedInquiriesByUserAndTimePeriodGroupedByDate($userId, $startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as completed')
                ->addSelect('date(inquiry.lastModified) AS modifiedDate')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->where('status.complete=:status')
                ->andWhere('inquiry.counsellor=:user')
                ->andWhere('inquiry.lastModified<:endDate')
                ->andWhere('inquiry.lastModified>:startDate')
                ->groupBy('modifiedDate')
                ->setParameter('status', InquiryStatus::COMPLETE)
                ->setParameter('user', $userId)
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count new inquiries  in given time period, group by the day of creation
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countNewInquiriesByTimePeriodGroupedByDate($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as newInq')
                ->addSelect('date(inquiry.created) AS createdDate')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->andWhere('inquiry.created<:endDate')
                ->andWhere('inquiry.created>:startDate')
                ->groupBy('createdDate')
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count completed inquiries in given time period, group by the day of completion
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countCompletedInquiriesByTimePeriodGroupedByDate($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as completed')
                ->addSelect('date(inquiry.lastModified) AS modifiedDate')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->where('status.complete=:status')
                ->andWhere('inquiry.lastModified<:endDate')
                ->andWhere('inquiry.lastModified>:startDate')
                ->groupBy('modifiedDate')
                ->setParameter('status', InquiryStatus::COMPLETE)
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count inquiries in given time period, group by inquiryMode
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countInquiriesByTimePeriodGroupedByInquiryMode($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as modeCount')
                ->addSelect('inquiryMode.name as mode')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryMode', 'inquiryMode')
                ->andWhere('inquiry.created<:endDate')
                ->andWhere('inquiry.created>:startDate')
                ->groupBy('inquiry.inquiryMode')
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count inquiries in given time period, group by course
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countInquiriesByTimePeriodGroupedByCourse($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as courseCount')
                ->addSelect('course.name as courseName')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.course', 'course')
                ->andWhere('inquiry.created<:endDate')
                ->andWhere('inquiry.created>:startDate')
                ->andWhere('inquiry.course is not null')
                ->groupBy('inquiry.course')
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count inquiries in given time period, group by month-year and mode
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countInquiriesByTimePeriodGroupedByInquiryModeAndMonth($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as modeCount')
                ->addSelect('inquiryMode.name as mode')
                ->addSelect('month(inquiry.created) as monthOfCreation')
                ->addSelect('year(inquiry.created) as yearOfCreation')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryMode', 'inquiryMode')
                ->andWhere('inquiry.created<:endDate')
                ->andWhere('inquiry.created>:startDate')
                ->groupBy('inquiry.inquiryMode')
                ->addGroupBy('monthOfCreation')
                ->addGroupBy('yearOfCreation')
                ->orderBy('yearOfCreation')
                ->addOrderBy('monthOfCreation')
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    /**
     * Count inquiries in given time period, group by month-year and course
     *
     * @param $startDate
     * @param $endDate
     *
     * @return array|null
     */
    public function countInquiriesByTimePeriodGroupedByInquiryCourseAndMonth($startDate, $endDate)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as courseCount')
                ->addSelect('course.name as courseName')
                ->addSelect('month(inquiry.created) as monthOfCreation')
                ->addSelect('year(inquiry.created) as yearOfCreation')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.course', 'course')
                ->andWhere('inquiry.created<:endDate')
                ->andWhere('inquiry.created>:startDate')
                ->andWhere('inquiry.course is not null')
                ->groupBy('inquiry.course')
                ->addGroupBy('monthOfCreation')
                ->addGroupBy('yearOfCreation')
                ->orderBy('yearOfCreation')
                ->addOrderBy('monthOfCreation')
                ->setParameter('endDate', $endDate)
                ->setParameter('startDate', $startDate)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }

    public function counselorPerformance($state)
    {
        $ret = null;
        try {
            $query = $this->getEntityManager()
                ->createQueryBuilder()
                ->select('count(inquiry.id) as inquiryCount')
                ->addSelect('profile.firstName as firstName')
                ->addSelect('profile.lastName as lastName')
                ->from('AppBundle:Inquiry', 'inquiry')
                ->leftJoin('inquiry.inquiryStatus', 'status')
                ->leftJoin('inquiry.counsellor', 'user')
                ->leftJoin('user.profile', 'profile')
                ->andWhere('inquiry.inquiryStatus=:status')
                ->groupBy('inquiry.counsellor')
                ->setParameter('status', $state)
                ->getQuery();

            $ret = $query->getResult();
        } catch (\Exception $e) {
        } finally {
            return $ret;
        }
    }
}
