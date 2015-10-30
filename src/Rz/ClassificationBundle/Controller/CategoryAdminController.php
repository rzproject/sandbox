<?php


namespace Rz\ClassificationBundle\Controller;

use Sonata\ClassificationBundle\Controller\CategoryAdminController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Page Admin Controller.
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class CategoryAdminController extends Controller
{

    /**
     * Create action.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createBaseCategoryAction(Request $request = null)
    {
        $categoryContext = $this->get('sonata.classification.manager.category')->getCategoryContexts();
        $defunctContexts = $this->get('sonata.classification.manager.context')->getDefunctContext($categoryContext);

        if (!$defunctContexts || !is_array($defunctContexts)) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('flash_category_context_not_available', array(), 'SonataClassificationBundle'));
            return new RedirectResponse($this->admin->generateUrl('tree'));
        }

        if (!$request->get('context') && $request->isMethod('get')) {
            return $this->render('RzClassificationBundle:CategoryAdmin:select_context.html.twig', array(
                'defunct_contexts'  => $defunctContexts,
                'base_template'     => $this->getBaseTemplate(),
                'admin'             => $this->admin,
                'action'            => 'create',
            ));
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('flash_category_context_created', array('%context%'=>$request->get('context')), 'SonataClassificationBundle'));
        return new RedirectResponse($this->admin->generateUrl('create', array('context'=>$request->get('context'))));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request = null)
    {
        if (!$request->get('filter') && !$request->get('filters')) {
            return new RedirectResponse($this->admin->generateUrl('tree'));
        }

        if ($listMode = $request->get('_list_mode')) {
            $this->admin->setListMode($listMode);
        }

        $categoryManager = $this->get('sonata.classification.manager.category');

        $currentContext = false;
        if ($context = $request->get('context')) {
            $currentContext = $this->get('sonata.classification.manager.context')->find($context);
        }

        $rootCategories = $categoryManager->getRootCategories(false);

        if (!$currentContext) {
            $mainCategory   = current($rootCategories);
            $currentContext = $mainCategory->getContext();
        } else {
            foreach ($rootCategories as $category) {
                if ($currentContext->getId() != $category->getContext()->getId()) {
                    continue;
                }

                $mainCategory = $category;

                break;
            }
        }

        $datagrid = $this->admin->getDatagrid();

        if ($this->admin->getPersistentParameter('context')) {
            $datagrid->setValue('context', null, $this->admin->getPersistentParameter('context'));
        }

        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'list',
            'main_category'    => $mainCategory,
            'root_categories'  => $rootCategories,
            'current_context'  => $currentContext,
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }
}
