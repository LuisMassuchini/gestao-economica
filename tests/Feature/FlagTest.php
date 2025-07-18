<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Flag;
use App\Models\EconomicGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Garante que utilizadores não autenticados não conseguem aceder à página de bandeiras.
     */
    public function unauthenticated_users_cannot_access_flags_page(): void
    {
        $response = $this->get('/flags');
        $response->assertRedirect('/login');
    }

    /**
     * @test
     * Garante que um utilizador autenticado consegue ver a página de listagem de bandeiras.
     */
    public function authenticated_user_can_view_flags_page(): void
    {
        $user = User::factory()->create();
        $flag = Flag::factory()->create(['name' => 'Bandeira de Teste']);

        $response = $this->actingAs($user)->get('/flags');

        $response->assertStatus(200);
        $response->assertSee('Bandeira de Teste');
    }

    /**
     * @test
     * Garante que um utilizador pode criar uma nova bandeira.
     */
    public function user_can_create_a_flag(): void
    {
        $user = User::factory()->create();
        // Precisamos de um grupo económico para associar a bandeira.
        $economicGroup = EconomicGroup::factory()->create();

        $response = $this->actingAs($user)->post('/flags', [
            'name' => 'Nova Bandeira de Teste',
            'economic_group_id' => $economicGroup->id,
        ]);

        $response->assertRedirect('/flags');
        $this->assertDatabaseHas('flags', [
            'name' => 'Nova Bandeira de Teste',
            'economic_group_id' => $economicGroup->id,
        ]);
    }

    /**
     * @test
     * Garante que a validação falha se o ID do grupo económico não for enviado.
     */
    public function validation_fails_if_economic_group_is_not_provided(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/flags', [
            'name' => 'Bandeira Sem Grupo',
            'economic_group_id' => '', // ID em branco
        ]);

        // Verificamos se a sessão contém um erro de validação para o campo 'economic_group_id'.
        $response->assertSessionHasErrors('economic_group_id');
    }

    /**
     * @test
     * Garante que um utilizador pode atualizar uma bandeira.
     */
    public function user_can_update_a_flag(): void
    {
        $user = User::factory()->create();
        $flag = Flag::factory()->create();
        // Criamos um segundo grupo para testar a mudança de associação.
        $newEconomicGroup = EconomicGroup::factory()->create();

        $response = $this->actingAs($user)->put('/flags/' . $flag->id, [
            'name' => 'Nome da Bandeira Atualizado',
            'economic_group_id' => $newEconomicGroup->id,
        ]);

        $response->assertRedirect('/flags');
        $this->assertDatabaseHas('flags', [
            'id' => $flag->id,
            'name' => 'Nome da Bandeira Atualizado',
            'economic_group_id' => $newEconomicGroup->id,
        ]);
    }

    /**
     * @test
     * Garante que um utilizador pode apagar uma bandeira.
     */
    public function user_can_delete_a_flag(): void
    {
        $user = User::factory()->create();
        $flag = Flag::factory()->create();

        $response = $this->actingAs($user)->delete('/flags/' . $flag->id);

        $response->assertRedirect('/flags');
        $this->assertDatabaseMissing('flags', [
            'id' => $flag->id,
        ]);
    }
}
