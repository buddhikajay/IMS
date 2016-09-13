<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var int
     */
    protected $id;


    protected $groups;

    /**
     * User Roles constants
     */
    const ROLE_COUNSELOR = 1;
    const ROLE_DIRECTOR = 2;
    const ROLE_MANAGER = 3;
    const ROLE_SAR = 4;
    const ROLE_ADMIN = 5;

}
