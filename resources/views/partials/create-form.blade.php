<form method="POST" action="{{ route('crear.item') }}">
    @csrf
    <!-- Agregar campos del formulario para los detalles del nuevo item -->
    <input type="text" name="nombre" placeholder="Nombre del Item" required>

    <!-- Agregar más campos según sea necesario -->

    <button type="submit">Crear Item</button>
</form>