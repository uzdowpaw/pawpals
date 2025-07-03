@extends('layouts.app')

@section('content')
<div class="main-content" style="overflow-y: auto; height: auto; min-height: 100vh;">
    <style>
        html,
        body {
            overflow-y: auto !important;
            height: auto !important;
            min-height: 100%;
        }

        .sticky-container {
            position: relative;
            overflow-y: visible;
        }

        .sticky-photo {
            transition: all 0.5s ease-in-out;
        }

        .sticky-description {
            transition: all 0.5s ease-in-out;
        }

        .fading {
            opacity: 0 !important;
            transition: opacity 0.3s ease-in-out;
        }

        .sticky-photo.fixed {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            left: 1%;
            width: 20%;
            max-height: 70vh;
            overflow: hidden;
            border: none;
            /* Red border to match the red box in the image */
            border-radius: 8px;
            -webkit-box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            -moz-box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            background-color: white;
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        .sticky-description.fixed {
            position: fixed;
            top: 50%;
            transform: translateY(-50%);
            right: 1%;
            width: 20%;
            max-height: 70vh;
            overflow-y: auto;
            padding: 15px;
            background-color: white;
            border: none;
            /* Blue border to match the blue box in the image */
            border-radius: 8px;
            -webkit-box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            -moz-box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            box-shadow: 0px 0px 24px 0px rgba(66, 68, 90, 1);
            opacity: 1;
            transition: opacity 0.3s ease-in-out;
        }

        .form-container {
            margin-top: 20px;
            position: relative;
            z-index: 5;
            clear: both;
            /* Ensure form starts below the photo and description */
        }

        /* Add padding to ensure form content is visible when scrolling */
        .form-padding-top {
            padding-top: 50vh;
            /* Revert to original padding to ensure enough space when elements are fixed */
            margin-top: 30px;
        }

        /* Ensure the form is wide enough when elements are fixed */
        .adoption-form-width {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Make sure the main container allows scrolling */
        .container.mx-auto {
            overflow-y: visible;
        }
    </style>

    <div class="container mx-auto px-4 py-8 sticky-container" style="overflow-y: visible;">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-visible">
            <div class="md:flex">
                <div class="md:w-2/5 sticky-photo" id="dogPhoto">
                    @if($dog->main_photo_path)
                    <img src="{{ asset('storage/' . $dog->main_photo_path) }}" alt="{{ $dog->name }}" class="w-full h-full object-cover">
                    @else
                    <img src="{{ asset('images/default_pet.svg') }}" alt="Default dog image" class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-8 md:w-3/5 sticky-description" id="dogDescription">
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-white">{{ $dog->name }}</h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">{{ $dog->breed->name }}</p>
                    <p class="text-lg text-gray-500 dark:text-gray-300">{{ $dog->age }} years old</p>
                    <p class="text-lg text-gray-500 dark:text-gray-300">{{ ucfirst($dog->sex) }}</p>
                    <p class="mt-4 text-gray-700 dark:text-gray-200">{{ $dog->description }}</p>
                    <p class="mt-4 text-sm text-gray-700 dark:text-gray-200">Shelter: {{ $dog->shelter->name }}</p>
                </div>
            </div>

            <div class="p-8 form-container adoption-form-width" id="adoptionForm">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Adoption Form</h2>
                <form action="{{ route('shelter-dogs.adopt', $dog) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="applicant_name" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Full Name and Age:</label>
                                <input type="text" name="applicant_name" id="applicant_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="household_members" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Names and Ages of All Household Members:</label>
                                <textarea name="household_members" id="household_members" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="address" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Address:</label>
                                <input type="text" name="address" id="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="phone" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Phone Number:</label>
                                <input type="text" name="phone" id="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>

                    <!-- Adoption Motivation Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Adoption Motivation</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="family_agreement" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do all family members agree to adopt a dog?</label>
                                <textarea name="family_agreement" id="family_agreement" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="adoption_reason" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Why have you decided to adopt a dog now?</label>
                                <textarea name="adoption_reason" id="adoption_reason" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="ready_date" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">When are you ready to adopt? (Date)</label>
                                <input type="date" name="ready_date" id="ready_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="specific_dog" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you interested in a specific dog? If yes, which one and why?</label>
                                <textarea name="specific_dog" id="specific_dog" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="consider_other_dog" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Would you consider adopting a different dog if your first choice is unavailable?</label>
                                <select name="consider_other_dog" id="consider_other_dog" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Lifestyle Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Lifestyle & Home Environment</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="lifestyle_description" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Describe your weekly schedule and lifestyle:</label>
                                <textarea name="lifestyle_description" id="lifestyle_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="desired_temperament" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What temperament are you looking for in a dog?</label>
                                <textarea name="desired_temperament" id="desired_temperament" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="children_info" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do you have children? If yes, what ages and how do they interact with animals?</label>
                                <textarea name="children_info" id="children_info" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="children_rules" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What rules will you establish for children interacting with the dog?</label>
                                <textarea name="children_rules" id="children_rules" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="allergies" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Does anyone in your home have allergies to dogs? What would you do if allergies develop?</label>
                                <textarea name="allergies" id="allergies" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Current & Previous Pets Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Current & Previous Pets</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="current_pets" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do you currently have any pets? If yes, what kind and how do they interact with other animals?</label>
                                <textarea name="current_pets" id="current_pets" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="pet_introduction_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">If you have pets, how do you plan to introduce them to the new dog?</label>
                                <textarea name="pet_introduction_plan" id="pet_introduction_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="pet_conflict_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How will you handle potential conflicts between pets?</label>
                                <textarea name="pet_conflict_plan" id="pet_conflict_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="aware_of_adjustment" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you aware that a dog's behavior may change during the adjustment period?</label>
                                <select name="aware_of_adjustment" id="aware_of_adjustment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="previous_pets" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Have you had pets in the past? Please describe their history:</label>
                                <textarea name="previous_pets" id="previous_pets" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="previous_pet_returned" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Have you ever returned or rehomed a pet?</label>
                                <select name="previous_pet_returned" id="previous_pet_returned" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Housing & Care Arrangements Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Housing & Care Arrangements</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="living_conditions" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Describe your living conditions (house, apartment, floor, elevator, size, balcony):</label>
                                <textarea name="living_conditions" id="living_conditions" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="landlord_permission" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">If renting, do you have your landlord's permission to have a dog?</label>
                                <select name="landlord_permission" id="landlord_permission" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                    <option value="">Not applicable</option>
                                </select>
                            </div>
                            <div>
                                <label for="dog_living_location" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Where will the dog live? (inside, outside, kennel, etc.)</label>
                                <textarea name="dog_living_location" id="dog_living_location" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="walk_frequency" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How often and for how long will you walk the dog?</label>
                                <textarea name="walk_frequency" id="walk_frequency" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="walk_knowledge" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What is your knowledge about proper walking etiquette and potential issues?</label>
                                <textarea name="walk_knowledge" id="walk_knowledge" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="unsupervised_outside" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Will the dog be allowed outside unsupervised in an open area?</label>
                                <select name="unsupervised_outside" id="unsupervised_outside" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="off_leash_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">If you plan to let the dog off-leash, how will you prepare for this?</label>
                                <textarea name="off_leash_plan" id="off_leash_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="alone_time" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How long will the dog be alone each day?</label>
                                <textarea name="alone_time" id="alone_time" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="vacation_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What will happen to the dog during your vacations or trips?</label>
                                <textarea name="vacation_plan" id="vacation_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="separation_preparation" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How will you prepare the dog for separation and new environments?</label>
                                <textarea name="separation_preparation" id="separation_preparation" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="pet_hotel_name" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">If you plan to use a pet hotel, please provide its name:</label>
                                <input type="text" name="pet_hotel_name" id="pet_hotel_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>

                    <!-- Long-term Commitment & Training Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Long-term Commitment & Training</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="long_term_commitment" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you prepared for a long-term commitment (10-15 years)?</label>
                                <select name="long_term_commitment" id="long_term_commitment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="adjustment_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How will you handle the dog's adjustment period and potential fear behaviors?</label>
                                <textarea name="adjustment_plan" id="adjustment_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="behaviorist_commitment" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you willing to work with a behaviorist if needed?</label>
                                <select name="behaviorist_commitment" id="behaviorist_commitment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="trainer_name" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">If yes, please provide the name of the trainer or school:</label>
                                <input type="text" name="trainer_name" id="trainer_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="education_sources" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What educational resources do you use for dog training and behavior?</label>
                                <textarea name="education_sources" id="education_sources" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Puppy-Specific Questions (if applicable) -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Puppy-Specific Questions (if applicable)</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="puppy_experience" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What experience do you have with raising puppies?</label>
                                <textarea name="puppy_experience" id="puppy_experience" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="puppy_training_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How will you train and socialize a puppy?</label>
                                <textarea name="puppy_training_plan" id="puppy_training_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="difficult_situation" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Describe a challenging situation you might face with an energetic young dog:</label>
                                <textarea name="difficult_situation" id="difficult_situation" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Dog Knowledge & Care Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Dog Knowledge & Care</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="dog_behavior_knowledge" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What is your knowledge about dog behavior, separation anxiety, and pack dynamics?</label>
                                <textarea name="dog_behavior_knowledge" id="dog_behavior_knowledge" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="dog_needs" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Besides food, water, and walks, what other daily needs do dogs have?</label>
                                <textarea name="dog_needs" id="dog_needs" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="physical_capability" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you physically able to care for a dog (lifting, carrying, etc.)?</label>
                                <select name="physical_capability" id="physical_capability" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="mental_capability" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Are you mentally prepared for the challenges of dog ownership?</label>
                                <select name="mental_capability" id="mental_capability" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Responsibility Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Financial Responsibility</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="monthly_cost_estimate" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What is your estimate of monthly dog care costs? (Please provide a specific amount)</label>
                                <input type="text" name="monthly_cost_estimate" id="monthly_cost_estimate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="emergency_fund" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How much are you prepared to spend on emergency veterinary care?</label>
                                <input type="text" name="emergency_fund" id="emergency_fund" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label for="preventative_care" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What preventative veterinary care does a dog need annually?</label>
                                <textarea name="preventative_care" id="preventative_care" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Feeding Plan Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Feeding Plan</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="feeding_plan" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How do you plan to feed the dog? (type of food)</label>
                                <textarea name="feeding_plan" id="feeding_plan" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="diet_consultation" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Who will you consult about the dog's diet?</label>
                                <input type="text" name="diet_consultation" id="diet_consultation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>

                    <!-- Agreements & Contingency Plans Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Agreements & Contingency Plans</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="return_agreement" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do you agree to return the dog to us if you can no longer keep it?</label>
                                <select name="return_agreement" id="return_agreement" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="bad_behavior_response" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">How will you respond if the dog has accidents, bites, or destroys property?</label>
                                <textarea name="bad_behavior_response" id="bad_behavior_response" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="return_scenario" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What circumstances might lead you to return the dog?</label>
                                <textarea name="return_scenario" id="return_scenario" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                            <div>
                                <label for="spay_neuter_opinion" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">What is your opinion on spaying/neutering?</label>
                                <textarea name="spay_neuter_opinion" id="spay_neuter_opinion" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Adoption Process Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Adoption Process</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="pre_adoption_visit_agreement" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do you agree to a pre-adoption home visit?</label>
                                <select name="pre_adoption_visit_agreement" id="pre_adoption_visit_agreement" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="post_adoption_visit_agreement" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Do you agree to post-adoption follow-up visits?</label>
                                <select name="post_adoption_visit_agreement" id="post_adoption_visit_agreement" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div>
                                <label for="personal_pickup" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Will you pick up the dog in person?</label>
                                <select name="personal_pickup" id="personal_pickup" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">Please select</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Message Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Additional Message</h3>
                        <div>
                            <label for="message" class="block text-gray-700 dark:text-gray-300 text-sm font-medium mb-2">Your Message (optional):</label>
                            <textarea name="message" id="message" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>
                    </div>

                    <!-- GDPR Agreement -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="gdpr_agreement" name="gdpr_agreement" type="checkbox" value="1" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required>
                            </div>
                            <label for="gdpr_agreement" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                I consent to the processing of my personal data for adoption purposes in accordance with the General Data Protection Regulation (GDPR).
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline text-lg">
                            Submit Adoption Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dogPhoto = document.getElementById('dogPhoto');
            const dogDescription = document.getElementById('dogDescription');
            const adoptionForm = document.getElementById('adoptionForm');
            const photoRect = dogPhoto.getBoundingClientRect();
            const descriptionRect = dogDescription.getBoundingClientRect();
            const formRect = adoptionForm.getBoundingClientRect();

            // Set initial positions for calculations
            const photoInitialTop = photoRect.top + window.scrollY;
            const descriptionInitialTop = descriptionRect.top + window.scrollY;
            const formInitialTop = formRect.top + window.scrollY;

            // Calculate the scroll trigger point - when user starts to scroll to the form
            const scrollTriggerPoint = formInitialTop - 150; // Trigger before reaching the form

            // Create placeholder elements to prevent layout shift
            const photoPlaceholder = document.createElement('div');
            photoPlaceholder.style.height = photoRect.height + 'px';
            photoPlaceholder.style.width = photoRect.width + 'px';
            photoPlaceholder.style.display = 'none';
            dogPhoto.parentNode.insertBefore(photoPlaceholder, dogPhoto);

            const descriptionPlaceholder = document.createElement('div');
            descriptionPlaceholder.style.height = descriptionRect.height + 'px';
            descriptionPlaceholder.style.width = descriptionRect.width + 'px';
            descriptionPlaceholder.style.display = 'none';
            dogDescription.parentNode.insertBefore(descriptionPlaceholder, dogDescription);

            // Function to handle the scroll event with throttling for better performance
            let ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        const scrollPosition = window.scrollY;

                        // When scroll position reaches the trigger point
                        if (scrollPosition >= scrollTriggerPoint) {
                            // If not already fixed, add fading class, then fix after delay
                            if (!dogPhoto.classList.contains('fixed')) {
                                dogPhoto.classList.add('fading');
                                dogDescription.classList.add('fading');
                                setTimeout(() => {
                                    dogPhoto.classList.remove('fading');
                                    dogDescription.classList.remove('fading');
                                    dogPhoto.classList.add('fixed');
                                    dogDescription.classList.add('fixed');
                                    adoptionForm.classList.add('form-padding-top');
                                    photoPlaceholder.style.display = 'block';
                                    descriptionPlaceholder.style.display = 'block';
                                }, 300); // Match CSS transition duration
                            }
                        } else {
                            // If fixed, add fading class, then unfix after delay
                            if (dogPhoto.classList.contains('fixed')) {
                                dogPhoto.classList.add('fading');
                                dogDescription.classList.add('fading');
                                setTimeout(() => {
                                    dogPhoto.classList.remove('fading');
                                    dogDescription.classList.remove('fading');
                                    dogPhoto.classList.remove('fixed');
                                    dogDescription.classList.remove('fixed');
                                    adoptionForm.classList.remove('form-padding-top');
                                    photoPlaceholder.style.display = 'none';
                                    descriptionPlaceholder.style.display = 'none';
                                }, 300); // Match CSS transition duration
                            }
                            dogDescription.classList.remove('fixed');
                            adoptionForm.classList.remove('form-padding-top');

                            // Hide placeholders
                            photoPlaceholder.style.display = 'none';
                            descriptionPlaceholder.style.display = 'none';
                        }

                        ticking = false;
                    });

                    ticking = true;
                }
            });

            // Initial check in case page is loaded at a scroll position
            if (window.scrollY >= scrollTriggerPoint) {
                dogPhoto.classList.add('fixed');
                dogDescription.classList.add('fixed');
                adoptionForm.classList.add('form-padding-top');
                photoPlaceholder.style.display = 'block';
                descriptionPlaceholder.style.display = 'block';
            }
        });
    </script>
</div>
@endsection