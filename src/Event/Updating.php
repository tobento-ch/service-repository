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

namespace Tobento\Service\Repository\Event;

use Tobento\Service\Repository\WriteRepositoryInterface;
use Tobento\Service\Collection\Collection;

/**
 * Event before the entity is updated.
 */
class Updating
{
    /**
     * Create a new Updating event.
     *
     * @param Collection $attributes
     * @param null|object $entity The entity to update.
     * @param null|iterable $entities The entities to update.
     * @param WriteRepositoryInterface $repository
     */
    public function __construct(
        protected Collection $attributes,
        protected null|object $entity,
        protected null|iterable $entities,
        protected WriteRepositoryInterface $repository,
    ) {}
    
    /**
     * Returns the attributes.
     *
     * @return Collection
     */
    public function attributes(): Collection
    {
        return $this->attributes;
    }
    
    /**
     * Returns the entity.
     *
     * @return null|object
     */
    public function entity(): null|object
    {
        return $this->entity;
    }
    
    /**
     * Returns the entities.
     *
     * @return null|iterable
     */
    public function entities(): null|iterable
    {
        return $this->entities;
    }

    /**
     * Returns the repository.
     *
     * @return WriteRepositoryInterface
     */
    public function repository(): WriteRepositoryInterface
    {
        return $this->repository;
    }
}