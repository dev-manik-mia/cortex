<?php

use Manik\Cortex\Testing\CortexFake;
use Manik\Cortex\Contracts\LLMDriver;
use Manik\Cortex\Contracts\EmbeddingDriver;

it('implements LLMDriver contract', function () {
    $fake = new CortexFake;

    expect($fake)->toBeInstanceOf(LLMDriver::class);
});

it('implements EmbeddingDriver contract', function () {
    $fake = new CortexFake;

    expect($fake)->toBeInstanceOf(EmbeddingDriver::class);
});

it('returns fake chat response', function () {
    $fake = new CortexFake;

    $response = $fake->chat([['role' => 'user', 'content' => 'Hi']]);

    expect($response)
        ->toHaveKey('content')
        ->toHaveKey('role')
        ->and($response['content'])->toBe('fake response')
        ->and($response['role'])->toBe('assistant');
});

it('returns fake stream response', function () {
    $fake = new CortexFake;

    $stream = $fake->stream([['role' => 'user', 'content' => 'Hi']]);
    $output = '';
    foreach ($stream as $chunk) {
        $output .= $chunk['content'];
    }

    expect($output)->toBe('fake response');
});

it('returns fake tools response', function () {
    $fake = new CortexFake;

    $response = $fake->tools([['role' => 'user', 'content' => 'Hi']], []);

    expect($response)
        ->toHaveKey('content')
        ->and($response['content'])->toBe('fake response');
});

it('returns fake embedding', function () {
    $fake = new CortexFake;

    $result = $fake->embed('test text');

    expect($result)
        ->toHaveKey('embedding')
        ->toHaveKey('dimensions')
        ->toHaveKey('model')
        ->toHaveKey('provider')
        ->and($result['dimensions'])->toBe(1536)
        ->and(count($result['embedding']))->toBe(1536);
});

it('returns fake batch embeddings', function () {
    $fake = new CortexFake;

    $results = $fake->embedBatch(['text one', 'text two']);

    expect($results)->toBeArray()->toHaveCount(2);
});

it('returns dimensions', function () {
    $fake = new CortexFake;

    expect($fake->dimensions())->toBe(1536);
});

it('can set and get model', function () {
    $fake = new CortexFake;

    $fake->setModel('gpt-4o');

    expect($fake->getModel())->toBe('gpt-4o');
});

it('can set and get provider', function () {
    $fake = new CortexFake;

    $fake->setProvider('openai');

    expect($fake->getProvider())->toBe('openai');
});
