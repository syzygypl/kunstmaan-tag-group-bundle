<?php


namespace Szg\KunstmaanTagGroupBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Kunstmaan\TaggingBundle\Entity\Tag;
use Kunstmaan\TaggingBundle\Entity\Taggable;

class TagGroupRepository extends EntityRepository
{

    /**
     * @param Taggable $taggable
     * @param TagGroup $tagGroup
     *
     * @return Collection
     */
    public function filterByGroup(Taggable $taggable, TagGroup $tagGroup)
    {

        $ids = $this->getTagsIds($taggable);
        if (0 === count($ids)) {
            return new ArrayCollection();
        }

        $qb = $this->createQueryBuilder('tg');
        $qb->select('tg, t');
        $qb->leftJoin('tg.tags', 't');
        $qb->where('tg.id = :id')->setParameter('id', $tagGroup->getId());
        $qb->andWhere($qb->expr()->in('t.id', $ids));
        $qb->orderBy('t.name', 'ASC');


        /** @var TagGroup[] $result */
        $result = $qb->getQuery()->getResult();

        if ($result) {
            return $result[0]->getTags();
        }

        return new ArrayCollection();
    }

    /**
     * @param Taggable $taggable
     *
     * @return array
     */
    protected function getTagsIds(Taggable $taggable)
    {
        $tags = $taggable->getTags();
        $ids = $tags->map(function (Tag $tag) {
            return $tag->getId();
        })->getValues();

        return $ids;
    }

}
