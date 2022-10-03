<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCascadeDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('workflows.db_prefix').'task_logs', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned()->change();
            $table->foreign('task_id')->references('id')->on(config('workflows.db_prefix').'tasks')->onDelete('cascade');
        });

        Schema::table(config('workflows.db_prefix').'tasks', function (Blueprint $table) {
            $table->dropIndex(['workflow_id']);
            $table->bigInteger('workflow_id')->unsigned()->change();
            $table->foreign('workflow_id')->references('id')->on(config('workflows.db_prefix').'workflows')->onDelete('cascade');
        });

        Schema::table(config('workflows.db_prefix').'triggers', function (Blueprint $table) {
            $table->bigInteger('workflow_id')->unsigned()->change();
            $table->foreign('workflow_id')->references('id')->on(config('workflows.db_prefix').'workflows')->onDelete('cascade');
        });

        Schema::table(config('workflows.db_prefix').'workflow_logs', function (Blueprint $table) {
            $table->bigInteger('workflow_id')->unsigned()->change();
            $table->foreign('workflow_id')->references('id')->on(config('workflows.db_prefix').'workflows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('workflows.db_prefix').'tasks', function (Blueprint $table) {
            $table->dropForeign(['workflow_id']);
        });

        Schema::table(config('workflows.db_prefix').'triggers', function (Blueprint $table) {
            $table->dropForeign(['workflow_id']);
        });

        Schema::table(config('workflows.db_prefix').'workflow_logs', function (Blueprint $table) {
            $table->dropForeign(['workflow_id']);
        });

        Schema::table(config('workflows.db_prefix').'task_logs', function (Blueprint $table) {
            $table->dropForeign(['task_id']);
        });
    }
}
