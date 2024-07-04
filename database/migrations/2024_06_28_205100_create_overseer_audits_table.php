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
            $table->string('collection')->index()->nullable();
            $table->string('taxonomy')->index()->nullable();
            $table->string('global')->index()->nullable();
            $table->string('navigation')->index()->nullable();
            $table->string('asset_container')->index()->nullable();
            $table->string('tree')->index()->nullable();
            $table->string('roles')->index()->nullable();
            $table->string('groups')->index()->nullable();
            $table->string('entry_id')->index()->nullable();
            $table->string('term_handle')->index()->nullable();
            $table->string('asset_id')->index()->nullable();
            $table->string('global_set')->index()->nullable();
            $table->string('site')->index()->nullable();
            $table->text('message')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        $schema = Schema::connection(config('statamic.overseer.storage.connection'));
        $schema->dropIfExists('overseer_events');
    }
};
