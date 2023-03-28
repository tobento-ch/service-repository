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

use Tobento\Service\Repository\ReadRepositoryInterface;

/**
 * Event after the entity is retrieved.
 */
class Retrieved
{
    /**
     * Create a new Retrieved event.
     *
     * @param null|object $entity The entity to update.
     * @param null|iterable $entities The entities to update.
     * @param ReadRepositoryInterface $repository
     */
    public function __construct(
        protected null|object $entity,
        protected null|iterable $entities,
        protected ReadRepositoryInterface $repository,
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
     * @return ReadRepositoryInterface
     */
    public function repository(): ReadRepositoryInterface
    {
        return $this->repository;
    }
}