<?php

namespace AppBundle\Entity\OAuthServer;

use Rz\OAuthServerBundle\Entity\BaseAuthCode;

class AuthCode extends BaseAuthCode
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}
