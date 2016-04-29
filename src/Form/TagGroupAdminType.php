<?php

namespace Szg\KunstmaanTagGroupBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class TagGroupAdminType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, [
            'constraints' => [
                new NotNull(),
                new NotBlank()
            ]
        ]);
        $builder->add('internalName', null, [
            'constraints' => [
                new NotNull(),
                new NotBlank()
            ]
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'taggroup_form';
    }
}
