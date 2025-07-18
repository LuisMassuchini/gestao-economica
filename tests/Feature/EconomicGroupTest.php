<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EconomicGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EconomicGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Garante que utilizadores não autenticados são redirecionados para o login.
     */
    public function unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/economic-groups');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * @test
     * Garante que utilizadores autenticados conseguem ver a página.
     */
    public function authenticated_users_can_view_economic_groups_page(): void
    {
        $user = User::factory()->create();
        $group = EconomicGroup::factory()->create(['name' => 'Grupo de Teste Visível']);

        $response = $this->actingAs($user)->get('/economic-groups');

        $response->assertStatus(200);
        $response->assertSee('Grupo de Teste Visível');
    }

    /**
     * @test
     * Garante que um utilizador pode criar um grupo económico.
     */
    public function user_can_create_an_economic_group(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/economic-groups', [
            'name' => 'Novo Grupo Criado no Teste',
        ]);

        $response->assertRedirect('/economic-groups');
        $this->assertDatabaseHas('economic_groups', [
            'name' => 'Novo Grupo Criado no Teste',
        ]);
    }

    /**
     * @test
     * NOVO TESTE: Garante que a validação falha se o nome estiver em branco.
     */
    public function validation_fails_if_name_is_empty_on_creation(): void
    {
        $user = User::factory()->create();

        // Tentamos criar um grupo com o campo 'name' vazio.
        $response = $this->actingAs($user)->post('/economic-groups', [
            'name' => '',
        ]);

        // Verificamos se a sessão contém um erro de validação para o campo 'name'.
        $response->assertSessionHasErrors('name');
    }

    /**
     * @test
     * NOVO TESTE: Garante que um utilizador pode atualizar um grupo económico.
     */
    public function user_can_update_an_economic_group(): void
    {
        $user = User::factory()->create();
        $group = EconomicGroup::factory()->create(['name' => 'Nome Antigo']);

        // Simulamos o envio do formulário de edição (requisição PUT).
        $response = $this->actingAs($user)->put('/economic-groups/' . $group->id, [
            'name' => 'Nome Atualizado',
        ]);

        $response->assertRedirect('/economic-groups');

        // Verificamos se a base de dados foi atualizada corretamente.
        $this->assertDatabaseHas('economic_groups', [
            'id' => $group->id,
            'name' => 'Nome Atualizado',
        ]);
    }

    /**
     * @test
     * NOVO TESTE: Garante que um utilizador pode apagar um grupo económico.
     */
    public function user_can_delete_an_economic_group(): void
    {
        $user = User::factory()->create();
        $group = EconomicGroup::factory()->create();

        // Simulamos o envio do formulário de exclusão (requisição DELETE).
        $response = $this->actingAs($user)->delete('/economic-groups/' . $group->id);

        $response->assertRedirect('/economic-groups');

        // Verificamos se o registo foi removido da base de dados.
        $this->assertDatabaseMissing('economic_groups', [
            'id' => $group->id,
        ]);
    }
}
