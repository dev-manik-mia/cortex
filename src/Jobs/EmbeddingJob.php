<?php

namespace Manik\Cortex\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Application;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Manik\Cortex\Embedding\EmbeddingManager;

class EmbeddingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $text,
        public string $collection,
        public array $options = [],
    ) {}

    public function handle(Application $app): void
    {
        $embedding = $app->make(EmbeddingManager::class);
        $embedding->driver()->embed($this->text);
    }
}
