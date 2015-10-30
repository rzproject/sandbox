<?php

namespace Rz\ClassificationBundle\Entity;

use Sonata\ClassificationBundle\Entity\CategoryManager as BaseCategoryManager;
use Sonata\ClassificationBundle\Model\CategoryInterface;
use Sonata\ClassificationBundle\Model\ContextInterface;

class CategoryManager extends BaseCategoryManager
{

    /**
     * @return CategoryInterface[]
     */
    public function getRootCategories($loadChildren = true)
    {
        $class = $this->getClass();

        $rootCategories = $this->getObjectManager()->createQuery(sprintf('SELECT c FROM %s c WHERE c.parent IS NULL', $class))
            ->useResultCache(true, 3600)
            ->execute();

        $categories = array();

        foreach ($rootCategories as $category) {
            if ($category->getContext() === null) {
                throw new \RuntimeException('Context cannot be null');
            }

            $categories[$category->getContext()->getId()] = $loadChildren ? $this->getRootCategory($category->getContext()) : $category;
        }

        return $categories;
    }

    /**
     * Load all categories from the database, the current method is very efficient for < 256 categories.
     */
    protected function loadCategories(ContextInterface $context)
    {
        if (array_key_exists($context->getId(), $this->categories)) {
            return;
        }

        $class = $this->getClass();

        $categories = $this->getObjectManager()->createQuery(sprintf('SELECT c FROM %s c WHERE c.context = :context ORDER BY c.parent ASC', $class))
            ->setParameter('context', $context->getId())
            ->useResultCache(true, 3600)
            ->execute();

        if (count($categories) == 0) {
            // no category, create one for the provided context
            $category = $this->create();
            $category->setName($context->getName());
            $category->setEnabled(true);
            $category->setContext($context);
            $category->setDescription($context->getName());

            $this->save($category);

            $categories = array($category);
        }

        foreach ($categories as $pos => $category) {
            if ($pos === 0 && $category->getParent()) {
                throw new \RuntimeException('The first category must be the root');
            }

            if ($pos == 0) {
                $root = $category;
            }

            $this->categories[$context->getId()][$category->getId()] = $category;

            $parent = $category->getParent();

            $category->disableChildrenLazyLoading();

            if ($parent) {
                $parent->addChild($category);
            }
        }

        $this->categories[$context->getId()] = array(
            0 => $root,
        );
    }

    /**
     * @return Array
     */
    public function getCategoryContexts()
    {
        $class = $this->getClass();

        $categoryContexts = $this->getObjectManager()->createQuery(sprintf('SELECT DISTINCT IDENTITY(c.context) as context FROM %s c GROUP BY c.context', $class))
            ->useResultCache(true, 3600)
            ->execute();

        $contexts = array();

        foreach ($categoryContexts as $categoryContext) {
            $contexts[] = $categoryContext['context'];
        }

        return $contexts;
    }
}
