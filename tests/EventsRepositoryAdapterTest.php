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
use Tobento\Service\Repository\EventsRepositoryAdapter;
use Tobento\Service\Repository\Event;
use Tobento\Service\Repository\RepositoryReadException;
use Tobento\Service\Repository\RepositoryCreateException;
use Tobento\Service\Repository\RepositoryUpdateException;
use Tobento\Service\Repository\RepositoryDeleteException;
use Tobento\Service\Event\Events;
use Tobento\Service\Collection\Collection;
use Tobento\Service\Repository\Test\Mock;

/**
 * EventsRepositoryAdapterTest
 */
class EventsRepositoryAdapterTest extends TestCase
{
    public function testFindByIdMethod()
    {
        $repository = new Mock\ProductReadRepository();
        
        $collection = new Collection();
        $events = new Events();

        $events->listen(function(Event\Retrieved $event) use ($collection) {
            $collection->add('entity', $event->entity());
            $collection->add('entities', $event->entities());
            $collection->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
        );
        
        $entity = $eventsRepository->findById(id: 2);
        
        $this->assertSame(2, $entity?->id());
        $this->assertTrue($entity === $collection->get('entity'));
        $this->assertTrue(null === $collection->get('entities'));
        $this->assertTrue($repository === $collection->get('repository'));
    }
    
    public function testFindByIdMethodThrowsRepositoryReadExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryReadException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductWriteRepository(),
        );
        
