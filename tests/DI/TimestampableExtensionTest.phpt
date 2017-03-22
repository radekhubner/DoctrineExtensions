<?php

namespace RadekHubner\DoctrineExtensions\Tests\DI;

use Kdyby\Doctrine\EntityManager;
use Nette\DI\Container;
use RadekHubner\DoctrineExtensions\Entity\Timestampable;
use Tester\Assert;
use Tester\TestCase;

$container = require __DIR__ . '/../bootstrap.php';

final class TimestampableExtensionTest extends TestCase
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em = $this->container->getByType('Kdyby\Doctrine\EntityManager');
    }

    public function setUp()
    {
        $this->em->getConnection()->executeQuery('
            DROP TABLE IF EXISTS timestampable;

            CREATE TABLE timestampable (
                id INT AUTO_INCREMENT NOT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                level INT NOT NULL,
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
        ');
    }

    public function tearDown()
    {
        $this->em->getConnection()->executeQuery('
            DROP TABLE IF EXISTS timestampable;
        ');
    }

    public function testDates()
    {
        $timestampable = new Timestampable();

        Assert::null($timestampable->getCreatedAt());
        Assert::null($timestampable->getUpdatedAt());
        Assert::equal(0, $timestampable->getLevel());

        $this->em->persist($timestampable);
        $this->em->flush($timestampable);

        $createdAt = $timestampable->getCreatedAt();
        $updatedAt = $timestampable->getUpdatedAt();

        Assert::true($createdAt instanceof \DateTime);
        Assert::true($updatedAt instanceof \DateTime);

        $timestampable->setLevel(1);

        $this->em->flush($timestampable);

        Assert::true($timestampable->getCreatedAt() instanceof \DateTime);
        Assert::true($timestampable->getUpdatedAt() instanceof \DateTime);
        Assert::true($updatedAt < $timestampable->getUpdatedAt());
    }
}

$test = new TimestampableExtensionTest($container);
$test->run();
