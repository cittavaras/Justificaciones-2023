<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSeeLoginForm()
    {
        $response = $this->get('/login');
        $response->assertOk();
        $response->assertViewIs('login');
        $response->assertSee('Sistema de Justificaciones');
    }

    public function testAssertLoginAsStudentNotActive()
    {
        $user = "A.ABARCAA@ALUMNOS.DUOC.CL";
        $password = '$2y$10$GfgRJk0R54QhwVnyZ.CzPu2Z2PizuDII7d/BjJMTsXU6Y3cJXyqXy';
        $response = $this->post('/login', ['email' => $user, 'password' => $password]);
        $response->assertRedirect('/alumno/index');
        $response->assertSee('Cambiar Contraseña');
    }
}
