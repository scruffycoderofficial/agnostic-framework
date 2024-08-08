<?php

namespace CoolStuff\Shared\Workflow\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use CoolStuff\Component\Entity\Entity;

#[ORM\Entity]
#[ORM\Table(name: 'workflows')]
class Workflow extends Entity
{
    #[ORM\Column(name: 'name', type: 'string')]
    protected string $name;

    #[ORM\Column(name: 'slug', type: 'string', nullable: true)]
    protected string $slug;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Workflow
     */
    public function setName(string $name): Workflow
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Workflow
     */
    public function setSlug(string $slug): Workflow
    {
        $this->slug = $slug;
        return $this;
    }
}