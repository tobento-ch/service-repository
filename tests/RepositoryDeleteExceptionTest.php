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
use Tobento\Service\Repository\RepositoryDeleteException;
use Tobento\Service\Repository\RepositoryException;

/**
 * RepositoryDeleteExceptionTest
 */
class RepositoryDeleteExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new RepositoryDeleteException(message: 'Message');
        
        $this->assertInstanceof(RepositoryException::class, $e);
        $this->assertSame('Message', $e->getMessage());
        $this->assertSame('', $e->id());
    }
    
    public function testWithId()
    {
        $e = new RepositoryDeleteException(id: 2);
        
        $this->assertSame(2, $e->id());
    }
}