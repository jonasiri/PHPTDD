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
        $this->post(route('add-author'), $this->data());

        $author = Author::all();
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1991/21/11', $author->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function a_name_is_required() {
        $response = $this->post(route('add-author'), array_merge($this->data(), ['name'=>'']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_dob_is_required() {
        $response = $this->post(route('add-author'), array_merge($this->data(), ['dob'=>'']));

        $response->assertSessionHasErrors('dob');
    }

    private function data() {
        return [
            'name' => 'Allen',
            'dob' => '1991/11/21'
        ];
    }


}
