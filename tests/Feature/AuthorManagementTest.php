<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Author;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{

    use RefreshDatabase;

     /** @test */
     public function an_author_can_be_created()
    {
        $this->withExceptionHandling();
        $this->post(route('add-author'), [
            'name' => 'Allen',
            'dob' => '1991/11/21'
        ]);

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1991/21/11', $author->first()->dob->format('Y/d/m'));
    }
}
