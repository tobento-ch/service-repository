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
use Tobento\Service\Repository\RepositoryCreateException;
use Tobento\Service\Repository\RepositoryException;

/**
 * RepositoryCreateExceptionTest
 */
class RepositoryCreateExceptionTest extends TestCase
{
    public function testException()
    {
        $e = new RepositoryCreateException(message: 'Message');
        
        $this->assertInstanceof(RepositoryException::class, $e);
        $this->assertSame('Message', $e->getMessage());
        $this->assertSame([], $e->attributes());
    }
    
    public function testWithAttributes()
    {
        $e = new RepositoryCreateException(attributes: ['key' => 'value']);
        
        $this->assertSame(['key' => 'value'], $e->attributes());
    }
}