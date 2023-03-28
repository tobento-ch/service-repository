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

/**
 * Event before the entity is deleted.
 */
class Deleting
{
    /**
     * Create a new Deleting event.
     *
     * @param null|object $entity
     * @param null|iterable $entities
     * @param WriteRepositoryInterface $repository
     */
    public function __construct(
        protected null|object $entity,
        protected null|iterable $entities,
        protected WriteRepositoryInterface $repository,
    ) {}
    
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