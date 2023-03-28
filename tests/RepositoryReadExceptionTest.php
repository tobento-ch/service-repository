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
use Tobento\Service\Repository\RepositoryReadException;
use Tobento\Service\Repository\RepositoryException;

/**
 * RepositoryReadExceptionTest
 */
class RepositoryReadExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new RepositoryReadException(message: 'Message');
        
        $this->assertInstanceof(RepositoryException::class, $e);
        $this->assertSame('Message', $e->getMessage());
    }
}