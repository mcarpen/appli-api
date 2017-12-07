<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class DefaultController
{
    /**
     * @Route("/", name="homepage")
     *
     * @param \Twig_Environment $twig
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function home(\Twig_Environment $twig)
    {
        return new Response($twig->render("base.html.twig"));
    }
}