<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Factura</title>
</head>
<body>
    <h1>Receta: {{ $recipe->nombre }}</h1>
    <h2 class="float-left">Ingredientes</h2>
    <ul class="columns-3">
        @foreach ($ingredients as $ingredient_has_recipe)
            @php
                $ingredient = $ingredient_has_recipe->ingrediente()->first();

            @endphp
            <li class="mb-2"> {{$ingredient->nombre}} </li>
        @endforeach
    </ul>
    <h2 class="float-left"> Pasos </h2>
        @foreach ($steps as $step)
            Paso {{$step->orden}}
        <ul>
            <li class="mb-2">
                {{ $step->descripcion }}
            </li>
        </ul>


        @endforeach
    </div>
</body>
</html>
