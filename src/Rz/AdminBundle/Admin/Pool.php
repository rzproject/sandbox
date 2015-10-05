<?php

namespace Rz\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Pool as BasePool;

class Pool extends BasePool
{
    public function setOption($name, $value) {
            $this->options[$name] = $value;
    }
}
