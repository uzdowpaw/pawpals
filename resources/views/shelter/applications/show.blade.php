@extends('layouts.shelter')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight">
    {{ __('Adoption Application Details') }}
</h2>
@endsection

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Application Details</h1>

    @if(session('success'))
    <div class="p-4 rounded mb-4" style="background-color: #FCECDD; color: #00809D; border: 1px solid #F3A26D;">
        {{ session('success') }}
    </div>
    @endif

    <div class="shelter-card my-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-medium">Application from {{ $application->user->name }} for {{ $application->shelterDog && $application->shelterDog->dog ? $application->shelterDog->dog->name : 'Unknown Dog' }}</h3>
                <a href="{{ route('shelter.applications.index') }}" class="shelter-button-secondary px-4 py-2 rounded">Back to Applications</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Application Status Information -->
                <div class="p-4 rounded-lg" style="background-color: #FCECDD; border: 1px solid #F3A26D;">
                    <h4 class="text-lg font-semibold mb-4" style="color: #00809D;">Application Status</h4>
                    <div class="space-y-2">
                        <div>
                            <span class="font-medium">Status:</span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($application->status === 'approved') bg-green-100 text-green-800
                                @elseif($application->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Submitted:</span>
                            <span class="ml-2">{{ $application->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Last Updated:</span>
                            <span class="ml-2">{{ $application->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Applicant Information -->
                <div class="p-4 rounded-lg" style="background-color: #FCECDD; border: 1px solid #F3A26D;">
                    <h4 class="text-lg font-semibold mb-4" style="color: #00809D;">Applicant Information</h4>
                    <div class="space-y-2">
                        <div>
                            <span class="font-medium">Name:</span>
                            <span class="ml-2">{{ $application->user->name }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Email:</span>
                            <span class="ml-2">{{ $application->user->email }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Phone:</span>
                            <span class="ml-2">{{ $application->phone }}</span>
                        </div>
                    </div>
                </div>

                <!-- Dog Information -->
                <div class="p-4 rounded-lg" style="background-color: #FCECDD; border: 1px solid #F3A26D;">
                    <h4 class="text-lg font-semibold mb-4" style="color: #00809D;">Dog Information</h4>
                    <div class="space-y-2">
                        <div>
                            <span class="font-medium">Name:</span>
                            <span class="ml-2">{{ $application->shelterDog && $application->shelterDog->dog ? $application->shelterDog->dog->name : 'Unknown Dog' }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Breed:</span>
                            <span class="ml-2">{{ $application->shelterDog && $application->shelterDog->dog && $application->shelterDog->dog->breed ? $application->shelterDog->dog->breed->name : 'Unknown' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Application Details -->
                <div class="p-4 rounded-lg" style="background-color: #FCECDD; border: 1px solid #F3A26D;">
                    <h4 class="text-lg font-semibold mb-4" style="color: #00809D;">Application Message</h4>
                    <div class="space-y-2">
                        <div>
                            <span class="font-medium">Message:</span>
                            <p class="mt-1 text-sm">{{ $application->message ?? 'No message provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Application Form Information -->
            <div class="mt-6 p-4 rounded-lg" style="background-color: #FCECDD; border: 1px solid #F3A26D;">
                <h4 class="text-lg font-semibold mb-4" style="color: #00809D;">Detailed Application Information</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($application->applicant_name)
                    <div>
                        <span class="font-medium">Applicant Name:</span>
                        <span class="ml-2">{{ $application->applicant_name }}</span>
                    </div>
                    @endif
                    
                    @if($application->household_members)
                    <div>
                        <span class="font-medium">Household Members:</span>
                        <span class="ml-2">{{ $application->household_members }}</span>
                    </div>
                    @endif
                    
                    @if($application->address)
                    <div>
                        <span class="font-medium">Address:</span>
                        <span class="ml-2">{{ $application->address }}</span>
                    </div>
                    @endif
                    
                    @if($application->phone)
                    <div>
                        <span class="font-medium">Phone:</span>
                        <span class="ml-2">{{ $application->phone }}</span>
                    </div>
                    @endif
                    
                    @if($application->family_agreement)
                    <div>
                        <span class="font-medium">Family Agreement:</span>
                        <span class="ml-2">{{ $application->family_agreement ? 'Yes' : 'No' }}</span>
                    </div>
                    @endif
                    
                    @if($application->adoption_reason)
                    <div class="col-span-2">
                        <span class="font-medium">Adoption Reason:</span>
                        <p class="mt-1 text-sm">{{ $application->adoption_reason }}</p>
                    </div>
                    @endif
                    
                    @if($application->ready_date)
                    <div>
                        <span class="font-medium">Ready Date:</span>
                        <span class="ml-2">{{ $application->ready_date }}</span>
                    </div>
                    @endif
                    
                    @if($application->specific_dog)
                    <div>
                        <span class="font-medium">Specific Dog:</span>
                        <span class="ml-2">{{ $application->specific_dog }}</span>
                    </div>
                    @endif
                    
                    @if($application->consider_other_dog !== null)
                    <div>
                        <span class="font-medium">Consider Other Dog:</span>
                        <span class="ml-2">{{ $application->consider_other_dog ? 'Yes' : 'No' }}</span>
                    </div>
                    @endif
                    
                    @if($application->lifestyle_description)
                    <div class="col-span-2">
                        <span class="font-medium">Lifestyle Description:</span>
                        <p class="mt-1 text-sm">{{ $application->lifestyle_description }}</p>
                    </div>
                    @endif
                    
                    @if($application->desired_temperament)
                    <div>
                        <span class="font-medium">Desired Temperament:</span>
                        <span class="ml-2">{{ $application->desired_temperament }}</span>
                    </div>
                    @endif
                    
                    @if($application->children_info)
                    <div>
                        <span class="font-medium">Children Info:</span>
                        <span class="ml-2">{{ $application->children_info }}</span>
                    </div>
                    @endif
                    
                    @if($application->children_rules)
                    <div class="col-span-2">
                        <span class="font-medium">Children Rules:</span>
                        <p class="mt-1 text-sm">{{ $application->children_rules }}</p>
                    </div>
                    @endif
                    
                    @if($application->allergies !== null)
                    <div>
                        <span class="font-medium">Allergies:</span>
                        <span class="ml-2">{{ $application->allergies ? 'Yes' : 'No' }}</span>
                    </div>
                    @endif
                    
                    @if($application->current_pets)
                    <div class="col-span-2">
                        <span class="font-medium">Current Pets:</span>
                        <p class="mt-1 text-sm">{{ $application->current_pets }}</p>
                    </div>
                    @endif
                    
                    @if($application->pet_introduction_plan)
                    <div class="col-span-2">
                        <span class="font-medium">Pet Introduction Plan:</span>
                        <p class="mt-1 text-sm">{{ $application->pet_introduction_plan }}</p>
                    </div>
                    @endif
                    
                    @if($application->pet_conflict_plan)
                    <div class="col-span-2">
                        <span class="font-medium">Pet Conflict Plan:</span>
                        <p class="mt-1 text-sm">{{ $application->pet_conflict_plan }}</p>
                    </div>
                    @endif
                    
                    @if($application->aware_of_adjustment !== null)
                    <div>
                        <span class="font-medium">Aware of Adjustment:</span>
                        <span class="ml-2">{{ $application->aware_of_adjustment ? 'Yes' : 'No' }}</span>
                    </div>
                    @endif
                    
                    @if($application->previous_pets)
                    <div class="col-span-2">
                        <span class="font-medium">Previous Pets:</span>
                        <p class="mt-1 text-sm">{{ $application->previous_pets }}</p>
                    </div>
                    @endif
                    
                    @if($application->previous_pet_returned !== null)
                    <div>
                        <span class="font-medium">Previous Pet Returned:</span>
                        <span class="ml-2">{{ $application->previous_pet_returned ? 'Yes' : 'No' }}</span>
                    </div>
                    @endif
                    
                    @if($application->living_conditions)
                    <div class="col-span-2">
                        <span class="font-medium">Living Conditions:</span>
                        <p class="mt-1 text-sm">{{ $application->living_conditions }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if ($application->status == 'pending')
            <div class="mt-6 flex space-x-4">
                <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="shelter-button-primary px-4 py-2 rounded" onclick="return confirm('Are you sure you want to approve this application?')">Approve</button>
                </form>

                <form action="{{ route('shelter.applications.update', $application) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="px-4 py-2 rounded text-white" style="background-color: #dc2626; border: 1px solid #b91c1c;" onclick="return confirm('Are you sure you want to reject this application?')">Reject</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection