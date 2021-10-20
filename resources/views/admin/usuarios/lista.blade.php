@extends("layouts.admin")

@section("titulo", "Lista de Usuarios")

@section("contenido")
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Lista de usuarios
                    <br>
                    @auth
                        <p>{{ Auth::user()->email }}</p>
                    @else
                      no esta logueado 
                    @endauth
                </h5>
            </div>
        </div>
    </div>
</div>
@endsection