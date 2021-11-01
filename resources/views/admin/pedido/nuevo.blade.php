@extends("layouts.admin")

@section("titulo", "Nuevo Pedido")

@section("css")
 <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
 
@endsection

@section("js")
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
  $(function () {
    $("#table-producto").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table-producto_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>
    // carrito
    let carrito = [];
    let cliente_id;

    function adicionarCarrito(prod){
        prod = JSON.parse(prod);
        let sw = 0;
        for (let i = 0; i < carrito.length; i++) {
          const prod_carrito = carrito[i];
          if(prod_carrito.id == prod.id){
            sw=1;
            prod_carrito.cantidad = prod_carrito.cantidad + 1
          }          
        }
        if(sw==0){
          let producto = {id: prod.id, nombre: prod.nombre, precio: prod.precio, cantidad: 1};
          carrito.push(producto);
        }
        actualizarCarrito();
    }

    function actualizarCarrito(){
        let html = ``;
        let total = 0;
        for (let i = 0; i < carrito.length; i++) {
            const element = carrito[i];
            html = html + `
                        <tr>
                            <td>${element.nombre}</td>
                            <td>${element.precio}</td>
                            <td>${element.cantidad}</td>
                            <td>
                                <button class="btn btn-danger" onclick="quitarCarrito(${i})">x</button>
                            </td>
                        </tr>
            `;
            total += parseFloat((element.precio * element.cantidad));  
            
        }
        total = total.toFixed(2)
        document.getElementById("carrito").innerHTML = html;
        document.getElementById("total").innerHTML = total
    }

    function quitarCarrito(posicion){
        carrito.splice(posicion, 1);
        actualizarCarrito();
    }

    async function buscarCliente(){
      document.getElementById("buscar").innerHTML = "Buscando..."
      console.log(document.getElementById("valor").value)
      let {data} = await axios.get("/api/admin/buscar_cliente");
      if(Object.keys(data).length === 0){
        document.getElementById("buscar").innerHTML = "Cliente NO ENCONTRADO"
      }
    }

    async function guardarCliente(){
      nombre_completo = document.getElementById("nombre_completo").value
      ci_nit = document.getElementById("ci_nit").value
      telefono = document.getElementById("telefono").value
      correo = document.getElementById("correo").value

      let datos_cliente = {
        nombre_completo: nombre_completo,
        ci_nit: ci_nit,
        telefono: telefono,
        correo: correo
      }
      const {data} = await axios.post("/api/admin/cliente", datos_cliente);
      console.log(data)
      document.getElementById("cliente").innerHTML = data.cliente.ci_nit
      document.getElementById("buscar").innerHTML = data.mensaje
      cliente_id = data.cliente.id;
    }

    async function realizarPedido(){
      let datos = {
        productos = carrito,
        cliente_id = cliente_id,        
      }
      const {data} = await axios.post("/api/admin/pedido", datos);
      
    }

</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection

@section("contenido")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>CORREO PERSONAL: {{Auth::user()->email}}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3>LISTA PRODUCTOS</h3>

                <table id="table-producto" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>NOMBRE</th>
      <th>PRECIO</th>
      <th>STOCK</th>
      <th>CATEGORIA</th>
      <th>ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($lista_productos as $producto)
    <tr>
      <td>{{ $producto->id }}</td>
      <td>{{ $producto->nombre }}</td>
      <td>{{ $producto->precio }}</td>
      <td>{{ $producto->stock }}</td>
      <td>{{ $producto->categoria->nombre }}</td>
      <td>
        <button class="btn btn-primary btn-xs" onclick="adicionarCarrito('{{$producto}}')">adicionar</button>
    
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>DETALLES</h3>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody id="carrito">
                        
                    </tbody>
                </table>
                <h2> TOTAL: Bs. <span id="total"></span></h2>
                <hr>

                <table class="table">
                <tr>
                  <td>
                    <h5>CI/NIT: <span id="cliente"></span></h5>
                    <strong><span id="buscar"></span></strong>
                  </td>
                </tr>
                  <tr>
                  <label for="">Buscar CI o NIT</label>
                    <td><input type="text" id="valor" class="form-control" placeholder="ci / nit" onkeyup="buscarCliente()"></td>
                  </tr>
                  <tr>
                    <td>

                    <!-- Button trigger modal -->
<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#Modal">
Nuevo Cliente
</button>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label for="">Nombre Completo</label>
      <input type="text" class="form-control" id="nombre_completo">
      <label for="">CI / NIT</label>
      <input type="text" class="form-control" id="ci_nit">
      <label for="">Telefono</label>
      <input type="text" class="form-control" id="telefono">
      <label for="">Correo</label>
      <input type="email" class="form-control" id="correo">    



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarCliente()">Guardar Cliente</button>
      </div>
    </div>
  </div>
</div>

                    </td>
                  </tr>
                  <tr>
                  <td>
                    <button class="btn btn-success btn-block" onclick="realizarPedido()">Realizar Pedido</button>
                  </td>
                  </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection