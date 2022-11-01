<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))->assertOk()->assertSee('Авторизация')->assertViewIs('auth.login');
    }

    /**
     * @test
     */
    public function it_registration_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))->assertOk()->assertSee('Регистрация')->assertViewIs('auth.registration');
    }

    /**
     * @test
     */
    public function it_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))->assertOk()->assertSee('Восстановление доступа')->assertViewIs('auth.forgot-password');
    }

    /**
     * @test
     */
    public function it_sign_in_success(): void
    {

        $password = '12345678';

        $user = UserFactory::new()->create([
            'email' => 'test_signin@igor.vip',
            'password' => bcrypt($password),
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);

    }

    /**
     * @test
     */
    public function it_logout_success(): void
    {

        $user = UserFactory::new()->create();

        $this->actingAs($user)->delete(action([SignInController::class, 'logOut']));

        $this->assertGuest();

    }

    /**
     * @test
     */
    public function it_signup_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'test_signup@igor.vip',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(action([SignUpController::class, 'handle']), $request);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        $user = User::query()->where('email', $request['email'])->first();

        Event::assertDispatched(Registered::class);

        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));

    }
}
