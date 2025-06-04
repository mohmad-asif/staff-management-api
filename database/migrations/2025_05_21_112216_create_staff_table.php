<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('designation')->nullable();
            $table->date('joining_date')->nullable();
            $table->boolean('status')->default(1);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['created_at', 'updated_at', 'deleted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
