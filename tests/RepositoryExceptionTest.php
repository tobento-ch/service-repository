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

namespace Tobento\Service\Repository\Test;

use PHPUnit\Framework\TestCase;
use Tobento\Service\Repository\RepositoryException;
use RuntimeException;

/**
 * RepositoryExceptionTest
 */
class RepositoryExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new RepositoryException(message: 'Message');
        
        $this->assertInstanceof(RuntimeException::class, $e);
        $this->assertSame('Message', $e->getMessage());
    }
}