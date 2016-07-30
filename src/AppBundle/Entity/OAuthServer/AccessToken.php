<?php

namespace AppBundle\Entity\OAuthServer;

use Rz\OAuthServerBundle\Entity\BaseAccessToken;

class AccessToken extends BaseAccessToken
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
