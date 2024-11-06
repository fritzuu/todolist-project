<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Judul tugas
            $table->text('description')->nullable(); // Deskripsi tugas
            $table->date('due_date')->nullable(); // Tanggal jatuh tempo
            $table->enum('status', ['pending', 'completed'])->default('pending'); // Status tugas
            $table->enum('priority', ['high', 'medium', 'low'])->default('medium'); // Prioritas tugas
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
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
};
