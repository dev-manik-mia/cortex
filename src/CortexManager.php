<?php

namespace Manik\Cortex;

use Manik\Cortex\Contracts\EmbeddingDriver;
use Manik\Cortex\Contracts\ImageDriver;
use Manik\Cortex\Contracts\LLMDriver;
use Manik\Cortex\Contracts\SpeechDriver;
use Manik\Cortex\Contracts\VectorDriver;

class CortexManager
{
    protected array $llmDrivers = [];

    protected array $embeddingDrivers = [];

    protected array $vectorDrivers = [];

    protected array $imageDrivers = [];

    protected array $speechDrivers = [];

    public function __construct(
        public LLM\LLMManager $llm,
        public Embedding\EmbeddingManager $embedding,
        public Vector\VectorManager $vector,
        public Image\ImageManager $image,
        public Speech\SpeechManager $speech,
        public RAG\RAGManager $rag,
        public Memory\MemoryManager $memory,
    ) {}

    public function llm(?string $provider = null): LLMDriver
    {
        return $this->llm->driver($provider);
    }

    public function embedding(?string $provider = null): EmbeddingDriver
    {
        return $this->embedding->driver($provider);
    }

    public function vector(?string $provider = null): VectorDriver
    {
        return $this->vector->driver($provider);
    }

    public function image(?string $provider = null): ImageDriver
    {
        return $this->image->driver($provider);
    }

    public function speech(?string $provider = null): SpeechDriver
    {
        return $this->speech->driver($provider);
    }

    public function rag(): RAG\RAGManager
    {
        return $this->rag;
    }

    public function memory(?string $driver = null): Memory\MemoryManager
    {
        return $this->memory;
    }

    public function agent(?string $provider = null): Agent\Agent
    {
        return new Agent\Agent(
            $this->llm->driver($provider),
            $this->memory,
        );
    }

    public function fake(): Testing\CortexFake
    {
        return new Testing\CortexFake;
    }
}
