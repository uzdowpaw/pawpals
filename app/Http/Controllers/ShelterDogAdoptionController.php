<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShelterDog;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;

class ShelterDogAdoptionController extends Controller
{
    public function show(ShelterDog $shelterDog)
    {
        $shelterDog->load('photos', 'shelter', 'breed');
        return view('shelter-dogs.show', ['dog' => $shelterDog]);
    }

    public function adopt(Request $request, ShelterDog $shelterDog)
    {
        $validatedData = $request->validate([
            'message' => 'nullable|string',
            'applicant_name' => 'nullable|string',
            'household_members' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'family_agreement' => 'nullable|string',
            'adoption_reason' => 'nullable|string',
            'ready_date' => 'nullable|date',
            'specific_dog' => 'nullable|string',
            'consider_other_dog' => 'nullable|boolean',
            'lifestyle_description' => 'nullable|string',
            'desired_temperament' => 'nullable|string',
            'children_info' => 'nullable|string',
            'children_rules' => 'nullable|string',
            'allergies' => 'nullable|string',
            'current_pets' => 'nullable|string',
            'pet_introduction_plan' => 'nullable|string',
            'pet_conflict_plan' => 'nullable|string',
            'aware_of_adjustment' => 'nullable|boolean',
            'previous_pets' => 'nullable|string',
            'previous_pet_returned' => 'nullable|boolean',
            'living_conditions' => 'nullable|string',
            'landlord_permission' => 'nullable|boolean',
            'dog_living_location' => 'nullable|string',
            'walk_frequency' => 'nullable|string',
            'walk_knowledge' => 'nullable|string',
            'unsupervised_outside' => 'nullable|boolean',
            'off_leash_plan' => 'nullable|string',
            'alone_time' => 'nullable|string',
            'vacation_plan' => 'nullable|string',
            'separation_preparation' => 'nullable|string',
            'pet_hotel_name' => 'nullable|string',
            'long_term_commitment' => 'nullable|boolean',
            'adjustment_plan' => 'nullable|string',
            'behaviorist_commitment' => 'nullable|boolean',
            'trainer_name' => 'nullable|string',
            'education_sources' => 'nullable|string',
            'puppy_experience' => 'nullable|string',
            'puppy_training_plan' => 'nullable|string',
            'difficult_situation' => 'nullable|string',
            'dog_behavior_knowledge' => 'nullable|string',
            'dog_needs' => 'nullable|string',
            'physical_capability' => 'nullable|boolean',
            'mental_capability' => 'nullable|boolean',
            'monthly_cost_estimate' => 'nullable|string',
            'emergency_fund' => 'nullable|string',
            'preventative_care' => 'nullable|string',
            'feeding_plan' => 'nullable|string',
            'diet_consultation' => 'nullable|string',
            'return_agreement' => 'nullable|boolean',
            'bad_behavior_response' => 'nullable|string',
            'return_scenario' => 'nullable|string',
            'spay_neuter_opinion' => 'nullable|string',
            'pre_adoption_visit_agreement' => 'nullable|boolean',
            'post_adoption_visit_agreement' => 'nullable|boolean',
            'personal_pickup' => 'nullable|boolean',
            'gdpr_agreement' => 'required|boolean',
        ]);

        // Add required fields
        $validatedData['user_id'] = Auth::id();
        $validatedData['dog_id'] = $shelterDog->id;
        $validatedData['shelter_id'] = $shelterDog->shelter_id;
        $validatedData['dog_type'] = 'shelter_dog';

        $application = AdoptionApplication::create($validatedData);

        // Change the dog's status to 'pending'
        $shelterDog->update(['status' => 'pending']);

        return redirect()->route('shelter-dogs.index')->with('success', 'Your adoption application has been submitted!');
    }

    public function index()
    {
        $dogs = ShelterDog::where('status', 'available')
            ->with('breed', 'shelter')
            ->get();
        return view('shelter-dogs.index', ['dogs' => $dogs]);
    }
}
