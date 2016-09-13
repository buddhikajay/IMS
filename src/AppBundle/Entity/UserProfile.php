<?php

namespace AppBundle\Entity;

/**
 * UserProfile
 */
class UserProfile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $profilePic;


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return UserProfile
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return UserProfile
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return UserProfile
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set profilePic
     *
     * @param string $profilePic
     *
     * @return UserProfile
     */
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * Get profilePic
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }
    /**
     * @var \AppBundle\Entity\User
     */
    private $userId;


    /**
     * Set userId
     *
     * @param \AppBundle\Entity\User $userId
     *
     * @return UserProfile
     */
    public function setUserId(\AppBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \AppBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
