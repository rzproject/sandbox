<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Bundle\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadCollectionData
 *
 * @package Sonata\Bundle\EcommerceDemoBundle\DataFixtures\ORM
 *
 * @author  Hugo Briand <briand@ekino.com>
 */
class LoadContextData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;


    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the Sonata ContextaManager.
     *
     * @return \Sonata\CoreBundle\Model\ManagerInterface
     */
    public function getContextManager()
    {
        return $this->container->get('sonata.classification.manager.context');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $contextManager = $this->getContextManager();

        $context = $contextManager->create();
        $context->setId('default');
        $context->setName('Default');
        $context->setEnabled(true);
        $contextManager->save($context);

        $this->setReference('context-default', $context);

        $context = $contextManager->create();
        $context->setId('post');
        $context->setName('Post');
        $context->setEnabled(true);
        $contextManager->save($context);

        $this->setReference('context-post', $newsContext);

        $context = $contextManager->create();
        $context->setId('user-age-demographics');
        $context->setName('User Age Demographics');
        $context->setEnabled(true);
        $contextManager->save($context);

        $this->setReference('context-user-age-demographics', $context);

        $context = $contextManager->create();
        $context->setId('gallery');
        $context->setName('Gallery');
        $context->setEnabled(true);
        $contextManager->save($context);

        $this->setReference('context-gallery', $newsContext);

        $context = $contextManager->create();
        $context->setId('post-sets');
        $context->setName('Post Sets');
        $context->setEnabled(true);
        $contextManager->save($context);

        $this->setReference('context-post-sets', $newsContext);
    }
}
