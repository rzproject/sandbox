<?php

/*
 * This file is part of the RzAdminBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\AdminBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class OverrideCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        //override admin pool class
        if($container->hasParameter('rz.admin.pool.base_admin.class'))  {
            $definition = $container->getDefinition('sonata.admin.pool');
            $definition->setClass($container->getParameter('rz.admin.pool.base_admin.class'));
            //add rz bundle options
            if($container->hasParameter('rz.admin.options.use_footable') && $container->hasParameter('rz.admin.settings.footable')) {
                $definition->addMethodCall('setOption', array('use_footable', $container->getParameter('rz.admin.options.use_footable')));
                $definition->addMethodCall('setOption', array('footable_settings', $container->getParameter('rz.admin.settings.footable')));
            }
        }
    }
}
