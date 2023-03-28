<?php

/**
 * TOBENTO
 *
 * @copyright   Tobias Strub, TOBENTO
 * @license     MIT License, see LICENSE file distributed with this source code.
 * @author      Tobias Strub
 * @link        https://www.tobento.ch
 */

declare(strict_types=1);

namespace Tobento\Service\Repository\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Repository\EventerInterface;
use Tobento\Service\Repository\Eventer;
use Tobento\Service\Repository\EventsRepositoryAdapter;
use Tobento\Service\Event\Events;
use Tobento\Service\Repository\Test\Mock;

/**
 * EventerTest
 */
class EventerTest extends TestCase
{
    public function testCreateEventer()
    {
        $eventer = new Eventer(
            eventDispatcher: new Events(),
        );
        
        $this->assertInstanceof(EventerInterface::class, $eventer);
    }
    
    public function testRepositoryMethod()
    {
        $eventer = new Eventer(
            eventDispatcher: new Events(),
        );
        
        $repository = $eventer->repository(
            repository: new Mock\ProductRepository(),
            immutableAttributes: true,
        );
        
        $this->assertInstanceof(EventsRepositoryAdapter::class, $repository);        
    }
    
    public function testRepositoryMethodWithReadRepository()
    {
        $eventer = new Eventer(
            eventDispatcher: new Events(),
        );
        
        $repository = $eventer->repository(
            repository: new Mock\ProductReadRepository(),
            immutableAttributes: true,
        );
        
        $this->assertInstanceof(EventsRepositoryAdapter::class, $repository);        
    }

    public function testRepositoryMethodWithWriteRepository()
    {
        $eventer = new Eventer(
            eventDispatcher: new Events(),
        );
        
        $repository = $eventer->repository(
            repository: new Mock\ProductWriteRepository(),
            immutableAttributes: true,
        );
        
        $this->assertInstanceof(EventsRepositoryAdapter::class, $repository);        
    }
}