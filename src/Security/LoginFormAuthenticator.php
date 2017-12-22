<?php

namespace App\Security;

use App\Form\LoginForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @param RouterInterface              $router
     * @param FormFactoryInterface         $formFactory
     * @param CsrfTokenManagerInterface    $csrfTokenManager
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->router              = $router;
        $this->formFactory         = $formFactory;
        $this->csrfTokenManager    = $csrfTokenManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    protected function getLoginUrl()
    {
        return '/login';
    }

    /**
     * This will be called on every request and your job is to decide if the authenticator should be used for this
     * request (return true) or if it should be skipped (return false).
     *
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return ($request->getPathInfo() == '/login' && $request->isMethod('POST'));
    }

    /**
     * This will be called on every request and your job is to read the token (or whatever your "authentication"
     * information is) from the request and return it. If you return null, the rest of the authentication process is
     * skipped. Otherwise, getUser() will be called and the return value is passed as the first argument.
     *
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        /*$csrfToken = $request->request->get('_csrf_token');

        if (false === $this->csrfTokenManager->isTokenValid(new CsrfToken('authenticate', $csrfToken))) {
            throw new InvalidCsrfTokenException('Invalid CSRF token.');
        }*/

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['username']
        );

        return $data;
    }

    /**
     * If getCredentials() returns a non-null value, then this method is called and its return value is passed here as
     * the $credentials argument. Your job is to return an object that implements UserInterface. If you do, then
     * checkCredentials() will be called. If you return null (or throw an AuthenticationException) authentication will
     * fail.
     *
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['username'];

        return null === $username
            ? null
            : $userProvider->loadUserByUsername($username);
    }

    /**
     * If getUser() returns a User object, this method is called. Your job is to verify if the credentials are correct.
     * For a login form, this is where you would check that the password is correct for the user. To pass
     * authentication, return true. If you return anything else (or throw an AuthenticationException), authentication
     * will fail.
     *
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['password'];

        return $this->userPasswordEncoder->isPasswordValid($user, $password);
    }

    /**
     * This is called after successful authentication and your job is to either return a Response object that will be
     * sent to the client or null to continue the request (e.g. allow the route/controller to be called like normal).
     * Since this is an API where each request authenticates itself, you want to return null.
     *
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate('easyadmin'));
    }
}