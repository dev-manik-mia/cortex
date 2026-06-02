<?php

namespace Manik\Cortex\Facades;

use Illuminate\Support\Facades\Facade;
use Manik\Cortex\AIClient;

/**
 * @method static \Manik\Cortex\LLM\LLMManager llm(?string $provider = null)
 * @method static \Manik\Cortex\Embedding\EmbeddingManager embedding(?string $provider = null)
 * @method static \Manik\Cortex\Vector\VectorManager vector(?string $provider = null)
 * @method static \Manik\Cortex\Image\ImageManager image(?string $provider = null)
 * @method static \Manik\Cortex\Speech\SpeechManager speech(?string $provider = null)
 * @method static \Manik\Cortex\RAG\RAGManager rag()
 * @method static \Manik\Cortex\Memory\MemoryManager memory(?string $driver = null)
 * @method static \Manik\Cortex\Agent\Agent agent(?string $provider = null)
 * @method static \Manik\Cortex\Testing\CortexFake fake()
 * @method static \Manik\Cortex\AIClient chat()
 * @method static mixed stream()
 * @method static array embed()
 * @method static array vectorSearch()
 *
 * @see AIClient
 */
class Cortex extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cortex';
    }

    public static function chat(): AIClient
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }
}
