<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginForm;
use App\Form\RegisterForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController
{
    /**
     * @Route("/login", name="login")
     *
     * @param FormFactoryInterface $formFactory
     * @param AuthenticationUtils  $authUtils
     * @param \Twig_Environment    $twig
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function login(
        FormFactoryInterface $formFactory,
        AuthenticationUtils $authUtils,
        \Twig_Environment $twig
    )
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return new Response($twig->render('security/login.html.twig', [
            'form'          => $formFactory->create(LoginForm::class)->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ]));
    }

    /**
     * @Route("/register", name="register")
     *
     * @param FormFactoryInterface $formFactory
     * @param RegistryInterface    $registry
     * @param RouterInterface      $router
     * @param \Twig_Environment    $twig
     * @param Request              $request
     *
     * @return string|RedirectResponse
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function register(
        FormFactoryInterface $formFactory,
        RegistryInterface $registry,
        RouterInterface $router,
        \Twig_Environment $twig,
        Request $request
    )
    {
        $user = new User();
        $form = $formFactory->create(RegisterForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $registry->getManager();
            $em->persist($user);
            $em->flush();

            return new RedirectResponse($router->generate('login'));
        }

        return new Response($twig->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}