<?php

namespace CoolStuff\Shared\Workflow\Domain\Fixture;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use CoolStuff\Shared\Workflow\Domain\Entity\Workflow;

/**
 * Class WorkflowFixture
 *
 * @package CoolStuff\Shared\Workflow\Domain\Fixture
 */
class WorkflowFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager->persist(
            (new Workflow())
                ->setName('Workflow 1')
                ->setSlug('workflow-1')
        );

        $manager->flush();
    }
}