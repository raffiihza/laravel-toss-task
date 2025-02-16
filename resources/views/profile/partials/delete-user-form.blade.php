<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>
    </header>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <!-- <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div> -->

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" />

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

                <div class="flex items-center gap-4">
                <x-danger-button class="mt-4">
                    {{ __('Delete Account') }}
                </x-danger-button>

            </div>
        </form>
</section>
