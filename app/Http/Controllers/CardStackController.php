<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardStackController extends Controller
{
    public function index()
    {
         // Simular una colección de items como arrays asociativos
         $items = collect([
            (object)['nombre' => 'Item 1', 'descripcion' => 'Descripción del Item 1'],
            (object)['nombre' => 'Item 2', 'descripcion' => 'Descripción del Item 2'],
            // Agrega más items según sea necesario
        ]);

        // Pasar los items a la vista 'card-stack.blade.php'
        return view('tablero', ['items' => $items]);
    }

    public function createItem(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Agrega más reglas de validación según sea necesario
        ]);

        // Crear un nuevo item en la base de datos
        Item::create([
            'nombre' => $request->input('nombre'),
            // Agrega más campos según sea necesario
        ]);

        // Redirigir de nuevo a la página del card stack
        return redirect('/card-stack');
    }
}