        $entity = $eventsRepository->findById(id: 2);
    }
    
    public function testFindByIdsMethod()
    {
        $repository = new Mock\ProductReadRepository();
        
        $collection = new Collection();
        $events = new Events();

        $events->listen(function(Event\Retrieved $event) use ($collection) {
            $collection->add('entity', $event->entity());
            $collection->add('entities', $event->entities());
            $collection->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
        );
        
        $entities = $eventsRepository->findByIds(1,3,5);
        
        $this->assertSame(2, count($entities));
        $this->assertTrue(null === $collection->get('entity'));
        $this->assertTrue($entities === $collection->get('entities'));
        $this->assertTrue($repository === $collection->get('repository'));
    }
    
    public function testFindByIdsMethodThrowsRepositoryReadExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryReadException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductWriteRepository(),
        );
        
        $entities = $eventsRepository->findByIds(id: 2);
    }
    
    public function testFindOneMethod()
    {
        $repository = new Mock\ProductReadRepository();
        
        $collection = new Collection();
        $events = new Events();

        $events->listen(function(Event\Retrieved $event) use ($collection) {
            $collection->add('entity', $event->entity());
            $collection->add('entities', $event->entities());
            $collection->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
        );
        
        $entity = $eventsRepository->findOne(where: ['id' => 2]);
        
        $this->assertSame(2, $entity?->id());
        $this->assertTrue($entity === $collection->get('entity'));
        $this->assertTrue(null === $collection->get('entities'));
        $this->assertTrue($repository === $collection->get('repository'));
    }
    
    public function testFindOneMethodThrowsRepositoryReadExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryReadException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductWriteRepository(),
        );
        
        $entity = $eventsRepository->findOne(where: ['id' => 2]);
    }
    
    public function testFindAllMethod()
    {
        $repository = new Mock\ProductReadRepository();
        
        $collection = new Collection();
        $events = new Events();

        $events->listen(function(Event\Retrieved $event) use ($collection) {
            $collection->add('entity', $event->entity());
            $collection->add('entities', $event->entities());
            $collection->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
        );
        
        $entities = $eventsRepository->findAll();
        
        $this->assertSame(3, count($entities));
        $this->assertTrue(null === $collection->get('entity'));
        $this->assertTrue($entities === $collection->get('entities'));
        $this->assertTrue($repository === $collection->get('repository'));
    }
    
    public function testFindAllMethodThrowsRepositoryReadExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryReadException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductWriteRepository(),
        );
        
        $entities = $eventsRepository->findAll();
    }
    
    public function testCountMethod()
    {
        $repository = new Mock\ProductReadRepository();
        
        $collection = new Collection();
        $events = new Events();
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
        );
        
        $this->assertSame(3, $eventsRepository->count());
    }
    
    public function testCountMethodThrowsRepositoryReadExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryReadException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductWriteRepository(),
        );
        
        $eventsRepository->count();
    }
    
    public function testCreateMethod()
    {
        $repository = new Mock\ProductWriteRepository();
        
        $creating = new Collection();
        $created = new Collection();
        $events = new Events();

        $events->listen(function(Event\Creating $event) use ($creating) {
            $event->attributes()->set('sku', 'foo');
            $creating->add('attributes', $event->attributes());
            $creating->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Created $event) use ($created) {
            $created->add('entity', $event->entity());
            $created->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: false,
        );
        
        $entity = $eventsRepository->create(['id' => 4]);
        
        $this->assertSame(4, $entity?->id());
        $this->assertSame('foo', $entity?->sku());
        $this->assertSame(['id' => 4, 'sku' => 'foo'], $creating->get('attributes')->all());
        $this->assertTrue($repository === $creating->get('repository'));
        $this->assertTrue($entity === $created->get('entity'));
        $this->assertTrue($repository === $created->get('repository'));
    }
    
    public function testCreateMethodWithImmutableAttributes()
    {
        $repository = new Mock\ProductWriteRepository();
        
        $creating = new Collection();
        $created = new Collection();
        $events = new Events();

        $events->listen(function(Event\Creating $event) use ($creating) {
            $event->attributes()->set('sku', 'foo');
            $creating->add('attributes', $event->attributes());
            $creating->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Created $event) use ($created) {
            $created->add('entity', $event->entity());
            $created->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: true,
        );
        
        $entity = $eventsRepository->create(['id' => 4]);
        
        $this->assertSame(4, $entity?->id());
        $this->assertSame('', $entity?->sku());
        $this->assertSame(['id' => 4, 'sku' => 'foo'], $creating->get('attributes')->all());
        $this->assertTrue($repository === $creating->get('repository'));
        $this->assertTrue($entity === $created->get('entity'));
        $this->assertTrue($repository === $created->get('repository'));
    }
    
    public function testCreateMethodThrowsRepositoryCreateExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryCreateException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductReadRepository(),
        );
        
        $entity = $eventsRepository->create(['id' => 4]);
    }
    
    public function testUpdateByIdMethod()
    {
        $repository = new Mock\ProductWriteRepository();
        
        $updating = new Collection();
        $updated = new Collection();
        $events = new Events();

        $events->listen(function(Event\Updating $event) use ($updating) {
            $event->attributes()->set('sku', 'foo');
            $updating->add('attributes', $event->attributes());
            $updating->add('entity', $event->entity());
            $updating->add('entities', $event->entities());
            $updating->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Updated $event) use ($updated) {
            $updated->add('entity', $event->entity());
            $updated->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: false,
        );
        
        $entity = $eventsRepository->updateById(id: 2, attributes: ['price' => 3.33]);
        
        $this->assertSame(2, $entity?->id());
        $this->assertSame(3.33, $entity?->price());
        $this->assertSame('foo', $entity?->sku());
        $this->assertSame(['price' => 3.33, 'sku' => 'foo'], $updating->get('attributes')->all());
        $this->assertSame(null, $updating->get('entity')); // as not read repository too
        $this->assertTrue(null === $updating->get('entities'));
        $this->assertTrue($repository === $updating->get('repository'));
        $this->assertTrue($entity === $updated->get('entity'));
        $this->assertTrue($repository === $updated->get('repository'));
    }
    
    public function testUpdateByIdMethodThrowsRepositoryUpdateExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryUpdateException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductReadRepository(),
        );
        
        $entity = $eventsRepository->updateById(id: 2, attributes: ['price' => 3.33]);
    }
    
    public function testUpdateMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $updating = new Collection();
        $updated = new Collection();
        $events = new Events();

        $events->listen(function(Event\Updating $event) use ($updating) {
            $event->attributes()->set('sku', 'foo');
            $updating->add('attributes', $event->attributes());
            $updating->add('entity', $event->entity());
            $updating->add('entities', $event->entities());
            $updating->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Updated $event) use ($updated) {
            $updated->add('entity.'.$event->entity()?->id(), $event->entity());
            $updated->add('oldEntity.'.$event->oldEntity()?->id(), $event->oldEntity());
            $updated->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: false,
        );
        
        $entities = $eventsRepository->update(where: [], attributes: ['price' => 3.33]);
        $firstEntity = $entities[1] ?? null;
        
        $this->assertSame(3, count($entities));        
        $this->assertSame(1, $firstEntity?->id());
        $this->assertSame(3.33, $firstEntity?->price());
        $this->assertSame('foo', $firstEntity?->sku());
        $this->assertSame(null, $updating->get('entity'));
        $this->assertTrue(null !== $updating->get('entities'));
        $this->assertTrue($repository === $updating->get('repository'));
        $this->assertTrue($firstEntity === $updated->get('entity.1'));
        $this->assertSame(1.2, $updated->get('oldEntity.1')?->price());
        $this->assertTrue($repository === $updated->get('repository'));
    }
    
    public function testUpdateMethodThrowsRepositoryUpdateExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryUpdateException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductReadRepository(),
        );
        
        $entity = $eventsRepository->update(where: [], attributes: ['price' => 3.33]);
    }
    
    public function testDeleteByIdMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $deleting = new Collection();
        $deleted = new Collection();
        $events = new Events();

        $events->listen(function(Event\Deleting $event) use ($deleting) {
            $deleting->add('entity', $event->entity());
            $deleting->add('entities', $event->entities());
            $deleting->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Deleted $event) use ($deleted) {
            $deleted->add('entity', $event->entity());
            $deleted->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: false,
        );
        
        $entity = $eventsRepository->deleteById(id: 2);
        
        $this->assertSame(2, $entity?->id());
        $this->assertSame(2, $deleting->get('entity')?->id());
        $this->assertTrue(null === $deleting->get('entities'));
        $this->assertTrue($repository === $deleting->get('repository'));
        $this->assertTrue($entity === $deleted->get('entity'));
        $this->assertTrue($repository === $deleted->get('repository'));
    }
    
    public function testDeleteByIdMethodThrowsRepositoryDeleteExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryDeleteException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductReadRepository(),
        );
        
        $entity = $eventsRepository->deleteById(id: 2);
    }
    
    public function testDeleteMethod()
    {
        $repository = new Mock\ProductRepository();
        
        $deleting = new Collection();
        $deleted = new Collection();
        $events = new Events();

        $events->listen(function(Event\Deleting $event) use ($deleting) {
            $deleting->add('entity', $event->entity());
            $deleting->add('entities', $event->entities());
            $deleting->add('repository', $event->repository());
        });
        
        $events->listen(function(Event\Deleted $event) use ($deleted) {
            $deleted->add('entity.'.$event->entity()?->id(), $event->entity());
            $deleted->add('repository', $event->repository());
        });
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: $events,
            repository: $repository,
            immutableAttributes: false,
        );
        
        $entities = $eventsRepository->delete(where: []);
        $firstEntity = $entities[1] ?? null;
        
        $this->assertSame(3, count($entities));        
        $this->assertSame(1, $firstEntity?->id());
        $this->assertSame(1.2, $firstEntity?->price());
        $this->assertSame('paper', $firstEntity?->sku());
        $this->assertSame(null, $deleting->get('entity'));
        $this->assertSame(3, count($deleting->get('entities')));
        $this->assertTrue($repository === $deleting->get('repository'));
        $this->assertTrue($firstEntity === $deleted->get('entity.1'));
        $this->assertTrue($repository === $deleted->get('repository'));
    }
    
    public function testDeleteMethodThrowsRepositoryDeleteExceptionIfUnsupportedRepository()
    {
        $this->expectException(RepositoryDeleteException::class);
        
        $eventsRepository = new EventsRepositoryAdapter(
            eventDispatcher: new Events(),
            repository: new Mock\ProductReadRepository(),
        );
        
        $entity = $eventsRepository->delete(where: []);
    }
}