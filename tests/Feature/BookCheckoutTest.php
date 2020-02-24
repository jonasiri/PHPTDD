<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Reservation;
use Illuminate\Support\Facades\Auth;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user() {

        $book = factory(Book::class)->create();

        $this->actingAs($user = factory(User::class)->create())
            ->post(route('checkout-book', $book));

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);

    }

    /** @test */
    public function only_sign_in_users_can_checkout_book() {
        $book = factory(Book::class)->create();

        $this->post(route('checkout-book', $book))
        ->assertRedirect(route('login'));

    $this->assertCount(0, Reservation::all());
    }

    /** @test */
    public function only_real_books_can_be_checked_out() {

        $book = factory(Book::class)->make();

        // $this->expectException(\Exception::class);

        $this->actingAs($user = factory(User::class)->create())
            ->post(route('checkout-book', $book))
            ->assertStatus(404);;

        $this->assertCount(0, Reservation::all());

    }

     /** @test */
     public function a_book_can_be_checked_in_by_a_signed_in_user() {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user)
        ->post(route('checkout-book', $book));

        $this->actingAs($user)
            ->post(route('check-in-book', $book));

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);

    }
    /** @test */
    public function only_signed_in_users_can_check_in_book() {

        $book = factory(Book::class)->create();

        $user = factory(User::class)->create();
        $this->actingAs($user)
        ->post(route('checkout-book', $book));

        Auth::logout();
        $this->post(route('check-in-book', $book))
        ->assertRedirect(route('login'));


        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);

    }

    /** @test */
   public function a_404_is_thrown_when_book_doesnt_exist() {

    $book = factory(Book::class)->create();
    $user = factory(User::class)->create();

    $this->actingAs($user)
        ->post(route('check-in-book', $book))
        ->assertStatus(404);

    $this->assertCount(0, Reservation::all());

    }

}
