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
        Schema::table('adoption_applications', function (Blueprint $table) {
            // Add all the adoption form fields
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            // Drop all the added columns
            $table->dropColumn([
                'applicant_name',
                'household_members',
                'address',
                'phone',
                'family_agreement',
                'adoption_reason',
                'ready_date',
                'specific_dog',
                'consider_other_dog',
                'lifestyle_description',
                'desired_temperament',
                'children_info',
                'children_rules',
                'allergies',
                'current_pets',
                'pet_introduction_plan',
                'pet_conflict_plan',
                'aware_of_adjustment',
                'previous_pets',
                'previous_pet_returned',
                'living_conditions',
                'landlord_permission',
                'dog_living_location',
                'walk_frequency',
                'walk_knowledge',
                'unsupervised_outside',
                'off_leash_plan',
                'alone_time',
                'vacation_plan',
                'separation_preparation',
                'pet_hotel_name',
                'long_term_commitment',
                'adjustment_plan',
                'behaviorist_commitment',
                'trainer_name',
                'education_sources',
                'puppy_experience',
                'puppy_training_plan',
                'difficult_situation',
                'dog_behavior_knowledge',
                'dog_needs',
                'physical_capability',
                'mental_capability',
                'monthly_cost_estimate',
                'emergency_fund',
                'preventative_care',
                'feeding_plan',
                'diet_consultation',
                'return_agreement',
                'bad_behavior_response',
                'return_scenario',
                'spay_neuter_opinion',
                'pre_adoption_visit_agreement',
                'post_adoption_visit_agreement',
                'personal_pickup',
                'gdpr_agreement'
            ]);
        });
    }
};
