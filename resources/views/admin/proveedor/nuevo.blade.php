@extends("layouts.admin")

@section("titulo", "Nuevo Proveedor")

@section("contenido")

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('proveedor.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="">Nombre Proveedor</label>
                        <input type="text" class="form-control" name="nombre">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">telefono contacto</label>
                                <input type="text" class="form-control" name="telefono_contacto">

                            </div>
                            <div class="col-md-6">
                                <label for="">NIT</label>
                                <input type="text" class="form-control" name="nit">

                            </div>
                            <div class="col-md-12">
                                <label for="">Nombre Contacto</label>
                                <input type="text" class="form-control" name="nombre_contacto">

                            </div>
                            <div class="col-md-12">
                                <label for="">dirección</label>
                                <input type="text" class="form-control" name="direccion">

                            </div>

                        </div>
                        <input type="submit" class="btn btn-success" value="Guardar Proveedor">                       
                        
                    </form>
                
                </div>
            </div>
        </div>
    </div>
@endsection