<?php

namespace Szg\KunstmaanTagGroupBundle\Service\FormHandler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface TagGroupDefinitionFormHandlerInterface
{

    /**
     * @return FormInterface
     */
    public function createForm();

    /**
     * @param Request $request
     *
     * @return FormInterface
     */
    public function handle(Request $request);

}
