<?php

namespace Manik\Cortex\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Application;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Manik\Cortex\RAG\RAGManager;

class IndexingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $path,
        public string $collection,
        public array $options = [],
    ) {}

    public function handle(Application $app): void
    {
        $rag = $app->make(RAGManager::class);
        $rag->ingest($this->path, $this->collection, $this->options);
    }
}
