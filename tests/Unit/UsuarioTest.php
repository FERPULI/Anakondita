<?php

use Mockery as m;

test('Usuario getAll prepara la consulta SQL correcta', function () {
    // 1. Simulamos el Statement y la Base de Datos
    $stmtSimulado = m::mock(PDOStatement::class);
    $stmtSimulado->shouldReceive('execute')->once()->andReturn(true);

    $dbSimulada = m::mock(PDO::class);
    
    // 2. Validamos que se pida ESTE SQL exacto
    $sqlEsperado = "SELECT id, dni, nombres, apellidos, correo FROM usuarios";
    
    $dbSimulada->shouldReceive('prepare')
        ->with($sqlEsperado)
        ->once()
        ->andReturn($stmtSimulado);

    // 3. Ejecutamos el modelo
    // NOTA: Si tu clase Usuario no tiene namespace, se llama así directo:
    $usuario = new \Usuario($dbSimulada); 
    $resultado = $usuario->getAll();

    // 4. Verificamos
    expect($resultado)->toBe($stmtSimulado);
});