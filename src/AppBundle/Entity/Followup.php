<?php

namespace AppBundle\Entity;

/**
 * Followup
 */
class Followup
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
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $description;


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
     * @return Followup
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
     * Set action
     *
     * @param string $action
     *
     * @return Followup
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Followup
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var \AppBundle\Entity\Inquiry
     */
    private $inquiry;

    /**
     * @var \AppBundle\Entity\User
     */
    private $concellor;


    /**
     * Set inquiry
     *
     * @param \AppBundle\Entity\Inquiry $inquiry
     *
     * @return Followup
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
     * Set concellor
     *
     * @param \AppBundle\Entity\User $concellor
     *
     * @return Followup
     */
    public function setConcellor(\AppBundle\Entity\User $concellor = null)
    {
        $this->concellor = $concellor;

        return $this;
    }

    /**
     * Get concellor
     *
     * @return \AppBundle\Entity\User
     */
    public function getConcellor()
    {
        return $this->concellor;
    }
}
