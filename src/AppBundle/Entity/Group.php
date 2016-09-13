<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
/**
 * Tmp
 */
class Group extends BaseGroup
{
    /**
     * @var int
     */
    protected $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    // @todo  to get list of registered role --> $roles = $this->get('security.role_hierarchy')
}
