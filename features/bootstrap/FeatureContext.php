<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behatch\Context\RestContext;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext implements Context
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @var array
     */
    private $classes;

    /**
     * @var JWTTokenManagerInterface
     */
    private $tokenManager;

    /**
     * @var RestContext
     */
    private $restContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @param ManagerRegistry          $doctrine
     * @param JWTTokenManagerInterface $tokenManager
     */
    public function __construct(ManagerRegistry $doctrine, JWTTokenManagerInterface $tokenManager)
    {
        $this->doctrine   = $doctrine;
        $this->manager    = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes    = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->tokenManager = $tokenManager;
    }

    /**
     * @BeforeScenario
     * @createSchema
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @AfterScenario
     * @dropSchema
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropSchema($this->classes);
    }

    /**
     * @BeforeScenario
     * @login
     *
     * @see https://symfony.com/doc/current/security/entity_provider.html#creating-your-first-user
     *
     * @param BeforeScenarioScope $scope
     */
    public function login(BeforeScenarioScope $scope)
    {
        $user = new \App\Entity\User();
        $user->setEmail('admin@admin.com');
        $user->setPassword('123');

        $this->manager->persist($user);
        $this->manager->flush();

        $token = $this->tokenManager->create($user);

        $this->restContext = $scope->getEnvironment()->getContext(RestContext::class);
        $this->restContext->iAddHeaderEqualTo('Authorization', "Bearer $token");
    }

    /**
     * @AfterScenario
     * @logout
     */
    public function logout()
    {
        $this->restContext->iAddHeaderEqualTo('Authorization', '');
    }
}
