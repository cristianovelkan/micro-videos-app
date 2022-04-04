<?php

namespace Tests\Unit\Models;

use App\Models\Genre;
use PHPUnit\Framework\TestCase;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenreTest extends TestCase
{
    private $genre;

    protected function setUp(): void
    {
        parent::setUp();
        $this->genre = new Genre();
    }

    public function testFillable()
    {
        $genre = new Genre();
        $fillable = ["name", "is_active"];
        $this->assertEquals($fillable, $genre->getFillable());
    }

    public function testIfUseTraits()
    {
        $genreTraits = array_keys(class_uses(Genre::class));
        $traits = [
            SoftDeletes::class,
            Uuid::class
        ];

        $this->assertEquals($traits, $genreTraits);
    }

    public function testDatesAttribute()
    {
        $dates = ['deleted_at', 'created_at', 'updated_at'];
        foreach ($dates as $date) {
            $this->assertContains($date, $this->genre->getDates());
        }
        $this->assertCount(count($dates), $this->genre->getDates());
    }

    public function testCastsAttribute()
    {
        $casts = [
            'id' => 'string',
            'is_active' => 'boolean',
        ];
        $this->assertEquals($casts, $this->genre->getCasts());
    }
}
