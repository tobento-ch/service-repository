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

/**
 * EntityFactoryInterface
 */
interface EntityFactoryInterface
{
    /**
     * Create an entity from array.
     *
     * @param array $attributes
     * @return object The created entity.
     */
    public function createEntityFromArray(array $attributes): object;
}