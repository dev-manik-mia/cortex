<?php

namespace Manik\Cortex\Speech;

use Illuminate\Contracts\Container\Container;
use Manik\Cortex\Contracts\SpeechDriver;
use Manik\Cortex\Exceptions\CortexException;

class SpeechManager
{
    protected array $drivers = [];

    public function __construct(
        protected ?Container $app = null,
    ) {}

    public function driver(?string $name = null): SpeechDriver
    {
        $name ??= config('ai.defaults.speech', 'openai');

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

    protected function resolve(string $name): SpeechDriver
    {
        $config = config("ai.speech.{$name}");

        if ($config === null) {
            throw CortexException::invalidProvider($name, 'Speech');
        }

        return match ($config['driver']) {
            'openai' => new Drivers\OpenAISpeechDriver($config),
            default => throw CortexException::invalidProvider($name, 'Speech'),
        };
    }
}
