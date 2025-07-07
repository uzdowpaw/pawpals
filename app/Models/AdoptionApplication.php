<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dog_id',
        'shelter_id',
        'status',
        'message',
        'dog_type',  // Added to distinguish between Dog and ShelterDog
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
        'gdpr_agreement',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dog()
    {
        // Only shelter dogs should be able to be adopted
        // Always return ShelterDog model regardless of dog_type
        return $this->belongsTo(ShelterDog::class, 'dog_id');
    }

    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }

    public function shelterDog()
    {
        return $this->belongsTo(ShelterDog::class, 'dog_id');
    }
    
    /**
     * Get the pet associated with the adoption application.
     * This is an alias for the dog relationship, used in admin views.
     */
    public function pet()
    {
        return $this->dog();
    }
}
