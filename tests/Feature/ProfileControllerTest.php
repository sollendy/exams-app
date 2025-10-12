<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa che la pagina del profilo venga visualizzata.
     *
     * @return void
     */
    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('profile.edit'));

        $response->assertOk()
            ->assertViewIs('profile.edit')
            ->assertViewHas('user', $user);
    }

    /**
     * Testa l'aggiornamento delle informazioni del profilo.
     *
     * @return void
     */
    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $data);

        $response->assertRedirect(route('profile.edit'))
            ->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertSame('Updated User', $user->name);
        $this->assertSame('updated@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    /**
     * Testa che l'email non venga modificata se non è cambiata.
     *
     * @return void
     */
    public function test_email_verification_status_is_unchanged_when_email_is_unchanged(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Updated User',
            'email' => $user->email,
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $data);

        $response->assertRedirect(route('profile.edit'))
            ->assertSessionHas('status', 'profile-updated');

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * Testa che l'utente possa cancellare il proprio account.
     *
     * @return void
     */
    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('profile.destroy'), [
                'password' => 'user1234',
            ]);

        $response->assertRedirect('/')
            ->assertSessionHasNoErrors();

        $this->assertNull(User::find($user->id));
        $this->assertGuest();
    }

    /**
     * Testa che la cancellazione dell'account fallisca con una password errata.
     *
     * @return void
     */
    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->delete(route('profile.destroy'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect(route('profile.edit'));

        $this->assertNotNull(User::find($user->id));
    }
}
