<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->datetime("fecha");
            $table->string("cod_factura");
            $table->bigInteger("user_id")->unsigned();
            $table->bigInteger("cliente_id")->unsigned();
            // N:1
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("cliente_id")->references("id")->on("clientes");            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
