<?php

namespace AppBundle\Entity\OAuthServer;

use Rz\OAuthServerBundle\Entity\BaseRefreshToken;

class RefreshToken extends BaseRefreshToken
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
