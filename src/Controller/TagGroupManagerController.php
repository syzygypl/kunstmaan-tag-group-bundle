<?php

namespace Szg\KunstmaanTagGroupBundle\Controller;

use Kunstmaan\AdminListBundle\Controller\AdminListController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroupDefinition;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;

/**
 * The admin list controller for TagGroup
 */
class TagGroupManagerController extends AdminListController
{

    /**
     * @Route("/tag/list/{group}", name="kunstmaantaggroupbundle_admin_taggroup_manager_list")
     * @param TagGroup $group
     *
     * @return array
     */
    public function listTagsAction(TagGroup $group)
    {
        $manager = $this->get('szg_kunstmaantaggroupbundle.tag_group.manager');

        return $this->render('@KunstmaanTagGroup/TagGroup/list.html.twig', [
            'tags'  => [
                'all'   => $manager->getAllTags(),
                'group' => $group->getTags()
            ],
            'group' => $group
        ]);
    }

    /**
     * @Route("/tag/add", name="kunstmaantaggroupbundle_admin_taggroup_manager_add")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return array
     */
    public function addTagAction(Request $request)
    {
        $manager = $this->get('szg_kunstmaantaggroupbundle.tag_group.manager');
        $handler = $this->get('szg_kunstmaantaggroupbundle.form.tag_group_form_handler');
        $form = $handler->handle($request);

        if ($form->isValid()) {
            /** @var TagGroupDefinition $definition */
            $definition = $form->getData();
            if ($manager->addTagToGroup($definition->getTag(), $definition->getGroup())) {
                return new JsonResponse(['status' => 'success'], 200);
            }
        }

        return new JsonResponse(['status' => 'error'], 400);
    }

    /**
     * @Route("/tag/remove", name="kunstmaantaggroupbundle_admin_taggroup_manager_remove")
     * @Method({"POST"})
     * @param Request $request
     *
     * @return array
     */
    public function removeTagAction(Request $request)
    {
        $manager = $this->get('szg_kunstmaantaggroupbundle.tag_group.manager');
        $handler = $this->get('szg_kunstmaantaggroupbundle.form.tag_group_form_handler');
        $form = $handler->handle($request);

        if ($form->isValid()) {
            /** @var TagGroupDefinition $definition */
            $definition = $form->getData();
            if ($manager->removeTagFromGroup($definition->getTag(), $definition->getGroup())) {
                return new JsonResponse(['status' => 'success'], 200);
            }
        }

        return new JsonResponse(['status' => 'error'], 400);
    }

}
