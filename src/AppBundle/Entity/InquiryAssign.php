<?php

namespace AppBundle\Entity;

/**
 * InquiryAssign
 */
class InquiryAssign
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $timestamp;


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
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return InquiryAssign
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
    /**
     * @var \AppBundle\Entity\Inquiry
     */
    private $inquiry;

    /**
     * @var \AppBundle\Entity\User
     */
    private $councellor;

    /**
     * @var \AppBundle\Entity\User
     */
    private $assigner;


    /**
     * Set inquiry
     *
     * @param \AppBundle\Entity\Inquiry $inquiry
     *
     * @return InquiryAssign
     */
    public function setInquiry(\AppBundle\Entity\Inquiry $inquiry = null)
    {
        $this->inquiry = $inquiry;

        return $this;
    }

    /**
     * Get inquiry
     *
     * @return \AppBundle\Entity\Inquiry
     */
    public function getInquiry()
    {
        return $this->inquiry;
    }

    /**
     * Set councellor
     *
     * @param \AppBundle\Entity\User $councellor
     *
     * @return InquiryAssign
     */
    public function setCouncellor(\AppBundle\Entity\User $councellor = null)
    {
        $this->councellor = $councellor;

        return $this;
    }

    /**
     * Get councellor
     *
     * @return \AppBundle\Entity\User
     */
    public function getCouncellor()
    {
        return $this->councellor;
    }

    /**
     * Set assigner
     *
     * @param \AppBundle\Entity\User $assigner
     *
     * @return InquiryAssign
     */
    public function setAssigner(\AppBundle\Entity\User $assigner = null)
    {
        $this->assigner = $assigner;

        return $this;
    }

    /**
     * Get assigner
     *
     * @return \AppBundle\Entity\User
     */
    public function getAssigner()
    {
        return $this->assigner;
    }
}
