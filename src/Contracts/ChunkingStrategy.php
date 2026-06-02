<?php

namespace Manik\Cortex\Contracts;

interface ChunkingStrategy
{
    public function chunk(string $text, array $options = []): array;
}
