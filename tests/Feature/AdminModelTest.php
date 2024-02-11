<?php

namespace Javaabu\Helpers\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Javaabu\Helpers\AdminModel\AdminModel;
use Javaabu\Helpers\AdminModel\IsAdminModel;
use Javaabu\Helpers\Tests\TestCase;
use Javaabu\Helpers\Tests\InteractsWithDatabase;

class CategoryWithSearchable extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected static array $dateFields = [
        'created_at',
        'updated_at'
    ];

    protected array $searchable = [
        'name'
    ];

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class CategoryWithStringSearchable extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected string $searchable = 'name';

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class CategoryWithMultipleSearchable extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected array $searchable = [
        'slug',
        'name'
    ];

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class CategoryWithoutSearchable extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class AdminModelTest extends TestCase
{
    use InteractsWithDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->runMigrations();
    }

    /** @test */
    public function it_can_search_models_using_a_partial_match(): void
    {
        $category = new CategoryWithSearchable(['name' => 'Apple', 'slug' => 'some-slug']);
        $category->save();

        $found = CategoryWithSearchable::search('pple')->first();

        $this->assertEquals($category->id, $found->id);
    }

    /** @test */
    public function it_can_search_models_using_a_single_searchable(): void
    {
        $category = new CategoryWithSearchable(['name' => 'Apple', 'slug' => 'some-slug']);
        $category->save();

        $found = CategoryWithSearchable::search('Apple')->first();

        $this->assertEquals($category->id, $found->id);
        $this->assertNull(CategoryWithSearchable::search('some-slug')->first());
    }

    /** @test */
    public function it_can_search_models_using_a_string_searchable(): void
    {
        $category = new CategoryWithStringSearchable(['name' => 'Apple', 'slug' => 'some-slug']);
        $category->save();

        $found = CategoryWithStringSearchable::search('Apple')->first();

        $this->assertEquals($category->id, $found->id);
        $this->assertNull(CategoryWithStringSearchable::search('some-slug')->first());
    }

    /** @test */
    public function it_can_search_models_using_multiple_searchables(): void
    {
        $category = new CategoryWithMultipleSearchable(['name' => 'Apple', 'slug' => 'some-slug']);
        $category->save();

        $found = CategoryWithMultipleSearchable::search('Apple')->first();

        $this->assertEquals($category->id, $found->id);

        $found = CategoryWithMultipleSearchable::search('some-slug')->first();

        $this->assertEquals($category->id, $found->id);
    }

    /** @test */
    public function it_can_search_models_without_searchable(): void
    {
        $category = new CategoryWithoutSearchable(['name' => 'Apple', 'slug' => 'some-slug']);
        $category->save();

        $found = CategoryWithoutSearchable::search($category->id)->first();

        $this->assertEquals($category->id, $found->id);
        $this->assertNull(CategoryWithoutSearchable::search('Apple')->first());
        $this->assertNull(CategoryWithoutSearchable::search('some-slug')->first());
    }
}
