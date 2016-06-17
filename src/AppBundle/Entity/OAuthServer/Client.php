<?php

namespace AppBundle\Entity\OAuthServer;

use Rz\OAuthServerBundle\Entity\BaseClient;

class Client extends BaseClient
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