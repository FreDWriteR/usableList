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
        Schema::create('u_sub_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_name_id')->nullable()->constrained('good_names')->onDelete('cascade');
            $table->foreignId('u_list_id')->nullable()->constrained('u_lists')->onDelete('restrict');
	        $table->foreignId('source_id')->nullable()->constrained('sources')->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->integer('laser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_sub_lists');
    }
};
