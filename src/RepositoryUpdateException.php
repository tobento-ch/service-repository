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

use Throwable;

/**
 * RepositoryUpdateException
 */
class RepositoryUpdateException extends RepositoryWriteException
{
    /**
     * Create a new RepositoryUpdateException.
     *
     * @param array $attributes
     * @param string|int $id
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected array $attributes = [],
        protected string|int $id = '',
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Returns the attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return $this->attributes;
    }
    
    /**
     * Returns the id.
     *
     * @return string|int
     */
    public function id(): string|int
    {
        return $this->id;
    }
}