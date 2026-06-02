<?php

namespace Manik\Cortex\Image;

use Illuminate\Contracts\Container\Container;
use Manik\Cortex\Contracts\ImageDriver;
use Manik\Cortex\Exceptions\CortexException;

class ImageManager
{
    protected array $drivers = [];

    public function __construct(
        protected ?Container $app = null,
    ) {}

    public function driver(?string $name = null): ImageDriver
    {
        $name ??= config('ai.defaults.image', 'openai');

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

    protected function resolve(string $name): ImageDriver
    {
        $config = config("ai.image.{$name}");

        if ($config === null) {
            throw CortexException::invalidProvider($name, 'Image');
        }

        return match ($config['driver']) {
            'openai' => new Drivers\OpenAIImageDriver($config),
            default => throw CortexException::invalidProvider($name, 'Image'),
        };
    }
}
