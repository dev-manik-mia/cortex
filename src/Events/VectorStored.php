<?php

namespace Manik\Cortex\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VectorStored
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $provider,
        public string $collection,
        public int $recordCount,
    ) {}
}
