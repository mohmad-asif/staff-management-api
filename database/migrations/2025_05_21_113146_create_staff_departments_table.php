<?php
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff_departments', function (Blueprint $table) {

            $table->id();
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Staff::class);
            $table->timestamps();

            // Define the unique constraint on the composite key
            $table->unique(['staff_id', 'department_id'], 'staff_departments');

            // Define additional indexes
            $table->index(['staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_departments');
    }
};
