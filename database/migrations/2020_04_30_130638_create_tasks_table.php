<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('workflows.db_prefix').'tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('workflow_id')->index();
            $table->bigInteger('parentable_id')->nullable()->index();
            $table->string('parentable_type')->nullable()->index();
            $table->string('type');
            $table->string('name');
            $table->json('data_fields')->nullable();
            $table->json('conditions')->nullable();
            $table->integer('node_id')->nullable();
            $table->integer('pos_x')->default(0);
            $table->integer('pos_y')->default(0);
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
        Schema::dropIfExists('tasks');
    }
}
