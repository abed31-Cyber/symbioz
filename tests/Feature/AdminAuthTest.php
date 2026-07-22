<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Authentification du back-office (EPIC 4).
 */
class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Login OK : redirection vers le tableau de bord (US-2.6).
     */
    public function test_admin_can_authenticate_and_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Login KO : message générique, aucune session ouverte (anti-énumération).
     */
    public function test_admin_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email'    => $user->email,
            'password' => 'mauvais-mot-de-passe',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /**
     * Accès protégé : visiteur non connecté redirigé vers le login.
     */
    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    /**
     * Accès autorisé : admin connecté atteint le tableau de bord.
     */
    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    /**
     * 404 admin : URL inexistante sous /admin pour un admin connecté.
     */
    public function test_admin_sees_admin_404_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin/page-inexistante')
            ->assertNotFound()
            ->assertSee('Retour au tableau de bord');
    }
}
