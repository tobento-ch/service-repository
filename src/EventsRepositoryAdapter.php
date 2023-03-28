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

namespace Tobento\Service\Repository;

use Psr\EventDispatcher\EventDispatcherInterface;
use Tobento\Service\Collection\Collection;
use Tobento\Service\Iterable\Iter;

/**
 * EventsRepositoryAdapter
 */
class EventsRepositoryAdapter implements RepositoryInterface
{
    /**
     * Create a new EventRepositoryAdapter.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ReadRepositoryInterface|WriteRepositoryInterface $repository
     * @param bool $immutableAttributes
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected ReadRepositoryInterface|WriteRepositoryInterface $repository,
        protected bool $immutableAttributes = false,
    ) {}

    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string $id
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findById(int|string $id): null|object
    {
        if (! $this->repository instanceof ReadRepositoryInterface) {
            throw new RepositoryReadException('Read methods are not supported by the repository.');
        }
                
        $entity = $this->repository->findById(id: $id);
        
        $this->eventDispatcher->dispatch(
            new Event\Retrieved(
                entity: $entity,
                entities: null,
                repository: $this->repository,
            )
        );
        
        return $entity;
    }
    
    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string ...$ids
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findByIds(int|string ...$ids): iterable
    {
        if (! $this->repository instanceof ReadRepositoryInterface) {
            throw new RepositoryReadException('Read methods are not supported by the repository.');
        }
                
        $entities = $this->repository->findByIds(...$ids);
        
        $this->eventDispatcher->dispatch(
            new Event\Retrieved(
                entity: null,
                entities: $entities,
                repository: $this->repository,
            )
        );
        
        return $entities;
    }

    /**
     * Returns the found entity using the specified where parameters
     * or null if none found.
     *
     * @param array $where
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findOne(array $where = []): null|object
    {
        if (! $this->repository instanceof ReadRepositoryInterface) {
            throw new RepositoryReadException('Read methods are not supported by the repository.');
        }
                
        $entity = $this->repository->findOne(where: $where);
        
        $this->eventDispatcher->dispatch(
            new Event\Retrieved(
                entity: $entity,
                entities: null,
                repository: $this->repository,
            )
        );
        
        return $entity;
    }

    /**
     * Returns the found entities using the specified parameters.
     *
     * @param array $where Usually where parameters.
     * @param array $orderBy The order by parameters.
     * @param null|int|array $limit The limit e.g. 5 or [5(number), 10(offset)].
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findAll(array $where = [], array $orderBy = [], null|int|array $limit = null): iterable
    {
        if (! $this->repository instanceof ReadRepositoryInterface) {
            throw new RepositoryReadException('Read methods are not supported by the repository.');
        }
        
        $entities = $this->repository->findAll(
            where: $where,
            orderBy: $orderBy,
            limit: $limit,
        );
        
        $this->eventDispatcher->dispatch(
            new Event\Retrieved(
                entity: null,
                entities: $entities,
                repository: $this->repository,
            )
        );
        
        return $entities;
    }
    
    /**
     * Create an entity.
     *
     * @param array $attributes
     * @return object The created entity.
     * @throws RepositoryCreateException
     */
    public function create(array $attributes): object
    {
        if (! $this->repository instanceof WriteRepositoryInterface) {
            throw new RepositoryCreateException(
                message: 'Write methods are not supported by the repository.'
            );
        }

        $eventAttributes = $this->eventDispatcher->dispatch(
            new Event\Creating(
                attributes: new Collection($attributes),
                repository: $this->repository,
            )
        )->attributes();
        
        $entity = $this->repository->create(
            attributes: $this->immutableAttributes ? $attributes : $eventAttributes->all(),
        );
        
        $this->eventDispatcher->dispatch(
            new Event\Created(
                entity: $entity,
                repository: $this->repository,
            )
        );
        
        return $entity;
    }
    
