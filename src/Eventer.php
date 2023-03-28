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

/**
 * Eventer: Factory to create a EventsRepositoryAdapter::class
 */
class Eventer implements EventerInterface
{
    /**
     * Create a new Eventer.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
    ) {}
    
    /**
     * Create a new EventsRepositoryAdapter with the specified repository.
     *
     * @param ReadRepositoryInterface|WriteRepositoryInterface $repository
     * @param bool $immutableAttributes
     * @return EventsRepositoryAdapter
     */
    public function repository(
        ReadRepositoryInterface|WriteRepositoryInterface $repository,
        bool $immutableAttributes = false,
    ): EventsRepositoryAdapter {
        return new EventsRepositoryAdapter(
            eventDispatcher: $this->eventDispatcher,
            repository: $repository,
            immutableAttributes: $immutableAttributes,
        );
    }
}