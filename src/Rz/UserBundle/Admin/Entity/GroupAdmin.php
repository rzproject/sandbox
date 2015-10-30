<?php

namespace Rz\UserBundle\Admin\Entity;

use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseGroupAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GroupAdmin extends BaseGroupAdmin
{
/**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('roles', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
        ;
    }
     /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Group')
                ->with('General', array('class' => 'col-md-12'))
                    ->add('name')
                ->end()
            ->end()
            ->tab('Security')
                ->with('Roles', array('class' => 'col-md-12'))
                    ->add('roles', 'sonata_security_roles', array(
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false,
                        'label'    => false
                    ))
                ->end()
            ->end()
        ;
    }
}
