<?php

namespace AppBundle\Entity;

/**
 * Person
 */
class Person
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nic;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $school;

    /**
     * @var string
     */
    private $district;

    /**
     * @var string
     */
    private $olEnglish;

    /**
     * @var string
     */
    private $olMaths;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $alGrades;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var \DateTime
     */
    private $availableTime;

    /**
     * @var string
     */
    private $eduQualification;

    /**
     * @var string
     */
    private $workExperience;


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
     * Set nic
     *
     * @param string $nic
     *
     * @return Person
     */
    public function setNic($nic)
    {
        $this->nic = $nic;

        return $this;
    }

    /**
     * Get nic
     *
     * @return string
     */
    public function getNic()
    {
        return $this->nic;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Person
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Person
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set school
     *
     * @param string $school
     *
     * @return Person
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set district
     *
     * @param string $district
     *
     * @return Person
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set olEnglish
     *
     * @param string $olEnglish
     *
     * @return Person
     */
    public function setOlEnglish($olEnglish)
    {
        $this->olEnglish = $olEnglish;

        return $this;
    }

    /**
     * Get olEnglish
     *
     * @return string
     */
    public function getOlEnglish()
    {
        return $this->olEnglish;
    }

    /**
     * Set olMaths
     *
     * @param string $olMaths
     *
     * @return Person
     */
    public function setOlMaths($olMaths)
    {
        $this->olMaths = $olMaths;

        return $this;
    }

    /**
     * Get olMaths
     *
     * @return string
     */
    public function getOlMaths()
    {
        return $this->olMaths;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Person
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set alGrades
     *
     * @param array $alGrades
     *
     * @return Person
     */
    public function setAlGrades($alGrades)
    {
        $this->alGrades = $alGrades;

        return $this;
    }

    /**
     * Get alGrades
     *
     * @return array
     */
    public function getAlGrades()
    {
        return $this->alGrades;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return Person
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set availableTime
     *
     * @param \DateTime $availableTime
     *
     * @return Person
     */
    public function setAvailableTime($availableTime)
    {
        $this->availableTime = $availableTime;

        return $this;
    }

    /**
     * Get availableTime
     *
     * @return \DateTime
     */
    public function getAvailableTime()
    {
        return $this->availableTime;
    }

    /**
     * Set eduQualification
     *
     * @param string $eduQualification
     *
     * @return Person
     */
    public function setEduQualification($eduQualification)
    {
        $this->eduQualification = $eduQualification;

        return $this;
    }

    /**
     * Get eduQualification
     *
     * @return string
     */
    public function getEduQualification()
    {
        return $this->eduQualification;
    }

    /**
     * Set workExperience
     *
     * @param string $workExperience
     *
     * @return Person
     */
    public function setWorkExperience($workExperience)
    {
        $this->workExperience = $workExperience;

        return $this;
    }

    /**
     * Get workExperience
     *
     * @return string
     */
    public function getWorkExperience()
    {
        return $this->workExperience;
    }
    /**
     * @var string
     */
    private $street1;

    /**
     * @var string
     */
    private $street2;

    /**
     * @var string
     */
    private $city;


    /**
     * Set street1
     *
     * @param string $street1
     *
     * @return Person
     */
    public function setStreet1($street1)
    {
        $this->street1 = $street1;

        return $this;
    }

    /**
     * Get street1
     *
     * @return string
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Set street2
     *
     * @param string $street2
     *
     * @return Person
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Get street2
     *
     * @return string
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Person
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Person
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
}
