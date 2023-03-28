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
 * Event after entity is created.
 */
class Created
{
    /**
     * Create a new Created event.
     *
     * @param object $entity The entity created.
     * @param WriteRepositoryInterface $repository
     */
    public function __construct(
        protected object $entity,
        protected WriteRepositoryInterface $repository,
    ) {}

    /**
     * Returns the entity created.
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