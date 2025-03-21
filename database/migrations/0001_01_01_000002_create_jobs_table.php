<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('queue')->index();
        //     $table->longText('payload');
        //     $table->unsignedTinyInteger('attempts');
        //     $table->unsignedInteger('reserved_at')->nullable();
        //     $table->unsignedInteger('available_at');
        //     $table->unsignedInteger('created_at');
        // });

        // Schema::create('job_batches', function (Blueprint $table) {
        //     $table->string('id')->primary();
        //     $table->string('name');
        //     $table->integer('total_jobs');
        //     $table->integer('pending_jobs');
        //     $table->integer('failed_jobs');
        //     $table->longText('failed_job_ids');
        //     $table->mediumText('options')->nullable();
        //     $table->integer('cancelled_at')->nullable();
        //     $table->integer('created_at');
        //     $table->integer('finished_at')->nullable();
        // });

        // Schema::create('failed_jobs', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('uuid')->unique();
        //     $table->text('connection');
        //     $table->text('queue');
        //     $table->longText('payload');
        //     $table->longText('exception');
        //     $table->timestamp('failed_at')->useCurrent();
        // });

        // Create jobs table
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue', 255);
            $table->text('payload');
            $table->tinyInteger('attempts');
            $table->integer('reserved_at')->nullable();
            $table->integer('available_at');
            $table->integer('created_at');
        });

        // Create job_batches table
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string('name', 255);
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->text('failed_job_ids');
            $table->text('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        // Create failed_jobs table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 255)->unique();
            $table->text('connection');
            $table->text('queue');
            $table->text('payload');
            $table->text('exception');
            $table->dateTime('failed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
