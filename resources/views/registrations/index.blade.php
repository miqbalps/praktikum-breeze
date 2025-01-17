<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Praktikum') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header class="flex align-items-center justify-between">
                    <h2 class="text-lg font-medium mb-6 text-gray-900">
                        {{ __('Tampil Data') }}
                    </h2>

                    <div class="button-add">
                        <x-primary-button data-modal-target="addRegistrationModal"
                            data-modal-toggle="addRegistrationModal" type="button">
                            {{ __('Tambah') }}
                        </x-primary-button>
                    </div>
                </header>

                <div class="relative overflow-x-auto sm:rounded-lg">

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Jadwal</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pendaftaran</th>
                                <th scope="col" class="px-6 py-3">status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                            @if ($registration->student_id == auth()->user()->student->id)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrape">
                                    {{ $registration->schedule->practicum->name }} {{
                                    $registration->schedule->class }}
                                </th>
                                <td class="px-6 py-4">{{ date('d-m-Y', strtotime($registration->registration_date)) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1
                                        {{ $registration->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $registration->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $registration->status === 'inactive' ? 'bg-slate-100 text-slate-800' : '' }}
                                        rounded-full text-xs">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <x-danger-button x-data x-on:click="$dispatch('trigger-delete', {
                                        id: '{{ $registration->id }}',
                                        name: '{{ $registration->schedule->practicum->name }}',
                                        classes: '{{ $registration->schedule->class }}'
                                    })" data-modal-target="deleteRegistrationModal"
                                        data-modal-toggle="deleteRegistrationModal" type="button" class="ms-1">
                                        {{ __('Hapus') }}
                                    </x-danger-button>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="items-center md:flex-row pt-4" aria-label="Table navigation">
                    {{ $registrations->links() }}
                </nav>
            </div>
        </div>
    </div>

    <x-modal-flowbite id="addRegistrationModal" title="Tambah Data">
        <form method="post" action="{{ route('registrations.store') }}">
            @csrf
            @method('post')
            <div class='grid gap-4 mb-4 grid-cols-2'>
                <div class='col-span-2'>
                    <x-input-label for="schedule_id" class="block mb-2" :value="__('Jadwal')" />
                    <select id="schedule_id" name="schedule_id"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih jadwal praktikum</option>
                        @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->id }}" data-day="{{ $schedule->day }}"
                            data-class="{{ $schedule->class }}"
                            data-start="{{ date('H:i:s', strtotime($schedule->start_time)) }}"
                            data-end="{{ date('H:i:s', strtotime($schedule->end_time)) }}">
                            {{ $schedule->practicum->name }}
                        </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('schedule_id')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="day" class="block mb-2" :value="__('Hari')" />
                    <x-text-input id="day" class="block w-full" type="text" autocomplete="current-day" disabled />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="class" class="block mb-2" :value="__('Kelas')" />
                    <x-text-input id="class" class="block w-full" type="text" autocomplete="current-class" disabled />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="start_time" class="block mb-2" :value="__('Waktu Awal')" />
                    <x-text-input id="start_time" class="block w-full" type="text" autocomplete="current-start-time"
                        disabled />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="end_time" class="block mb-2" :value="__('Waktu Akhir')" />
                    <x-text-input id="end_time" class="block w-full" type="text" autocomplete="current-end-time"
                        disabled />
                </div>
            </div>

            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'add-info-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Simpan.') }}</p>
            @endif
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="deleteRegistrationModal" title="Konfirmasi Hapus">
        <form x-data="deleteRegistrationForm" x-init="init" method="POST" :action="deleteUrl">
            @csrf
            @method('DELETE')

            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin menghapus Jadwal
                    <span x-text="itemName" class="font-bold"></span>?
                </h3>

                <div class="flex justify-center space-x-4">
                    <x-danger-button type="submit">
                        Ya, Hapus
                    </x-danger-button>

                    <x-secondary-button type="button" @click="closeModal">
                        Batal
                    </x-secondary-button>
                </div>
            </div>
        </form>
    </x-modal-flowbite>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const scheduleSelect = document.getElementById('schedule_id');
        const scheduleDetails = document.getElementById('scheduleDetails');
        const dayElement = document.getElementById('day');
        const classElement = document.getElementById('class');
        const startTimeElement = document.getElementById('start_time');
        const endTimeElement = document.getElementById('end_time');

        scheduleSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (selectedOption.value) {
                // Ambil data dari atribut data
                const day = selectedOption.getAttribute('data-day');
                const className = selectedOption.getAttribute('data-class');
                const startTime = selectedOption.getAttribute('data-start');
                const endTime = selectedOption.getAttribute('data-end');

                // Tampilkan detail
                dayElement.value = day;
                classElement.value = className;
                startTimeElement.value = startTime;
                endTimeElement.value = endTime;

                // Tampilkan elemen detail
                scheduleDetails.classList.remove('hidden');
            } else {
                // Sembunyikan detail jika tidak ada pilihan
                scheduleDetails.classList.add('hidden');
            }
        });
        });
        document.addEventListener('alpine:init', () => {
            Alpine.data('deleteRegistrationForm', () => ({
                deleteUrl: '',
                itemName: '',

                init() {
                    // Listen for delete event
                    document.addEventListener('trigger-delete', (event) => {
                        const { id, name, classes } = event.detail;
                        this.deleteUrl = `/registrations/${id}`;
                        this.itemName = `${name} ${classes}`;

                        // Open modal using Flowbite
                        const modalElement = document.getElementById('deleteRegistrationModal');
                        const modal = new Modal(modalElement);
                        modal.show();
                    });
                },

                closeModal() {
                    const modalElement = document.getElementById('deleteRegistrationModal');
                    const modal = new Modal(modalElement);
                    modal.hide();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>