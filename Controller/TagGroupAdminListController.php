<?php

namespace Szg\KunstmaanTagGroupBundle\Controller;

use Kunstmaan\AdminListBundle\AdminList\Configurator\AdminListConfiguratorInterface;
use Kunstmaan\AdminListBundle\Controller\AdminListController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Szg\KunstmaanTagGroupBundle\AdminList\TagGroupAdminListConfigurator;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroupDefinition;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;

/**
 * The admin list controller for TagGroup
 */
class TagGroupAdminListController extends AdminListController
{
    /**
     * @var AdminListConfiguratorInterface
     */
    private $configurator;

    /**
     * @return AdminListConfiguratorInterface|TagGroupAdminListConfigurator
     */
    public function getAdminListConfigurator()
    {
        if (!isset($this->configurator)) {
            $this->configurator = new TagGroupAdminListConfigurator($this->getEntityManager());
        }

        return $this->configurator;
    }

    /**
     * The index action
     *
     * @Route("/", name="kunstmaantaggroupbundle_admin_taggroup")
     * @param Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $adminList = $this->getAdminListConfigurator();
        $adminList->addSimpleItemAction('Tagi', function (TagGroup $item) {
            return [
                'path'   => 'kunstmaantaggroupbundle_admin_taggroup_tag_list',
                'params' => [
                    'group' => $item->getId(),
                ],
            ];
        }, 'tags');

        return parent::doIndexAction($this->getAdminListConfigurator(), $request);
    }

    /**
     * The add action
     *
     * @Route("/add", name="kunstmaantaggroupbundle_admin_taggroup_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return array
     */
    public function addAction(Request $request)
    {
        return parent::doAddAction($this->getAdminListConfigurator(), null, $request);
    }

    /**
     * The edit action
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     * @Route("/{id}", requirements={"id" = "\d+"}, name="kunstmaantaggroupbundle_admin_taggroup_edit")
     * @Method({"GET", "POST"})
     *
     */
    public function editAction(Request $request, $id)
    {
        return parent::doEditAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The delete action
     *
     * @param Request $request
     * @param int     $id
     *
     * @return array
     * @Route("/{id}/delete", requirements={"id" = "\d+"}, name="kunstmaantaggroupbundle_admin_taggroup_delete")
     * @Method({"GET", "POST"})
     *
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::doDeleteAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The export action
     *
     * @param Request $request
     * @param string  $_format
     *
     * @return array
     * @Route("/export.{_format}", requirements={"_format" = "csv|xlsx"},
     *                             name="kunstmaantaggroupbundle_admin_taggroup_export")
     * @Method({"GET", "POST"})
     */
    public function exportAction(Request $request, $_format)
    {
        return parent::doExportAction($this->getAdminListConfigurator(), $_format, $request);
    }

    /**
     * @Route("/tag/list/{group}", name="kunstmaantaggroupbundle_admin_taggroup_tag_list")
     * @param TagGroup $group
     *
     * @return array
     */
    public function listTagsAction(TagGroup $group)
    {
        $service = $this->get('szg_kunstmaantaggroupbundle.tag_group.service');

        return $this->render('@KunstmaanTagGroup/TagGroup/list.html.twig', [
            'tags'  => [
                'all'   => $service->getAllTags(),
                'group' => $group->getTags()
            ],
            'group' => $group
        ]);
    }

    /**
     * @Route("/tag/add", name="kunstmaantaggroupbundle_admin_taggroup_tag_add")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return array
     */
    public function addTagAction(Request $request)
    {
        $service = $this->get('szg_kunstmaantaggroupbundle.tag_group.service');
        $handler = $this->get('szg_kunstmaantaggroupbundle.form.tag_group_form_handler');
        $form = $handler->handle($request);

        if ($form->isValid()) {
            /** @var TagGroupDefinition $definition */
            $definition = $form->getData();
            if ($service->addTagToGroup($definition->getTag(), $definition->getGroup())) {
                return new JsonResponse(['status' => 'success'], 200);
            }
        }

        return new JsonResponse(['status' => 'error'], 400);
    }

    /**
     * @Route("/tag/remove", name="kunstmaantaggroupbundle_admin_taggroup_tag_remove")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return array
     */
    public function removeTagAction(Request $request)
    {
        $service = $this->get('szg_kunstmaantaggroupbundle.tag_group.service');
        $handler = $this->get('szg_kunstmaantaggroupbundle.form.tag_group_form_handler');
        $form = $handler->handle($request);

        if ($form->isValid()) {
            /** @var TagGroupDefinition $definition */
            $definition = $form->getData();
            if ($service->removeTagFromGroup($definition->getTag(), $definition->getGroup())) {
                return new JsonResponse(['status' => 'success'], 200);
            }
        }

        return new JsonResponse(['status' => 'error'], 400);
    }

}
