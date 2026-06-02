<?php

namespace Manik\Cortex\Memory;

use Illuminate\Contracts\Container\Container;
use Manik\Cortex\Contracts\MemoryDriver;
use Manik\Cortex\Memory\Drivers\ConversationMemoryDriver;
use Manik\Cortex\Memory\Drivers\PersistentMemoryDriver;
use Manik\Cortex\Memory\Drivers\SessionMemoryDriver;

class MemoryManager
{
    protected array $drivers = [];

    public function __construct(
        protected ?Container $app = null,
    ) {}

    public function driver(?string $name = null): MemoryDriver
    {
        $name ??= config('ai.memory.default', 'session');

        if (! isset($this->drivers[$name])) {
            $this->drivers[$name] = $this->resolve($name);
        }

        return $this->drivers[$name];
    }

    public function extend(string $name, callable $resolver): static
    {
        $this->drivers[$name] = $resolver($this->app);

        return $this;
    }

    protected function resolve(string $name): MemoryDriver
    {
        $config = config("ai.memory.drivers.{$name}");

        return match ($config['driver']) {
            'session' => new SessionMemoryDriver($config),
            'conversation' => new ConversationMemoryDriver($config),
            'persistent' => new PersistentMemoryDriver($config),
            default => throw new \InvalidArgumentException("Unknown memory driver: {$name}"),
        };
    }
}
