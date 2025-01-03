<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Update Profile Information -->
            <div class="p-6 bg-white shadow-lg rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Profile Information</h3>
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white shadow-lg rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Change Password</h3>
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="p-6 bg-red-50 shadow-lg rounded-lg border border-red-200">
                <h3 class="text-lg font-semibold text-red-800 mb-4">Delete Account</h3>
                <p class="text-sm text-red-600 mb-4">
                    Warning: Deleting your account is permanent and cannot be undone.
                </p>
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>