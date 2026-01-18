<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Profilul Meu</h1>
                <p class="text-gray-600">Gestionează informațiile contului tău</p>
            </div>

            <div class="space-y-6">
                <!-- Profile Information -->
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6 sm:p-8">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6 sm:p-8">
                        <livewire:profile.update-password-form />
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-red-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6 sm:p-8">
                        <livewire:profile.delete-user-form />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>