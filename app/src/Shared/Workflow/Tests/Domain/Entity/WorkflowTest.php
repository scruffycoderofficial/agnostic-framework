<?php

namespace CoolStuff\Shared\Workflow\Tests\Domain\Entity;

use CoolStuff\Shared\Workflow\Tests\Domain\TestCase;
use CoolStuff\Shared\Workflow\Domain\Entity\Workflow;
use CoolStuff\Shared\Workflow\Domain\Fixture\WorkflowFixture;

class WorkflowTest extends TestCase
{
    protected function setUp():void
    {
        parent::setUp();
    }

    public function testItCanCreateANamedSluggifiedWorkflow()
    {
        $workflow = (new Workflow())
            ->setName('Sluggable Workflow Instance')
            ->setSlug('sluggable-workflow-instance');

        $this->entityManager->persist($workflow);
        $this->entityManager->flush();

        $workflow = $this->entityManager
            ->getRepository(Workflow::class)
            ->find(1);

        self::assertSame('sluggable-workflow-instance', $workflow->getSlug());
    }

    public function testItCanLoadWorkflowsFromFixture()
    {
        $this->loadFixture(WorkflowFixture::class);

        self::assertCount(1 ,
            $this->entityManager
                ->getRepository(Workflow::class)
                ->findAll()
        );
    }

    protected function entityClasses(): array
    {
        return [Workflow::class];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}