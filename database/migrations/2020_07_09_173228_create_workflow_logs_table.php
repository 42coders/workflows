<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('workflows.db_prefix').'workflow_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('workflow_id');
            $table->bigInteger('elementable_id')->nullable()->index();
            $table->string('elementable_type')->nullable()->index();
            $table->bigInteger('triggerable_id')->nullable()->index();
            $table->string('triggerable_type')->nullable()->index();
            $table->string('name');
            $table->string('status');
            $table->text('message')->nullable();
            $table->text('databus')->nullable();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
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
        Schema::dropIfExists('workflow_logs');
    }
}
