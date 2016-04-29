<?php

namespace Szg\KunstmaanTagGroupBundle\Service\Twig;

use Kunstmaan\TaggingBundle\Entity\Taggable;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;
use Szg\KunstmaanTagGroupBundle\Service\TagGroupService;
use Kunstmaan\TaggingBundle\Entity\Tag;

class TagGroupTwigExtension extends \Twig_Extension
{

    /**
     * @var TagGroupService
     */
    private $tagGroupService;

    /**
     * TagGroupTwigExtension constructor.
     *
     * @param TagGroupService $tagGroupService
     */
    public function __construct(TagGroupService $tagGroupService)
    {
        $this->tagGroupService = $tagGroupService;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('tag_group', [$this, 'tagsFromGroupFilter'])
        ];
    }

    /**
     * @param Taggable $taggable
     * @param          $group
     *
     * @return array|Tag[]
     */
    public function tagsFromGroupFilter(Taggable $taggable, $group)
    {
        if (is_string($group)) {
            $group = $this->tagGroupService->getGroupByName($group);
        }

        if(!$group instanceof TagGroup){
            throw new \InvalidArgumentException('Tag group is not found.');
        }

        return $this->tagGroupService->filterByGroup($taggable, $group);
    }

    public function getName()
    {
        return 'tag_group';
    }

}
