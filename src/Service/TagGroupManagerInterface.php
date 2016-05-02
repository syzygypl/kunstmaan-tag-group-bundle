<?php


namespace Szg\KunstmaanTagGroupBundle\Service;


use Doctrine\Common\Collections\Collection;
use Kunstmaan\TaggingBundle\Entity\Tag;
use Kunstmaan\TaggingBundle\Entity\Taggable;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;

interface TagGroupManagerInterface
{

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function addTagToGroup(Tag $tag, TagGroup $group);

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function removeTagFromGroup(Tag $tag, TagGroup $group);

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function groupHasTag(Tag $tag, TagGroup $group);

    /**
     * @param string $name
     *
     * @return null|TagGroup
     */
    public function getGroupByName($name);

    /**
     * @param Taggable $taggable
     * @param TagGroup $tagGroup
     *
     * @return Tag[]|Collection
     */
    public function filterByGroup(Taggable $taggable, TagGroup $tagGroup);

    /**
     * @return Collection|Tag[]
     */
    public function getAllTags();

}
