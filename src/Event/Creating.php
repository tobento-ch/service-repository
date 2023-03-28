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
 * Event before entity is created.
 */
class Creating
{
    /**
     * Create a new Creating event.
     *
     * @param Collection $attributes
     * @param WriteRepositoryInterface $repository
     */
    public function __construct(
        protected Collection $attributes,
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
     * Returns the repository.
     *
     * @return WriteRepositoryInterface
     */
    public function repository(): WriteRepositoryInterface
    {
        return $this->repository;
    }
}