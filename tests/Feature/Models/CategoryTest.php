<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testList()
    {
        factory(Category::class, 1)->create();

        $categories = Category::all();
        $this->assertCount(1, $categories);

        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKey
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'test'
        ]);

        $category->refresh();
        $this->assertEquals('test', $category->name);
        $this->assertNull($category->description);


        $category = Category::create([
            'name' => 'test',
            'description' => 'test description',
        ]);
        $this->assertEquals('test description', $category->description);

        $category = Category::create([
            'name' => 'test',
            'description' => null,
        ]);
        $this->assertNull($category->description);


        $category = Category::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($category->is_active);

        $category = Category::create([
            'name' => 'test',
            'is_active' => true
        ]);
        $this->assertTrue($category->is_active);

        $category = Category::create([
            'name' => 'test uuid',
        ]);
        $this->assertTrue(Uuid::isValid($category->id));
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'test_description'
        ])->first();

        $data = [
            'name' => 'name_updated',
            'description' => 'test_description_updated',
            'is_active' => false
        ];

        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create([
            'name' => 'test_delete'
        ]);

        $category->delete();
        $this->assertNull(Category::find($category->id));
    }
}
