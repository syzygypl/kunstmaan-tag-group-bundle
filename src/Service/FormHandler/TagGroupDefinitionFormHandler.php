<?php

namespace Szg\KunstmaanTagGroupBundle\Service\FormHandler;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Szg\KunstmaanTagGroupBundle\Entity\TagGroupDefinition;

class TagGroupDefinitionFormHandler
{

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return FormInterface
     */
    public function createForm()
    {
        $definition = new TagGroupDefinition();

        return $this->formFactory->create('kunstmaan_tag_group_type', $definition);
    }

    /**
     * @param Request $request
     *
     * @return FormInterface
     */
    public function handle(Request $request)
    {
        return $this->createForm()->handleRequest($request);
    }

}
