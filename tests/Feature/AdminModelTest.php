<?php

namespace Javaabu\Helpers\Tests\Feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Javaabu\Helpers\AdminModel\AdminModel;
use Javaabu\Helpers\AdminModel\IsAdminModel;
use Javaabu\Helpers\Tests\TestCase;

class CategoryWithDateCast extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected $casts = [
        'published_at' => 'date'
    ];

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class CategoryWithDateTimeCast extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $guarded = [
    ];

    public function getAdminUrlAttribute(): string
    {
        return '';
    }
}

class CategoryWithSearchable extends Model implements AdminModel
{
    use IsAdminModel;

    protected $table = 'categories';

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
    use RefreshDatabase;

    /** @test */
    public function it_can_get_list_of_date_fields(): void
    {
        $this->assertEquals([
            'published_at' => 'Published At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ], CategoryWithDateCast::getDateFieldsList());
    }

    /** @test */
    public function it_can_determine_if_an_attribute_is_an_allowed_date_field(): void
    {
        $this->assertTrue(CategoryWithDateCast::isAllowedDateField('published_at'));
        $this->assertTrue(CategoryWithDateCast::isAllowedDateField('created_at'));
        $this->assertTrue(CategoryWithDateCast::isAllowedDateField('updated_at'));
        $this->assertFalse(CategoryWithDateCast::isAllowedDateField('name'));
    }

    /** @test */
    public function it_can_determine_date_fields_from_date_casts(): void
    {
        $category = new CategoryWithDateCast();

        $this->assertEquals(['published_at', 'created_at', 'updated_at'], $category->getDateAttributes());
    }

    /** @test */
    public function it_can_determine_date_fields_from_datetime_casts(): void
    {
        $category = new CategoryWithDateTimeCast();

        $this->assertEquals(['published_at', 'created_at', 'updated_at'], $category->getDateAttributes());
    }

    /** @test */
    public function it_can_filter_models_by_date_range(): void
    {
        $category = new CategoryWithDateCast([
            'name' => 'Apple',
            'slug' => 'some-slug',
            'published_at' => '2024-02-11'
        ]);
        $category->save();

        $found = CategoryWithDateCast::dateBetween('published_at', '2024-02-10', '2024-02-12')->first();

        $this->assertEquals($category->id, $found->id);
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