    /**
     * Update an entity by id.
     *
     * @param string|int $id
     * @param array $attributes The attributes to update the entity.
     * @return object The updated entity.
     * @throws RepositoryUpdateException
     */
    public function updateById(string|int $id, array $attributes): object
    {
        if (! $this->repository instanceof WriteRepositoryInterface) {
            throw new RepositoryUpdateException(
                id: $id,
                message: 'Write methods are not supported by the repository.'
            );
        }
        
        $entityToUpdate = null;
        
        $eventAttributes = $this->eventDispatcher->dispatch(
            new Event\Updating(
                attributes: new Collection($attributes),
                entity: $entityToUpdate,
                entities: null,
                repository: $this->repository,
            )
        )->attributes();
        
        $entity = $this->repository->updateById(
            id: $id,
            attributes: $this->immutableAttributes ? $attributes : $eventAttributes->all(),
        );
        
        $this->eventDispatcher->dispatch(
            new Event\Updated(
                entity: $entity,
                oldEntity: $entityToUpdate,
                repository: $this->repository,
            )
        );
        
        return $entity;
    }
    
    /**
     * Update entities.
     *
     * @param array $where The where parameters.
     * @param array $attributes The attributes to update the entities.
     * @return iterable<object> The updated entities.
     * @throws RepositoryUpdateException
     */
    public function update(array $where, array $attributes): iterable
    {
        if (! $this->repository instanceof WriteRepositoryInterface) {
            throw new RepositoryUpdateException(
                message: 'Write methods are not supported by the repository.'
            );
        }
        
        $entitiesToUpdate = null;
        
        if ($this->repository instanceof ReadRepositoryInterface) {
            $entitiesToUpdate = $this->repository->findAll(where: $where);
            $entitiesToUpdate = Iter::toArray(iterable: $entitiesToUpdate);
        }
        
        $eventAttributes = $this->eventDispatcher->dispatch(
            new Event\Updating(
                attributes: new Collection($attributes),
                entity: null,
                entities: $entitiesToUpdate,
                repository: $this->repository,
            )
        )->attributes();
        
        $entities = $this->repository->update(
            where: $where,
            attributes: $this->immutableAttributes ? $attributes : $eventAttributes->all(),
        );
        
        foreach($entities as $i => $entity) {
            $this->eventDispatcher->dispatch(
                new Event\Updated(
                    entity: $entity,
                    oldEntity: $entitiesToUpdate[$i] ?? null,
                    repository: $this->repository,
                )
            );
        }
        
        return $entities;
    }
    
    /**
     * Delete an entity by id.
     *
     * @param string|int $id
     * @return object The deleted entity.
     * @throws RepositoryDeleteException
     */
    public function deleteById(string|int $id): object
    {
        if (! $this->repository instanceof WriteRepositoryInterface) {
            throw new RepositoryDeleteException(
                id: $id,
                message: 'Write methods are not supported by the repository.'
            );
        }
        
        $entityToDelete = null;
        
        if ($this->repository instanceof ReadRepositoryInterface) {
            $entityToDelete = $this->repository->findById(id: $id);
        }
        
        $this->eventDispatcher->dispatch(
            new Event\Deleting(
                entity: $entityToDelete,
                entities: null,
                repository: $this->repository,
            )
        );
        
        $entity = $this->repository->deleteById(id: $id);
        
        $this->eventDispatcher->dispatch(
            new Event\Deleted(
                entity: $entity,
                repository: $this->repository,
            )
        );
        
        return $entity;
    }
    
    /**
     * Delete entities.
     *
     * @param array $where The where parameters.
     * @return iterable<object> The deleted entities.
     * @throws RepositoryDeleteException
     */
    public function delete(array $where): iterable
    {
        if (! $this->repository instanceof WriteRepositoryInterface) {
            throw new RepositoryDeleteException(
                message: 'Write methods are not supported by the repository.'
            );
        }
        
        $entitiesToDelete = null;
        
        if ($this->repository instanceof ReadRepositoryInterface) {
            $entitiesToDelete = $this->repository->findAll(where: $where);
        }
        
        $this->eventDispatcher->dispatch(
            new Event\Deleting(
                entity: null,
                entities: $entitiesToDelete,
                repository: $this->repository,
            )
        );
        
        $entities = $this->repository->delete(where: $where);
        
        foreach($entities as $entity) {
            $this->eventDispatcher->dispatch(
                new Event\Deleted(
                    entity: $entity,
                    repository: $this->repository,
                )
            );
        }
        
        return $entities;
    }
}