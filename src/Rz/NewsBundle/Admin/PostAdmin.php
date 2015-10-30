<?php

namespace Rz\NewsBundle\Admin;

use Sonata\NewsBundle\Admin\PostAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\NewsBundle\Model\CommentInterface;

class PostAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('group_post', array(
                    'class' => 'col-md-8',
                ))
                ->add('author', 'sonata_type_model_list')
                ->add('title')
                ->add('abstract', null, array('attr' => array('rows' => 5)))
                ->add('content', 'sonata_formatter_type', array(
                    'event_dispatcher'          => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'format_field'              => 'contentFormatter',
                    'source_field'              => 'rawContent',
                    'source_field_options'      => array(
                        'horizontal_input_wrapper_class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'col-lg-12' : '',
                        'attr'                           => array('class' => $this->getConfigurationPool()->getOption('form_type') == 'horizontal' ? 'span10 col-sm-10 col-md-10' : '', 'rows' => 20),
                    ),
                    'ckeditor_context'     => 'news',
                    'target_field'         => 'content',
                    'listener'             => true,
                ))
            ->end()
            ->with('group_status', array(
                    'class' => 'col-md-4',
                ))
                ->add('enabled', null, array('required' => false))
                ->add('image', 'sonata_type_model_list', array('required' => false), array(
                    'link_parameters' => array(
                        'context'      => 'news',
                        'hide_context' => true,
                    ),
                ))

                ->add('publicationDateStart', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
                ->add('commentsCloseAt', 'sonata_type_datetime_picker', array(
                    'dp_side_by_side' => true,
                    'required'        => false,
                ))
                ->add('commentsEnabled', null, array('required' => false))
                ->add('commentsDefaultStatus', 'sonata_news_comment_status', array('expanded' => true))
            ->end()

            ->with('group_classification', array(
                'class' => 'col-md-4',
                ))
                ->add('tags', 'sonata_type_model_autocomplete', array(
                    'property' => 'name',
                    'multiple' => 'true',
                    'required' => false,
                    'callback' => function ($admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();
                        $queryBuilder = $datagrid->getQuery();
                        $queryBuilder
                            ->andWhere($queryBuilder->getRootAlias() . '.context=:context')
                            ->setParameter('context', 'news')
                        ;
                        $datagrid->setValue($property, null, $value);
                    },
                ))
                ->add('collection', 'sonata_type_model_list', array('required' => false), array('link_parameters'=>array('context'=>'news', 'hide_context'=>true)))
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('custom', 'string', array('template' => 'RzNewsBundle:PostAdmin:list_post_custom.html.twig', 'label' => 'Post'))
            ->add('enabled', null, array('editable' => true, 'footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
            ->add('publicationDateStart', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('all')))))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $that = $this;

        $datagridMapper
            ->add('title')
            ->add('enabled')
            ->add('tags', null, array('field_options' => array('expanded' => true, 'multiple' => true)))
            ->add('author')

            ->add('createdAt', 'doctrine_orm_datetime_range', array('field_type' => 'sonata_type_datetime_range_picker'))
            ->add('with_open_comments', 'doctrine_orm_callback', array(
//                'callback'   => array($this, 'getWithOpenCommentFilter'),
                'callback' => function ($queryBuilder, $alias, $field, $data) use ($that) {
                    if (!is_array($data) || !$data['value']) {
                        return;
                    }

                    $queryBuilder->leftJoin(sprintf('%s.comments', $alias), 'c');
                    $queryBuilder->andWhere('c.status = :status');
                    $queryBuilder->setParameter('status', CommentInterface::STATUS_MODERATE);
                },
                'field_type' => 'checkbox',
            ))
        ;
    }
}
