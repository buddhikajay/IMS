<?php

namespace AppBundle\Entity;

/**
 * Target
 */
class Target
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
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @var int
     */
    private $amount;


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
     * @return Target
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
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Target
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Target
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Target
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * @var \AppBundle\Entity\User
     */
    private $councellor;

    /**
     * @var \AppBundle\Entity\User
     */
    private $assigner;


    /**
     * Set councellor
     *
     * @param \AppBundle\Entity\User $councellor
     *
     * @return Target
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
     * @return Target
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
