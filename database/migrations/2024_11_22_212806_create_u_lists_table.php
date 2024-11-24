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
        Schema::create('u_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_name_id')->nullable()->constrained('good_names')->onDelete('cascade');
            $table->integer('number')->nullable();
            $table->foreignId('source_id')->nullable()->constrained('sources')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('laser')->nullable();
            $table->integer('welding')->nullable();
            $table->integer('assembly')->nullable();
            $table->integer('electric')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_lists');
    }
};
