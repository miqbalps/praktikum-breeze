<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Additional Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Add your additional personal information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('NRP')" />
            <x-text-input id="nrp" name="nrp" type="text" class="mt-1 block w-full" :value="old('nrp', $user->nrp)"
                required autofocus autocomplete="nrp" />
            <x-input-error class="mt-2" :messages="$errors->get('nrp')" />
        </div>

        <div>
            <x-input-label for="department" :value="__('Prodi')" />
            <x-text-input id="department" name="department" type="text" class="mt-1 block w-full"
                :value="old('department', $user->department)" required autofocus autocomplete="department" />
            <x-input-error class="mt-2" :messages="$errors->get('department')" />
        </div>

        <div>
            <x-input-label for="batch" :value="__('Angkatan')" />
            <x-text-input id="batch" name="batch" type="text" class="mt-1 block w-full"
                :value="old('batch', $user->batch)" required autofocus autocomplete="batch" />
            <x-input-error class="mt-2" :messages="$errors->get('batch')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Telepon')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'add-info-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>