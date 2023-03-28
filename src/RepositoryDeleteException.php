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
 * RepositoryDeleteException
 */
class RepositoryDeleteException extends RepositoryWriteException
{
    /**
     * Create a new RepositoryDeleteException.
     *
     * @param string|int $id
     * @param string $message The message
     * @param int $code
     * @param null|Throwable $previous
     */
    public function __construct(
        protected string|int $id = '',
        string $message = '',
        int $code = 0,
        null|Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
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