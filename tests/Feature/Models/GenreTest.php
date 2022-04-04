<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testList()
    {
        factory(Genre::class, 1)->create();

        $genres = Genre::all();
        $this->assertCount(1, $genres);

        $genreKey = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $genreKey
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'test'
        ]);

        $genre->refresh();
        $this->assertEquals('test', $genre->name);


        $genre = Genre::create([
            'name' => 'test',
            'is_active' => false
        ]);
        $this->assertFalse($genre->is_active);

        $genre = Genre::create([
            'name' => 'test',
            'is_active' => true
        ]);
        $this->assertTrue($genre->is_active);

        $genre = Genre::create([
            'name' => 'test uuid',
        ]);
        $this->assertTrue(Uuid::isValid($genre->id));
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create()->first();

        $data = [
            'name' => 'name_updated',
            'is_active' => false
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();

        $genre->delete();
        $this->assertNull(Genre::find($genre->id));
    }
}
