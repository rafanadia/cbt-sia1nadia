
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_result_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exam_result_id')
                ->constrained('exam_results')
                ->cascadeOnDelete();

            $table->foreignId('question_id')
                ->nullable()
                ->constrained('questions')
                ->nullOnDelete();

            $table->text('question_text');
            $table->string('student_answer', 1)->nullable();
            $table->string('correct_answer', 1);
            $table->boolean('is_correct')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_result_details');
    }
};
