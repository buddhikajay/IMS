<?php

namespace AppBundle\Entity;

/**
 * Offer
 */
class Offer
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
     * @var bool
     */
    private $opened;

    /**
     * @var bool
     */
    private $accepted;


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
     * @return Offer
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
     * Set opened
     *
     * @param boolean $opened
     *
     * @return Offer
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }

    /**
     * Get opened
     *
     * @return bool
     */
    public function getOpened()
    {
        return $this->opened;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Offer
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted()
    {
        return $this->accepted;
    }
    /**
     * @var \AppBundle\Entity\Inquiry
     */
    private $inquiry;


    /**
     * Set inquiry
     *
     * @param \AppBundle\Entity\Inquiry $inquiry
     *
     * @return Offer
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
}
