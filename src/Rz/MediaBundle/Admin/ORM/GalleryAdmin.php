<?php

namespace Rz\MediaBundle\Admin\ORM;

use Sonata\MediaBundle\Admin\GalleryAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GalleryAdmin extends Admin
{


    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        // define group zoning
        $formMapper
            ->with($this->trans('Gallery'), array('class' => 'col-md-9'))->end()
            ->with($this->trans('Options'), array('class' => 'col-md-3'))->end()
        ;

        $context = $this->getPersistentParameter('context');

        if (!$context) {
            $context = $this->pool->getDefaultContext();
        }

        $formats = array();
        foreach ((array) $this->pool->getFormatNamesByContext($context) as $name => $options) {
            $formats[$name] = $name;
        }

        $contexts = array();
        foreach ((array) $this->pool->getContexts() as $contextItem => $format) {
            $contexts[$contextItem] = $contextItem;
        }

        $formMapper
            ->with('Options')
                ->add('context', 'sonata_type_translatable_choice', array(
                    'choices'   => $contexts,
                    'catalogue' => 'SonataMediaBundle',
                ))
                ->add('enabled', null, array('required' => false))
                ->add('name')
                ->add('defaultFormat', 'choice', array('choices' => $formats))
            ->end()
            ->with('Gallery')
                ->add('galleryHasMedias', 'sonata_type_collection', array(
                        'cascade_validation' => true,
                    ), array(
                        'edit'              => 'inline',
                        'inline'            => 'table',
                        'sortable'          => 'position',
                        'link_parameters'   => array('context' => $context),
                        'admin_code'        => 'sonata.media.admin.gallery_has_media',
                    )
                )
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('enabled', 'boolean', array('editable' => true))
            ->add('context', 'trans', array('catalogue' => 'SonataMediaBundle'))
            ->add('defaultFormat', 'trans', array('catalogue' => 'SonataMediaBundle'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('enabled')
            ->add('context')
        ;
    }
}
