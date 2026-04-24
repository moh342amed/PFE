<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container pb-5">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4 p-4 p-md-5">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 p-4 p-md-5">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4 p-4 p-md-5 border-top border-danger border-4">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
