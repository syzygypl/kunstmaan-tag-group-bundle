<?php

namespace Szg\KunstmaanTagGroupBundle\Helper\Menu;

use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\TopMenuItem;
use Symfony\Component\HttpFoundation\Request;

class TagsGroupsMenuAdaptor implements MenuAdaptorInterface
{
    /**
     * @param MenuBuilder   $menu
     * @param array         $children
     * @param MenuItem|null $parent
     * @param Request|null  $request
     */
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
        if (null !== $parent && 'KunstmaanAdminBundle_modules' === $parent->getRoute()) {
            $menuItem = new TopMenuItem($menu);
            $menuItem
                ->setRoute('kunstmaantaggroupbundle_admin_taggroup')
                ->setUniqueId('TagsGroups')
                ->setLabel('Tags Groups')
                ->setParent($parent);
            if (stripos($request->attributes->get('_route'), $menuItem->getRoute()) === 0) {
                $menuItem->setActive(true);
                $parent->setActive(true);
            }
            $children[] = $menuItem;
        }
    }
}
