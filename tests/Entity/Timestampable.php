<?php

namespace RadekHubner\DoctrineExtensions\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\SmartObject;
use RadekHubner\DoctrineExtensions\Traits\CreatedAtEntity;
use RadekHubner\DoctrineExtensions\Traits\UpdatedAtEntity;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class Timestampable
{

    use SmartObject;
    use Identifier;
    use CreatedAtEntity;
    use UpdatedAtEntity;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $level = 0;

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level)
    {
        $this->level = $level;
    }
}
