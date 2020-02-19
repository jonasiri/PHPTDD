<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AuthorTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function only_name_is_required_for_author() {
        Author::firstOrCreate([
            'name' => 'John'
        ]);

        $this->assertCount(1, Author::all());
    }
}
