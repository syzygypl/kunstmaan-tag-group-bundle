<?php

namespace Szg\KunstmaanTagGroupBundle\Service\Twig;

use Kunstmaan\TaggingBundle\Entity\Taggable;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;
use Kunstmaan\TaggingBundle\Entity\Tag;
use Szg\KunstmaanTagGroupBundle\Service\TagGroupManagerInterface;

class TagGroupTwigExtension extends \Twig_Extension
{

    /**
     * @var TagGroupManagerInterface
     */
    private $tagGroupManager;

    /**
     * @param TagGroupManagerInterface $tagGroupManager
     */
    public function __construct(TagGroupManagerInterface $tagGroupManager)
    {
        $this->tagGroupManager = $tagGroupManager;
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
            $group = $this->tagGroupManager->getGroupByName($group);
        }

        if (!$group instanceof TagGroup) {
            throw new \InvalidArgumentException('Tag group is not found.');
        }

        return $this->tagGroupManager->filterByGroup($taggable, $group);
    }

    public function getName()
    {
        return 'tag_group';
    }

}
