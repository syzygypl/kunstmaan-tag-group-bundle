<?php

namespace Szg\KunstmaanTagGroupBundle\Service;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Kunstmaan\TaggingBundle\Entity\Tag;
use Kunstmaan\TaggingBundle\Entity\Taggable;
use Kunstmaan\TaggingBundle\Repository\TagRepository;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroupRepository;

class TagGroupService
{

    /** @var EntityManager|EntityManagerInterface */
    private $entityManager;

    /** @var TagGroupRepository */
    private $tagGroupRepostiory;

    /**
     * @param EntityManagerInterface $entityManager
     * @param TagGroupRepository     $tagGroupRepostiory
     */
    public function __construct(EntityManagerInterface $entityManager, TagGroupRepository $tagGroupRepostiory)
    {
        $this->entityManager = $entityManager;
        $this->tagGroupRepostiory = $tagGroupRepostiory;
    }

    /**
     * @param Taggable $taggable
     * @param TagGroup $tagGroup
     *
     * @return Tag[]|Collection
     */
    public function filterByGroup(Taggable $taggable, TagGroup $tagGroup)
    {
        return $this->tagGroupRepostiory->filterByGroup($taggable, $tagGroup);
    }

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function addTagToGroup(Tag $tag, TagGroup $group)
    {
        if (true === $group->getTags()->contains($tag)) {
            return false;
        }
        $group->addTag($tag);
        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function removeTagFromGroup(Tag $tag, TagGroup $group)
    {
        if (false === $group->getTags()->contains($tag)) {
            return false;
        }

        $group->removeTag($tag);
        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param Tag      $tag
     * @param TagGroup $group
     *
     * @return bool
     */
    public function groupHasTag(Tag $tag, TagGroup $group)
    {
        return $group->getTags()->contains($tag);
    }

    /**
     * @param string $name
     *
     * @return null|TagGroup
     */
    public function getGroupByName($name)
    {
        return $this->tagGroupRepostiory->findOneBy(['internalName' => $name]);
    }

    /**
     * @return mixed
     */
    public function getAllTags()
    {
        return $this->entityManager->getRepository('KunstmaanTaggingBundle:Tag')->findAll();
    }

    /**
     * @param TagGroup $group
     *
     * @return mixed
     */
    public function getTagsNotInGroup(TagGroup $group)
    {
        $groupTags = $group->getTags();
        $excludeIds = [];

        /** @var TagRepository $tagRepository */
        $tagRepository = $this->entityManager->getRepository('KunstmaanTaggingBundle:Tag');

        if (0 !== count($groupTags)) {
            $excludeIds = $groupTags->map(function (Tag $tag) {
                return $tag->getId();
            });
        }

        $qb = $tagRepository->createQueryBuilder('t');
        if ($excludeIds) {
            $qb->where($qb->expr()->notIn('t.id', implode(',', $excludeIds->toArray())));
        }
        $qb->orderBy('t.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

}
