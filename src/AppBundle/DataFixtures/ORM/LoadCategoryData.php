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
 * Category fixtures loader.
 *
 * @author Sylvain Deloux <sylvain.deloux@ekino.com>
 */
class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 2;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Returns the Sonata MediaManager.
     *
     * @return \Sonata\CoreBundle\Model\ManagerInterface
     */
    public function getCategoryManager()
    {
        return $this->container->get('sonata.classification.manager.category');
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $context = $this->getReference('context-default');
        $category = $this->getCategoryManager()->create();
        $category->setName('Default');
        $category->setSlug('default');
        $category->setEnabled(true);
        $category->setContext($context);

        $this->setReference('category-default', $category);
        $this->getCategoryManager()->save($category);

        $context = $this->getReference('context-post');
        $category = $this->getCategoryManager()->create();
        $category->setName('Post');
        $category->setSlug('post');
        $category->setEnabled(true);
        $category->setContext($context);

        $this->setReference('category-post', $category);
        $this->getCategoryManager()->save($category);


        $context = $this->getReference('context-user-age-demographics');
        $category = $this->getCategoryManager()->create();
        $category->setName('User Age Demographics');
        $category->setSlug('user-age-demographics');
        $category->setEnabled(true);
        $category->setContext($context);

        $this->setReference('category-user-age-demographics', $category);
        $this->getCategoryManager()->save($category);

        $context = $this->getReference('context-gallery');
        $category = $this->getCategoryManager()->create();
        $category->setName('Gallery');
        $category->setSlug('gallery');
        $category->setEnabled(true);
        $category->setContext($context);

        $this->setReference('category-gallery', $category);
        $this->getCategoryManager()->save($category);


        $context = $this->getReference('context-post-sets');
        $category = $this->getCategoryManager()->create();
        $category->setName('Post Sets');
        $category->setSlug('post-sets');
        $category->setEnabled(true);
        $category->setContext($context);

        $this->setReference('category-post-sets', $category);
        $this->getCategoryManager()->save($category);

        $manager->flush();
    }
}
