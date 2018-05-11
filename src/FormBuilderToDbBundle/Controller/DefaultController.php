<?php

namespace Extera\FormBuilderToDbBundle\Controller;

use Pimcore\Controller\FrontendController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FrontendController
{
    /**
     * @Route("/extera_form_builder_to_db")
     */
    public function indexAction(Request $request)
    {
        return new Response('Hello world from extera_form_builder_to_db');
    }
}
