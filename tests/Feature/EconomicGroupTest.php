<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EconomicGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EconomicGroupTest extends TestCase
{
    // Este 'trait' faz com que a base de dados seja reiniciada antes de cada teste.
    // Isto garante que os testes são isolados e não interferem uns com os outros.
    use RefreshDatabase;

    /**
     * Teste 1: Garante que utilizadores não autenticados são redirecionados para o login.
     * O nome do teste descreve exatamente o que ele faz.
     */
    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        // Simula uma requisição GET para a página de listagem de grupos económicos.
        $response = $this->get('/economic-groups');

        // Verifica se a resposta foi um redirecionamento (código 302)
        // e se foi para a rota de login.
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Teste 2: Garante que utilizadores autenticados conseguem ver a página.
     * Este é o "caminho feliz".
     */
    public function test_authenticated_users_can_view_economic_groups_page(): void
    {
        // 1. Cria um utilizador falso em memória usando a Factory.
        $user = User::factory()->create();

        // 2. Cria um grupo económico para garantir que a lista não está vazia.
        $group = EconomicGroup::factory()->create(['name' => 'Grupo de Teste Visível']);

        // 3. Simula que este utilizador está logado e faz a requisição.
        $response = $this->actingAs($user)->get('/economic-groups');

        // 4. Verifica se a página foi carregada com sucesso (código 200).
        $response->assertStatus(200);

        // 5. Verifica se o nome do grupo que criámos está visível na página.
        $response->assertSee('Grupo de Teste Visível');
    }

    /**
     * Teste 3: Garante que um utilizador pode criar um grupo económico.
     */
    public function test_user_can_create_an_economic_group(): void
    {
        $user = User::factory()->create();

        // Simula o envio de um formulário (requisição POST).
        $response = $this->actingAs($user)->post('/economic-groups', [
            'name' => 'Novo Grupo Criado no Teste',
        ]);

        // Verifica se, após a criação, o utilizador é redirecionado para a página de listagem.
        $response->assertRedirect('/economic-groups');

        // Verifica se o novo grupo realmente existe na base de dados.
        $this->assertDatabaseHas('economic_groups', [
            'name' => 'Novo Grupo Criado no Teste',
        ]);
    }
}
