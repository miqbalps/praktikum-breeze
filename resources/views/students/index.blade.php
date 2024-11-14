<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Diri') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row gap-4">
                <div class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Informasi Tambahan') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __("Lengkapi data diri Anda!") }}
                                </p>
                            </header>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('student.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('patch')

                                <div>
                                    <x-input-label for="name" :value="__('NRP')" />
                                    <x-text-input id="nrp" name="nrp" type="text" class="mt-1 block w-full"
                                        :value="old('nrp', $student->nrp ?? '')" required autofocus
                                        autocomplete="nrp" />
                                    <x-input-error class="mt-2" :messages="$errors->get('nrp')" />
                                </div>

                                <div>
                                    <x-input-label for="department" :value="__('Prodi')" />
                                    <x-text-input id="department" name="department" type="text"
                                        class="mt-1 block w-full" :value="old('department', $student->department ?? '')"
                                        required autofocus autocomplete="department" />
                                    <x-input-error class="mt-2" :messages="$errors->get('department')" />
                                </div>

                                <div>
                                    <x-input-label for="batch" :value="__('Angkatan')" />
                                    <x-text-input id="batch" name="batch" type="text" class="mt-1 block w-full"
                                        :value="old('batch', $student->batch ?? '')" required autofocus
                                        autocomplete="batch" />
                                    <x-input-error class="mt-2" :messages="$errors->get('batch')" />
                                </div>

                                <div>
                                    <x-input-label for="phone" :value="__('Telepon')" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                        :value="old('phone', $student->phone ?? '')" required autofocus
                                        autocomplete="phone" />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                                    @if (session('status') === 'add-info-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{
                                        __('Simpan.') }}</p>
                                    @endif
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
                <div class="flex-1 p-4 sm:p-8 bg-white shadow sm:rounded-lg h-fit">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Pengajuan Asisten') }}
                                </h2>
                            </header>

                            @if ($assistant)
                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                {{ __("Status penerimaan.") }}
                            </p>

                            <span class="px-3 py-1
                            {{ $assistant->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $assistant->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $assistant->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $assistant->status === 'inactive' ? 'bg-slate-100 text-slate-800' : '' }}
                            rounded-full text-xs">
                                {{ ucfirst($assistant->status) }}
                            </span>
                            @else
                            <p class="mt-1 mb-1 text-sm text-gray-600">
                                {{ __("Belum mengajukan.") }}
                            </p>

                            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                @csrf
                            </form>

                            <form method="post" action="{{ route('student.apply') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('post')

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Ajukan') }}</x-primary-button>

                                    @if (session('status') === 'add-info-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition
                                        x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{
                                        __('Ajukan.') }}</p>
                                    @endif
                                </div>
                            </form>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>