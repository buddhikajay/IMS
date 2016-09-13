<?php

namespace AppBundle\Entity;

/**
 * BulkFile
 */
class BulkFile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var array
     */
    private $columnMapping;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var bool
     */
    private $complete;


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
     * Set filePath
     *
     * @param string $filePath
     *
     * @return BulkFile
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set columnMapping
     *
     * @param array $columnMapping
     *
     * @return BulkFile
     */
    public function setColumnMapping($columnMapping)
    {
        $this->columnMapping = $columnMapping;

        return $this;
    }

    /**
     * Get columnMapping
     *
     * @return array
     */
    public function getColumnMapping()
    {
        return $this->columnMapping;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return BulkFile
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
     * Set complete
     *
     * @param boolean $complete
     *
     * @return BulkFile
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;

        return $this;
    }

    /**
     * Get complete
     *
     * @return bool
     */
    public function getComplete()
    {
        return $this->complete;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return BulkFile
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
     * @var boolean
     */
    private $headers;


    /**
     * Set headers
     *
     * @param boolean $headers
     *
     * @return BulkFile
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get headers
     *
     * @return boolean
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
