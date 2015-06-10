<?php

namespace AcmeNewsBundle\DataFixtures\ORM\shared;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class NewsLoader extends DataFixtureLoader implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        return [
            __DIR__ . '/data/news.yml'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
