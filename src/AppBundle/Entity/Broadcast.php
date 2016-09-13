<?php

namespace AppBundle\Entity;

/**
 * Broadcast
 */
class Broadcast
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $criteria;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var int
     */
    private $sentCount;

    /**
     * @var int
     */
    private $deliveredCount;


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
     * Set action
     *
     * @param string $action
     *
     * @return Broadcast
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
     * @return Broadcast
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
     * Set name
     *
     * @param string $name
     *
     * @return Broadcast
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set criteria
     *
     * @param string $criteria
     *
     * @return Broadcast
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * Get criteria
     *
     * @return string
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Broadcast
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
     * Set sentCount
     *
     * @param integer $sentCount
     *
     * @return Broadcast
     */
    public function setSentCount($sentCount)
    {
        $this->sentCount = $sentCount;

        return $this;
    }

    /**
     * Get sentCount
     *
     * @return int
     */
    public function getSentCount()
    {
        return $this->sentCount;
    }

    /**
     * Set deliveredCount
     *
     * @param integer $deliveredCount
     *
     * @return Broadcast
     */
    public function setDeliveredCount($deliveredCount)
    {
        $this->deliveredCount = $deliveredCount;

        return $this;
    }

    /**
     * Get deliveredCount
     *
     * @return int
     */
    public function getDeliveredCount()
    {
        return $this->deliveredCount;
    }
}
