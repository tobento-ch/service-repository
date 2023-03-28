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
 * Event after the entity is deleted.
 */
class Deleted
{
    /**
     * Create a new Deleted event.
     *
     * @param object $entity
     * @param WriteRepositoryInterface $repository
     */
    public function __construct(
        protected object $entity,
        protected WriteRepositoryInterface $repository,
    ) {}
    
    /**
     * Returns the entity.
     *
     * @return object
     */
    public function entity(): object
    {
        return $this->entity;
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