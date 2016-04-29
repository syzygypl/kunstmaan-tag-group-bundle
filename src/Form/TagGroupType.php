<?php

namespace Szg\KunstmaanTagGroupBundle\Form;

use Kunstmaan\TaggingBundle\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroupDefinition;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroup;

class TagGroupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tag', 'entity', [
            'class' => Tag::class
        ])->add('group', 'entity', [
            'class' => TagGroup::class
        ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'class'           => TagGroupDefinition::class,
            'csrf_protection' => false
        ]);
    }


    public function getName()
    {
        return 'kunstmaan_tag_group_type';
    }

}
