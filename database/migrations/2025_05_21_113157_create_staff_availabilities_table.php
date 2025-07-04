<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff');
            $table->string('day');
            $table->time('from');
            $table->time('to');
            $table->timestamps();

            $table->unique(['staff_id', 'day']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_availabilities');
    }
};
