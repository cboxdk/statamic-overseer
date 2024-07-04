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
        $schema->create('overseer_events', function (Blueprint $table) {
            $table->id();
            $table->uuid('execution_id')->index();
            $table->uuid('user_id')->index()->nullable();
            $table->uuid('impersonator_id')->index()->nullable();
            $table->string('type')->index();
            $table->json('event')->nullable();
            $table->timestamp('recorded_at', 6);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));
        $schema->dropIfExists('overseer_events');
    }
};
