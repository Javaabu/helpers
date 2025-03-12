<?php

namespace Javaabu\Helpers\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Helpers\Tests\TestCase;
use Javaabu\Helpers\Tests\TestSupport\Models\Post;
use PHPUnit\Framework\Attributes\Test;

class HasCachedSoftDeleteCountTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_check_whether_a_model_has_soft_deletes()
    {
        $post = new Post([
            'title' => 'test'
        ]);

        $post->save();

        $this->assertFalse(Post::hasRecordsInTrash());

        $post->delete();

        $this->assertTrue(Post::hasRecordsInTrash());

        $post->forceDelete();

        $this->assertFalse(Post::hasRecordsInTrash());
    }

    #[Test]
    public function it_clears_the_cached_soft_deletes_when_a_model_is_deleted()
    {
        $post = new Post([
            'title' => 'test'
        ]);

        $post->save();

        $this->assertFalse(Post::hasRecordsInTrash());
        $this->assertTrue(cache()->has(Post::getSoftDeleteCacheKey()));

        $post->delete();

        $this->assertFalse(cache()->has(Post::getSoftDeleteCacheKey()));
    }

    #[Test]
    public function it_clears_the_cached_soft_deletes_when_a_model_is_restored()
    {
        $post = new Post([
            'title' => 'test'
        ]);

        $post->save();

        $post->delete();

        $this->assertTrue(Post::hasRecordsInTrash());
        $this->assertTrue(cache()->has(Post::getSoftDeleteCacheKey()));

        $post->restore();

        $this->assertFalse(cache()->has(Post::getSoftDeleteCacheKey()));
    }
}
