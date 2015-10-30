<?php

namespace Rz\ClassificationBundle\Admin;

use Sonata\ClassificationBundle\Admin\CategoryAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\ClassificationBundle\Entity\ContextManager;

class CategoryAdmin extends Admin
{

    /**
     * {@inheritdoc}
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('tree', 'tree');
        $routes->add('createBaseCategory', 'createBaseCategory');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-8'))
                ->add('name')
                ->add('description', 'textarea', array('required' => false))
        ;

        if ($this->hasSubject()) {
            if ($this->getSubject()->getParent() !== null || $this->getSubject()->getId() === null) { // root category cannot have a parent
                $formMapper
                  ->add('parent', 'sonata_category_selector', array(
                      'category'      => $this->getSubject() ?: null,
                      'model_manager' => $this->getModelManager(),
                      'class'         => $this->getClass(),
                      'required'      => true,
                      'context'       => $this->getSubject()->getContext(),
                    ));
            }
        }

        $position = $this->hasSubject() && !is_null($this->getSubject()->getPosition()) ? $this->getSubject()->getPosition() : 0;

        $formMapper
            ->end()
            ->with('Options', array('class' => 'col-md-4'))
                ->add('enabled', null, array(
                    'required' => false,
                ))
                ->add('position', 'integer', array(
                    'required' => false,
                    'data'     => $position,
                ))
            ->end()
        ;

        if (interface_exists('Sonata\MediaBundle\Model\MediaInterface')) {
            $formMapper
                ->with('General')
                    ->add('media', 'sonata_type_model_list',
                        array(
                            'required' => false,
                        ),
                        array(
                            'link_parameters' => array(
                                'provider' => 'sonata.media.provider.image',
                                'context'  => 'sonata_category',
                            ),
                        )
                    )
                ->end();
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $options = array();
        if ($this->getPersistentParameter('hide_context') === 1) {
            $options['disabled'] = true;
        }

        $datagridMapper
            ->add('name')
            ->add('context', null, array(), null, $options)
            ->add('enabled')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('context', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
            ->add('slug', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
            ->add('description', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
            ->add('enabled', null, array('editable' => true, 'footable'=>array('attr'=>array('data-breakpoints'=>array('xs')))))
            ->add('parent', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('xs', 'sm', 'md')))))
        ;
    }
}
