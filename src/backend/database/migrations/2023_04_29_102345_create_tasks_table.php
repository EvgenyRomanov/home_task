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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->unsignedBigInteger('engineer_id')->nullable();

            $table->index('status_id', 'task_status_idx');
            $table->foreign('status_id', 'task_status_fk')->on('statuses')->references('id');

            $table->index('engineer_id', 'task_engineer_idx');
            $table->foreign('engineer_id', 'task_engineer_fk')->on('engineers')->references('id');

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
