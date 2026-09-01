<?php

namespace Tests\Feature;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ResetPasswordFlowTest extends TestCase
{
    public function test_reset_password_mailable_uses_an_existing_template_and_route(): void
    {
        $user = new User();
        $user->firstName = 'Ada';
        $user->lastName = 'Lovelace';
        $user->email = 'ada@example.com';

        $this->assertTrue(view()->exists('emails.reset-password'));

        $mailable = new ResetPasswordMail($user, 'token-123');
        $rendered = $mailable->render();

        $this->assertStringContainsString('Reset your password', $rendered);
        $this->assertStringContainsString('token-123', $rendered);
        $this->assertStringContainsString('email=ada%40example.com', $rendered);
    }

    public function test_reset_password_email_is_sent_immediately_without_queueing(): void
    {
        $user = new User();
        $user->firstName = 'Grace';
        $user->lastName = 'Hopper';
        $user->email = 'grace@example.com';

        $mailable = new ResetPasswordMail($user, 'queue-test-token');

        $this->assertFalse(is_a($mailable, \Illuminate\Contracts\Queue\ShouldQueue::class, true));
    }

    public function test_user_model_points_to_the_real_project_table_name(): void
    {
        $this->assertSame('user', (new User())->getTable());
    }

    public function test_forgot_password_form_submits_to_the_backend_route_without_demo_blocker(): void
    {
        $html = view('auth.forgot-password')->render();

        $this->assertStringContainsString("action=\"" . route('password.email') . "\"", $html);
        $this->assertStringNotContainsString('data-demo-submit', $html);
    }
}
