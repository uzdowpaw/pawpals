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
        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('dog_id'); // Remove constraint to allow both Dog and ShelterDog IDs
            $table->foreignId('shelter_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('message')->nullable();
            $table->string('dog_type');

            // Adoption form fields
            $table->text('applicant_name')->nullable();
            $table->text('household_members')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('family_agreement')->nullable();
            $table->text('adoption_reason')->nullable();
            $table->date('ready_date')->nullable();
            $table->text('specific_dog')->nullable();
            $table->boolean('consider_other_dog')->nullable();
            $table->text('lifestyle_description')->nullable();
            $table->text('desired_temperament')->nullable();
            $table->text('children_info')->nullable();
            $table->text('children_rules')->nullable();
            $table->text('allergies')->nullable();
            $table->text('current_pets')->nullable();
            $table->text('pet_introduction_plan')->nullable();
            $table->text('pet_conflict_plan')->nullable();
            $table->boolean('aware_of_adjustment')->nullable();
            $table->text('previous_pets')->nullable();
            $table->boolean('previous_pet_returned')->nullable();
            $table->text('living_conditions')->nullable();
            $table->boolean('landlord_permission')->nullable();
            $table->text('dog_living_location')->nullable();
            $table->text('walk_frequency')->nullable();
            $table->text('walk_knowledge')->nullable();
            $table->boolean('unsupervised_outside')->nullable();
            $table->text('off_leash_plan')->nullable();
            $table->text('alone_time')->nullable();
            $table->text('vacation_plan')->nullable();
            $table->text('separation_preparation')->nullable();
            $table->text('pet_hotel_name')->nullable();
            $table->boolean('long_term_commitment')->nullable();
            $table->text('adjustment_plan')->nullable();
            $table->boolean('behaviorist_commitment')->nullable();
            $table->text('trainer_name')->nullable();
            $table->text('education_sources')->nullable();
            $table->text('puppy_experience')->nullable();
            $table->text('puppy_training_plan')->nullable();
            $table->text('difficult_situation')->nullable();
            $table->text('dog_behavior_knowledge')->nullable();
            $table->text('dog_needs')->nullable();
            $table->boolean('physical_capability')->nullable();
            $table->boolean('mental_capability')->nullable();
            $table->text('monthly_cost_estimate')->nullable();
            $table->text('emergency_fund')->nullable();
            $table->text('preventative_care')->nullable();
            $table->text('feeding_plan')->nullable();
            $table->text('diet_consultation')->nullable();
            $table->boolean('return_agreement')->nullable();
            $table->text('bad_behavior_response')->nullable();
            $table->text('return_scenario')->nullable();
            $table->text('spay_neuter_opinion')->nullable();
            $table->boolean('pre_adoption_visit_agreement')->nullable();
            $table->boolean('post_adoption_visit_agreement')->nullable();
            $table->boolean('personal_pickup')->nullable();
            $table->boolean('gdpr_agreement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_applications');
    }
};
