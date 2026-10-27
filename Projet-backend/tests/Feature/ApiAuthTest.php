<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin',
            'firstname' => 'Système',
            'email' => 'admin@inspections.com',
            'contact' => '+225 07 00 00 00',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);
    }

    public function test_login_returns_sanctum_token(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'admin@inspections.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token',
                     'user' => ['id', 'email', 'name', 'firstname', 'role'],
                     'message'
                 ]);
    }

    public function test_dashboard_stats_endpoint(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/v1/stat/month');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'total_inspections',
                     'inspectMois',
                     'inspection_images',
                     'augmentNbre',
                     'pourcentVsMoisPrec',
                     'cinqDerniers',
                 ]);
    }

    public function test_clients_endpoint(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/v1/clients');

        $response->assertStatus(200)
                 ->assertJsonStructure(['clients']);
    }

    public function test_users_endpoint(): void
    {
        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/v1/list/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'users' => ['data', 'current_page', 'total']
                 ]);
    }

    public function test_create_inspection_with_automatic_client_creation(): void
    {
        $payload = [
            'date_inspection' => '2026-10-27',
            'type_inspection' => 'Contrôle Sanitaire',
            'lieu_inspection' => 'Abidjan Plateau',
            'responsible_name' => 'Kouamé Entreprise',
            'observations' => 'Locaux propres et conformes aux normes.',
            'statut' => 'Conforme',
            'recommandations' => 'Poursuivre le plan de nettoyage.',
        ];

        $response = $this->actingAs($this->user, 'sanctum')
                         ->postJson('/api/v1/store/inspections', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'uuid',
                     'id',
                     'inspection'
                 ]);

        // Vérification que le client a bien été créé automatiquement
        $this->assertDatabaseHas('clients', [
            'nom' => 'Kouamé Entreprise'
        ]);

        $uuid = $response->json('uuid');

        // Test de consultation de l'inspection
        $showResponse = $this->actingAs($this->user, 'sanctum')
                             ->getJson('/api/v1/show/inspection/' . $uuid);

        $showResponse->assertStatus(200)
                     ->assertJsonPath('inspection.client', 'Kouamé Entreprise')
                     ->assertJsonPath('inspection.statut', 'Conforme');

        // Test de téléchargement du rapport PDF
        $pdfResponse = $this->actingAs($this->user, 'sanctum')
                            ->get('/api/v1/inspections/' . $uuid . '/report/download');

        $pdfResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $pdfResponse->headers->get('Content-Type'));

        // Test de liste des inspections avec pagination
        $listResponse = $this->actingAs($this->user, 'sanctum')
                            ->getJson('/api/v1/list/inspections?per_page=5');

        $listResponse->assertStatus(200)
                    ->assertJsonStructure([
                        'inspections' => [
                            'data',
                            'current_page',
                            'total',
                            'per_page'
                        ]
                    ]);
    }

    public function test_create_inspection_accepts_string_null_client_id(): void
    {
        $payload = [
            'date_inspection' => '2026-10-27',
            'type_inspection' => 'Contrôle Technique',
            'lieu_inspection' => 'Zone Industrielle',
            'client_id' => 'null',
            'responsible_name' => 'Auto Create Client Sarl',
            'statut' => 'Conforme',
        ];

        $response = $this->actingAs($this->user, 'sanctum')
                         ->postJson('/api/v1/store/inspections', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', [
            'nom' => 'Auto Create Client Sarl'
        ]);
    }
}
