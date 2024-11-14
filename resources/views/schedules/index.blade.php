<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal') }}
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
                        <x-primary-button data-modal-target="addScheduleModal" data-modal-toggle="addScheduleModal"
                            type="button">
                            {{ __('Tambah') }}
                        </x-primary-button>
                    </div>
                </header>

                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Praktikum</th>
                                <th scope="col" class="px-6 py-3">Ruangan</th>
                                <th scope="col" class="px-6 py-3">Kelas</th>
                                <th scope="col" class="px-6 py-3">Hari</th>
                                <th scope="col" class="px-6 py-3">Waktu Mulai</th>
                                <th scope="col" class="px-6 py-3">Waktu Akhir</th>
                                <th scope="col" class="px-6 py-3">Kapasitas</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr class="border-b hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $schedule->practicum->name }}
                                </th>
                                <td class="px-6 py-4">{{ $schedule->room->name }}</td>
                                <td class="px-6 py-4">{{ $schedule->class }}</td>
                                <td class="px-6 py-4">{{ $schedule->day }}</td>
                                <td class="px-6 py-4">{{ date('H:i:s', strtotime($schedule->start_time)) }}</td>
                                <td class="px-6 py-4">{{ date('H:i:s', strtotime($schedule->end_time)) }}</td>
                                <td class="px-6 py-4">{{ $schedule->capacity }}</td>
                                <td class="px-6 py-4">
                                    <x-secondary-button class="edit-schedule-btn" data-id="{{ $schedule->id }}"
                                        data-practicum="{{ $schedule->practicum->id }}"
                                        data-room="{{ $schedule->room->id }}" data-classes="{{ $schedule->class }}"
                                        data-day="{{ $schedule->day }}" data-capacity="{{ $schedule->capacity }}"
                                        data-start="{{ date('H:i:s', strtotime($schedule->start_time)) }}"
                                        data-end="{{ date('H:i:s', strtotime($schedule->end_time)) }}"
                                        data-modal-target="editScheduleModal" data-modal-toggle="editScheduleModal">
                                        {{ __('Ubah') }}
                                    </x-secondary-button>
                                    <x-danger-button x-data x-on:click="$dispatch('trigger-delete', {
                                        id: '{{ $schedule->id }}',
                                        name: '{{ $schedule->practicum->name }}',
                                        classes: '{{ $schedule->class }}'
                                    })" data-modal-target="deleteScheduleModal" data-modal-toggle="deleteScheduleModal"
                                        type="button" class="ms-1">
                                        {{ __('Hapus') }}
                                    </x-danger-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="items-center md:flex-row pt-4" aria-label="Table navigation">
                    {{ $schedules->links() }}
                </nav>
            </div>
        </div>
    </div>

    <x-modal-flowbite id="addScheduleModal" title="Tambah Data">
        <form method="post" action="{{ route('schedules.store') }}">
            @csrf
            @method('post')
            <div class='grid gap-4 mb-4 grid-cols-2'>
                <div class='col-span-2'>
                    <x-input-label for="practicum_id" class="block mb-2" :value="__('Praktikum')" />
                    <select id="practicum_id" name="practicum_id"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih praktikum</option>
                        @foreach ($practicums as $practicum)
                        <option value="{{ $practicum->id }}">{{ $practicum->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('practicum_id')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="room_id" class="block mb-2" :value="__('Ruangan')" />
                    <select id="room_id" name="room_id"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih ruangan</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="class" class="block mb-2" :value="__('Kelas')" />
                    <x-text-input id="class" class="block w-full" type="text" name="class" required
                        autocomplete="current-class" />
                    <x-input-error :messages="$errors->get('class')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="day" class="block mb-2" :value="__('Hari')" />
                    <x-text-input id="day" class="block w-full" type="text" name="day" required
                        autocomplete="current-day" />
                    <x-input-error :messages="$errors->get('day')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="capacity" class="block mb-2" :value="__('Kapasitas')" />
                    <x-text-input id="capacity" class="block w-full" type="number" name="capacity" required
                        autocomplete="current-capacity" type="number" />
                    <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="start_time" class="block mb-2" :value="__('Waktu Mulai')" />
                    <x-text-input id="start_time" class="block w-full" type="time" name="start_time" required
                        autocomplete="current-start-time" />
                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="end_time" class="block mb-2" :value="__('Waktu Akhir')" />
                    <x-text-input id="end_time" class="block w-full" type="time" name="end_time" required
                        autocomplete="current-end-time" />
                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                </div>
            </div>
            {{-- <x-slot name="footer"> --}}
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                @if (session('status') === 'add-info-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{
                    __('Simpan.') }}</p>
                @endif
                {{--
            </x-slot> --}}
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="editScheduleModal" title="Ubah Data Ruangan">
        <form method="POST" id="editScheduleForm">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <x-input-label for="edit_practicum_id" :value="__('Nama')" class="mb-2" />
                    <select id="edit_practicum_id" name="practicum_id"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih praktikum</option>
                        @foreach ($practicums as $practicum)
                        <option value="{{ $practicum->id }}">{{ $practicum->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="edit_room_id" class="block mb-2" :value="__('Ruangan')" />
                    <select id="edit_room_id" name="room_id"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih ruangan</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('edit_room_id')" class="mt-2" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_class" :value="__('Kelas')" class="mb-2" />
                    <x-text-input id="edit_class" name="class" type="text" class="block w-full" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_day" :value="__('Hari')" class="mb-2" />
                    <x-text-input id="edit_day" name="day" type="text" class="block w-full" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_capacity" :value="__('Kapasitas')" class="mb-2" />
                    <x-text-input id="edit_capacity" name="capacity" type="text" class="block w-full" />
                </div>

                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="edit_start_time" class="block mb-2" :value="__('Waktu Mulai')" />
                    <x-text-input id="edit_start_time" class="block w-full" type="time" name="start_time" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="edit_end_time" class="block mb-2" :value="__('Waktu Akhir')" />
                    <x-text-input id="edit_end_time" class="block w-full" type="time" name="end_time" />
                </div>
            </div>

            <x-primary-button type="submit">
                {{ __('Simpan') }}
            </x-primary-button>
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="deleteScheduleModal" title="Konfirmasi Hapus">
        <form x-data="deleteScheduleForm" x-init="init" method="POST" :action="deleteUrl">
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
        const editButtons = document.querySelectorAll('.edit-schedule-btn');
        const editScheduleModal = document.getElementById('editScheduleModal');
        const editScheduleForm = document.getElementById('editScheduleForm');

        editButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const { id, practicum, room, classes, day, capacity, start, end } = event.currentTarget.dataset;
                // Mengisi nilai input
                document.getElementById('edit_practicum_id').value = practicum;
                document.getElementById('edit_room_id').value = room;
                document.getElementById('edit_class').value = classes;
                document.getElementById('edit_day').value = day;
                document.getElementById('edit_capacity').value = capacity;
                document.getElementById('edit_start_time').value = start;
                document.getElementById('edit_end_time').value = end;

                // Menetapkan action form
                editScheduleForm.action = `/schedules/${id}`;

                // Menampilkan modal
                new Modal(editScheduleModal).show();
                });
            });
        });
        document.addEventListener('alpine:init', () => {
            Alpine.data('deleteScheduleForm', () => ({
                deleteUrl: '',
                itemName: '',

                init() {
                    // Listen for delete event
                    document.addEventListener('trigger-delete', (event) => {
                        const { id, name, classes } = event.detail;
                        this.deleteUrl = `/schedules/${id}`;
                        this.itemName = `${name} ${classes}`;

                        // Open modal using Flowbite
                        const modalElement = document.getElementById('deleteScheduleModal');
                        const modal = new Modal(modalElement);
                        modal.show();
                    });
                },

                closeModal() {
                    const modalElement = document.getElementById('deleteScheduleModal');
                    const modal = new Modal(modalElement);
                    modal.hide();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>