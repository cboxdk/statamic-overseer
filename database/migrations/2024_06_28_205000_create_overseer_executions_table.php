<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return config('statamic.overseer.storage.connection');
    }
    public function up(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));

        $schema->create('overseer_executions', function (Blueprint $table) {
            $table->id();
            $table->uuid('execution_id')->index()->unique();
            $table->uuid('user_id')->index()->nullable();
            $table->uuid('impersonator_id')->index()->nullable();
            $table->string('host')->nullable();
            $table->integer('pid')->nullable();
            $table->float('duration')->nullable();
            $table->float('memory')->nullable();
            $table->float('cpu_user_time')->nullable();
            $table->float('cpu_system_time')->nullable();
            $table->float('cpu_usage_percentage')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));
        $schema->dropIfExists('overseer_executions');
    }
};
