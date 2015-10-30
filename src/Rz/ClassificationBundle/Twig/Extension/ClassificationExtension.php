<?php

namespace Rz\ClassificationBundle\Twig\Extension;

use Sonata\CoreBundle\Model\ManagerInterface;

class ClassificationExtension extends \Twig_Extension
{
    /**
     * @var CmsManagerSelectorInterface
     */
    private $contextManager;
    private $categoryManager;

    /**
     * @param ManagerInterface $contextManager
     * @param ManagerInterface $categoryManager
     *
     */
    public function __construct(ManagerInterface $contextManager, ManagerInterface $categoryManager)
    {
        $this->contextManager     = $contextManager;
        $this->categoryManager    = $categoryManager;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('rz_classification_allow_create_base_category', array($this, 'allowCreateBaseCategory')),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'rz_classification';
    }

    /**
     * @return string
     */
    public function allowCreateBaseCategory()
    {
        $categoryContext = $this->categoryManager->getCategoryContexts();
        try {
            $defunctContexts = $this->contextManager->getDefunctContext($categoryContext);
            if ($defunctContexts && is_array($defunctContexts)) {
                return true;
            } else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
    }
}
