<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
   use RefreshDatabase;

    private function getRegisterField($overides = []) {
        return array_merge([
            'name'                  => 'John Thor',
            'email'                 => 'username@example.net',
            'password'              => 'secret12',
            'password_confirmation' => 'secret12',
        ], $overides);
    }

   /** @test */
    public function user_can_register()
    {
        // Kunjungi halaman '/register'
        $this->visit('/register');

        // Submit form register dengan name, email dan password 2 kali
        $this->submitForm('Register', $this->getRegisterField());

        // Lihat halaman ter-redirect ke url '/home' (register sukses).
        $this->seePageIs('/home');

        // Kita melihat halaman tulisan "Dashboard" pada halaman itu.
        $this->seeText('Dashboard');

        // Lihat di database, tabel users, data user yang register sudah masuk
        $this->seeInDatabase('users', [
            'name'  => 'John Thor',
            'email' => 'username@example.net',
        ]);

        // Cek hash password yang tersimpan cocok dengan password yang diinput
        $this->assertTrue(app('hash')->check('secret12', User::first()->password));
    }

    /** @test */
    public function user_name_is_required()
    {
        $this->post('/register', $this->getRegisterField(['name' => '']));

        $this->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_name_maximum_is_255_char()
    {
        $this->post('/register',$this->getRegisterField(['name' => str_repeat('John Thor', 30)]));

        $this->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function user_email_is_required()
    {
        $this->post('/register', $this->getRegisterField(['email' => '']));

        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_must_be_valid()
    {
        $this->post('/register', $this->getRegisterField(['email' => 'username.example.net']));

        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_maximum_is_255_char()
    {
        $this->post('/register', $this->getRegisterField(['email' => str_repeat('username@example.net', 30)]));

        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_email_must_be_unique_on_users_table()
    {
        $user = factory(User::class)->create(['email' => 'sameemail@example.net']);

        $this->post('/register', $this->getRegisterField(['email' => 'sameemail@example.net']));

        $this->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function user_password_is_required()
    {
        $this->post('/register', $this->getRegisterField(['password' => '']));

        $this->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function user_password_mimimum_is_8_char()
    {
        $this->post('/register', $this->getRegisterField(['password' => 'secret']));

        $this->assertSessionHasErrors(['password']);
    }

    public function must_be_same_with_password_confirmation_field()
    {
        $this->post('/register', $this->getRegisterField(['password' => 'secret12', 'password_confirmation' => 'secret21']));

        $this->assertSessionHasErrors(['password']);
    }
}