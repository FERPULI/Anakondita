<?php

use Mockery as m;

// -------------------------------------------------------------------
// Test 1: Verificar que getAll() traiga los datos
// -------------------------------------------------------------------
test('Usuario getAll prepara la consulta SQL correcta', function () {
    // 1. Arrange (Preparar)
    $stmtSimulado = m::mock(PDOStatement::class);
    $stmtSimulado->shouldReceive('execute')->once()->andReturn(true);

    $dbSimulada = m::mock(PDO::class);
    $sqlEsperado = "SELECT id, dni, nombres, apellidos, correo FROM usuarios";
    
    $dbSimulada->shouldReceive('prepare')
        ->with($sqlEsperado)
        ->once()
        ->andReturn($stmtSimulado);

    // 2. Act (Actuar)
    $usuario = new \Usuario($dbSimulada); 
    $resultado = $usuario->getAll();

    // 3. Assert (Verificar)
    expect($resultado)->toBe($stmtSimulado);
});

// -------------------------------------------------------------------
// Test 2: Verificar que create() guarde los datos
// -------------------------------------------------------------------
test('Usuario create inserta un nuevo registro con los datos correctos', function () {
    // 1. Arrange (Preparar)
    $stmtSimulado = m::mock(PDOStatement::class);
    
    // Esperamos que bindParam se llame 4 veces (para :dni, :nombres, :apellidos, :correo)
    $stmtSimulado->shouldReceive('bindParam')->times(4);
    
    // Esperamos que se ejecute la consulta
    $stmtSimulado->shouldReceive('execute')->once()->andReturn(true);

    $dbSimulada = m::mock(PDO::class);
    
    // El SQL exacto que tienes en tu modelo
    $sqlEsperado = "INSERT INTO usuarios (dni, nombres, apellidos, correo) VALUES (:dni, :nombres, :apellidos, :correo)";
    
    $dbSimulada->shouldReceive('prepare')
        ->with($sqlEsperado)
        ->once()
        ->andReturn($stmtSimulado);

    // 2. Act (Actuar)
    $usuario = new \Usuario($dbSimulada);
    
    // Llenamos los datos del usuario
    $usuario->dni = '12345678';
    $usuario->nombres = 'Juan';
    $usuario->apellidos = 'Perez';
    $usuario->correo = 'juan@ejemplo.com';

    $resultado = $usuario->create();

    // 3. Assert (Verificar)
    // Esperamos que devuelva true (que es lo que devuelve $stmt->execute())
    expect($resultado)->toBeTrue();
});

// -------------------------------------------------------------------
// Limpieza obligatoria de Mockery después de cada prueba
// -------------------------------------------------------------------
afterEach(function () {
    m::close();
});