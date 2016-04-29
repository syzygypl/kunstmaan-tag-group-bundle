<?php


namespace Szg\KunstmaanTagGroupBundle\Entity;

use Kunstmaan\TaggingBundle\Entity\Tag;

class TagGroupDefinition
{

    /** @var Tag */
    private $tag;

    /** @var TagGroup */
    private $group;

    /**
     * @return Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return TagGroup
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param Tag $tag
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param TagGroup $group
     */
    public function setGroup(TagGroup $group)
    {
        $this->group = $group;
    }

}
