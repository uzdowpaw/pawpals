    <x-guest-layout>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-[#333] retro-subtitle" />
                <x-text-input id="name" class="block mt-1 w-full bg-[var(--cream)] border-[var(--teal)] text-[#333] focus:border-[var(--red-orange)] focus:ring-[var(--red-orange)] rounded-none shadow-sm retro-border" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="text-[#333] retro-subtitle" />
                <x-text-input id="email" class="block mt-1 w-full bg-[var(--cream)] border-[var(--teal)] text-[#333] focus:border-[var(--red-orange)] focus:ring-[var(--red-orange)] rounded-none shadow-sm retro-border" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role Selection -->
            <div class="mt-4">
                <x-input-label :value="__('Account Type')" class="text-[#333] retro-subtitle" />
                <div class="flex items-center mt-2">
                    <input id="user_role" type="radio" name="role" value="user" class="h-4 w-4 text-[var(--red-orange)] focus:ring-[var(--red-orange)] border-[var(--teal)] bg-[var(--cream)]" checked>
                    <label for="user_role" class="ml-2 block text-sm text-[#333]">Regular User</label>
                </div>
                <div class="flex items-center mt-2">
                    <input id="shelter_role" type="radio" name="role" value="shelter" class="h-4 w-4 text-[var(--red-orange)] focus:ring-[var(--red-orange)] border-[var(--teal)] bg-[var(--cream)]">
                    <label for="shelter_role" class="ml-2 block text-sm text-[#333]">Shelter Organization</label>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-[#333] retro-subtitle" />

                <x-text-input id="password" class="block mt-1 w-full bg-[var(--cream)] border-[var(--teal)] text-[#333] focus:border-[var(--red-orange)] focus:ring-[var(--red-orange)] rounded-none shadow-sm retro-border"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[#333] retro-subtitle" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-[var(--cream)] border-[var(--teal)] text-[#333] focus:border-[var(--red-orange)] focus:ring-[var(--red-orange)] rounded-none shadow-sm retro-border"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-[var(--red-orange)] hover:text-[var(--orange)] rounded-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--red-orange)]" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4 retro-button font-bold py-2 px-4 rounded-none">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>