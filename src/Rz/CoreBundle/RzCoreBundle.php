<?php

namespace Rz\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RzCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataCoreBundle';
    }
}
