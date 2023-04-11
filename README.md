# Repository Service

Repository interfaces for PHP applications.

## Table of Contents

- [Getting started](#getting-started)
    - [Requirements](#requirements)
    - [Highlights](#highlights)
- [Documentation](#documentation)
    - [Interfaces](#interfaces)
        - [Repository Interface](#repository-interface)
        - [Read Repository Interface](#read-repository-interface)
        - [Write Repository Interface](#write-repository-interface)
        - [Entity Factory Interface](#entity-factory-interface)
    - [Read Only Repository Adapter](#read-only-repository-adapter)
    - [Events Repository Adapter](#events-repository-adapter)
        - [Eventer](#eventer)
- [Credits](#credits)
___

# Getting started

Add the latest version of the repository service project running this command.

```
composer require tobento/service-repository
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

# Documentation

## Interfaces

### Repository Interface

```php
namespace Tobento\Service\Repository;

interface RepositoryInterface extends ReadRepositoryInterface, WriteRepositoryInterface
{
    //
}
```

### Read Repository Interface

```php
namespace Tobento\Service\Repository;

interface ReadRepositoryInterface
{
    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string $id
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findById(int|string $id): null|object;
    
    /**
     * Returns the found entity using the specified id (primary key)
     * or null if none found.
     *
     * @param int|string ...$ids
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findByIds(int|string ...$ids): iterable;

    /**
     * Returns the found entity using the specified where parameters
     * or null if none found.
     *
     * @param array $where
     * @return null|object
     * @throws RepositoryReadException
     */
    public function findOne(array $where = []): null|object;

    /**
     * Returns the found entities using the specified parameters.
     *
     * @param array $where Usually where parameters.
     * @param array $orderBy The order by parameters.
     * @param null|int|array $limit The limit e.g. 5 or [5(number), 10(offset)].
     * @return iterable<object>
     * @throws RepositoryReadException
     */
    public function findAll(array $where = [], array $orderBy = [], null|int|array $limit = null): iterable;
    
    /**
     * Returns the number of items using the specified where parameters.
     *
     * @param array $where
     * @return int
     * @throws RepositoryReadException
     */
    public function count(array $where = []): int;
}
```

### Write Repository Interface

```php
namespace Tobento\Service\Repository;

interface WriteRepositoryInterface
{
    /**
     * Create an entity.
     *
     * @param array $attributes
     * @return object The created entity.
     * @throws RepositoryCreateException
     */
    public function create(array $attributes): object;
    
    /**
     * Update an entity by id.
     *
     * @param string|int $id
     * @param array $attributes The attributes to update the entity.
     * @return object The updated entity.
     * @throws RepositoryUpdateException
     */
    public function updateById(string|int $id, array $attributes): object;
    
    /**
     * Update entities.
     *
     * @param array $where The where parameters.
     * @param array $attributes The attributes to update the entities.
     * @return iterable<object> The updated entities.
     * @throws RepositoryUpdateException
     */
    public function update(array $where, array $attributes): iterable;
    
    /**
     * Delete an entity by id.
     *
     * @param string|int $id
     * @return object The deleted entity.
     * @throws RepositoryDeleteException
     */
    public function deleteById(string|int $id): object;
    
    /**
     * Delete entities.
     *
     * @param array $where The where parameters.
     * @return iterable<object> The deleted entities.
     * @throws RepositoryDeleteException
     */
    public function delete(array $where): iterable;
}
```

### Entity Factory Interface

```php
namespace Tobento\Service\Repository;

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
```

## Read Only Repository Adapter

Any repository implementing the ```RepositoryInterface::class``` can be made read-only by decorating them using the ```ReadOnlyRepositoryAdapter::class```:

```php
use Tobento\Service\Repository\ReadOnlyRepositoryAdapter;
use Tobento\Service\Repository\RepositoryInterface;

$readOnlyRepository = new ReadOnlyRepositoryAdapter(
    repository: $repository, // RepositoryInterface
);
```

## Events Repository Adapter

Any repository implementing the ```ReadRepositoryInterface::class``` or ```WriteRepositoryInterface::class``` can be made to dispatch default events by decorating them using the ```EventsRepositoryAdapter::class```:

```php
use Psr\EventDispatcher\EventDispatcherInterface;
use Tobento\Service\Repository\EventsRepositoryAdapter;
use Tobento\Service\Repository\ReadRepositoryInterface;
use Tobento\Service\Repository\WriteRepositoryInterface;
use Tobento\Service\Repository\Event;

$eventsRepository = new EventsRepositoryAdapter(
    eventDispatcher: $eventDispatcher, // EventDispatcherInterface
    repository: $repository, // ReadRepositoryInterface or WriteRepositoryInterface
    
    // if false (default) event attributes get used on write methods
    immutableAttributes: false,
);
```

**Default Events**

| Event | Description |
| --- | --- |
| ```Event\Retrieved::class``` | The event will dispatch **after** an entity is retrieved from the read methods only. |
| ```Event\Creating::class``` | The event will dispatch **before** an entity is created. |
| ```Event\Created::class``` | The event will dispatch **after** an entity is created. |
| ```Event\Updating::class``` | The event will dispatch **before** an entity is updated. |
| ```Event\Updated::class``` | The event will dispatch **after** an entity is updated. |
| ```Event\Deleting::class``` | The event will dispatch **before** an entity is deleted. |
| ```Event\Deleted::class``` | The event will dispatch **after** an entity is deleted. |

### Eventer

The eventer may be used to easily create a ```EventsRepositoryAdapter::class``` if you want only to have certain events dispatched.

**Create Eventer**

```php
use Psr\EventDispatcher\EventDispatcherInterface;
use Tobento\Service\Repository\EventerInterface;
use Tobento\Service\Repository\Eventer;

$eventer = new Eventer(
    eventDispatcher: $eventDispatcher, // EventDispatcherInterface
);

var_dump($eventer instanceof EventerInterface);
// bool(true)
```

**Using Eventer**

```php
use Tobento\Service\Repository\EventerInterface;

class SomeService
{
    public function createAction(EventerInterface $eventer)
    {
        $entity = $eventer
            ->repository($this->someRepository)
            ->create(['title' => 'Lorem']);
        
        // or
        $entity = $eventer
            ->repository(
                repository: $this->someRepository,
                immutableAttributes: true, // default is false
            )
            ->create(['title' => 'Lorem']);            
    }
}
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)