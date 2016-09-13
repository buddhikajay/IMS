<?php

namespace AppBundle\Entity;

/**
 * Inquiry
 */
class Inquiry
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $semester;

    /**
     * @var int
     */
    private $probability;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var \DateTime
     */
    private $created;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Inquiry
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set semester
     *
     * @param integer $semester
     *
     * @return Inquiry
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * Get semester
     *
     * @return int
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set probability
     *
     * @param integer $probability
     *
     * @return Inquiry
     */
    public function setProbability($probability)
    {
        $this->probability = $probability;

        return $this;
    }

    /**
     * Get probability
     *
     * @return int
     */
    public function getProbability()
    {
        return $this->probability;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     *
     * @return Inquiry
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Inquiry
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    /**
     * @var \AppBundle\Entity\Person
     */
    private $person;


    /**
     * Set person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return Inquiry
     */
    public function setPerson(\AppBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \AppBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
    /**
     * @var \AppBundle\Entity\Course
     */
    private $course;

    /**
     * @var \AppBundle\Entity\InquiryMode
     */
    private $inquiryMode;

    /**
     * @var \AppBundle\Entity\InquiryStatus
     */
    private $inquiryStatus;

    /**
     * @var \AppBundle\Entity\User
     */
    private $counsellor;


    /**
     * Set course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return Inquiry
     */
    public function setCourse(\AppBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \AppBundle\Entity\Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set inquiryMode
     *
     * @param \AppBundle\Entity\InquiryMode $inquiryMode
     *
     * @return Inquiry
     */
    public function setInquiryMode(\AppBundle\Entity\InquiryMode $inquiryMode = null)
    {
        $this->inquiryMode = $inquiryMode;

        return $this;
    }

    /**
     * Get inquiryMode
     *
     * @return \AppBundle\Entity\InquiryMode
     */
    public function getInquiryMode()
    {
        return $this->inquiryMode;
    }

    /**
     * Set inquiryStatus
     *
     * @param \AppBundle\Entity\InquiryStatus $inquiryStatus
     *
     * @return Inquiry
     */
    public function setInquiryStatus(\AppBundle\Entity\InquiryStatus $inquiryStatus = null)
    {
        $this->inquiryStatus = $inquiryStatus;

        return $this;
    }

    /**
     * Get inquiryStatus
     *
     * @return \AppBundle\Entity\InquiryStatus
     */
    public function getInquiryStatus()
    {
        return $this->inquiryStatus;
    }

    /**
     * Set counsellor
     *
     * @param \AppBundle\Entity\User $counsellor
     *
     * @return Inquiry
     */
    public function setCounsellor(\AppBundle\Entity\User $counsellor = null)
    {
        $this->counsellor = $counsellor;

        return $this;
    }

    /**
     * Get counsellor
     *
     * @return \AppBundle\Entity\User
     */
    public function getCounsellor()
    {
        return $this->counsellor;
    }
}
