<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function getConnection(): ?string
    {
        return config('statamic.overseer.storage.connection');
    }

    public function up(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));
        $schema->create('overseer_audits', function (Blueprint $table) {
            $table->id();
            $table->uuid('execution_id')->index();
            $table->uuid('user_id')->index()->nullable();
            $table->uuid('impersonator_id')->index()->nullable();
            $table->string('model_type')->index()->nullable();
            $table->string('model_handle')->index()->nullable();
            $table->string('model_id')->index()->nullable();
            $table->string('site')->index()->nullable();
            $table->text('message')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();

            $table->index(['model_type', 'model_handle', 'model_id']);
            $table->index(['model_type', 'model_id']);
            $table->index(['model_type', 'model_handle']);
        });
    }

    public function down(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));
        $schema->dropIfExists('overseer_events');
    }
};
