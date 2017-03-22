<?php

namespace RadekHubner\DoctrineExtensions\DI;

use Kdyby\Events\DI\EventsExtension;
use Nette\DI\CompilerExtension;

final class TimestampableExtension extends CompilerExtension
{

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('listener'))
            ->setClass('Gedmo\Timestampable\TimestampableListener')
            ->addSetup('setAnnotationReader', ['@Doctrine\Common\Annotations\Reader'])
            ->addTag(EventsExtension::TAG_SUBSCRIBER);
    }
}
