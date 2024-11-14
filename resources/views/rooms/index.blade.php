<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ruangan') }}
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
                        <x-primary-button data-modal-target="addRoomModal" data-modal-toggle="addRoomModal"
                            type="button">
                            {{ __('Tambah') }}
                        </x-primary-button>
                    </div>
                </header>

                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Kapasitas</th>
                                <th scope="col" class="px-6 py-3">Jenis</th>
                                <th scope="col" class="px-6 py-3">Lokasi</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr class="border-b hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $room->name }}
                                </th>
                                <td class="px-6 py-4">{{ $room->capacity }}</td>
                                <td class="px-6 py-4">{{ $room->type }}</td>
                                <td class="px-6 py-4">{{ $room->location }}</td>
                                <td class="px-6 py-4">
                                    <x-secondary-button class="edit-room-btn" data-id="{{ $room->id }}"
                                        data-name="{{ $room->name }}" data-capacity="{{ $room->capacity }}"
                                        data-type="{{ $room->type }}" data-location="{{ $room->location }}"
                                        data-modal-target="editRoomModal" data-modal-toggle="editRoomModal">
                                        {{ __('Ubah') }}
                                    </x-secondary-button>
                                    <x-danger-button x-data x-on:click="$dispatch('trigger-delete', {
                                        id: '{{ $room->id }}',
                                        name: '{{ $room->name }}'
                                    })" data-modal-target="deleteRoomModal" data-modal-toggle="deleteRoomModal"
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
                    {{ $rooms->links() }}
                </nav>
            </div>
        </div>
    </div>

    <x-modal-flowbite id="addRoomModal" title="Tambah Data">
        <form method="post" action="{{ route('rooms.store') }}">
            @csrf
            @method('post')
            <div class='grid gap-4 mb-4 grid-cols-2'>
                <div class='col-span-2'>
                    <x-input-label for="name" class="block mb-2" :value="__('Nama')" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" required
                        autocomplete="current-name" type="text" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="capacity" class="block mb-2" :value="__('Kapasitas')" />
                    <x-text-input id="capacity" class="block w-full" type="number" name="capacity" required
                        autocomplete="current-capacity" type="number" />
                    <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="type" class="block mb-2" :value="__('Jenis')" />
                    <x-text-input id="type" class="block w-full" type="text" name="type" required
                        autocomplete="current-type" type="text" />
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
                <div class='col-span-2'>
                    <x-input-label for="location" class="block mb-2" :value="__('Lokasi')" />
                    <x-text-input id="location" class="block w-full" type="text" name="location" required
                        autocomplete="current-location" type="text" />
                    <x-input-error :messages="$errors->get('location')" class="mt-2" />
                </div>
            </div>
            {{-- <x-slot name="footer"> --}}
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                @if (session('location') === 'add-info-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{
                    __('Simpan.') }}</p>
                @endif
                {{--
            </x-slot> --}}
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="editRoomModal" title="Ubah Data Ruangan">
        <form method="POST" id="editRoomForm">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_name" :value="__('Nama')" class="mb-2" />
                    <x-text-input id="edit_name" name="name" type="text" class="block w-full" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_capacity" :value="__('Kapasitas')" class="mb-2" />
                    <x-text-input id="edit_capacity" name="capacity" type="number" class="block w-full" />
                </div>

                <div class="col-span-2">
                    <x-input-label for="edit_type" :value="__('Jenis')" class="mb-2" />
                    <x-text-input id="edit_type" name="type" type="text" class="block w-full" />
                </div>

                <div class="col-span-2">
                    <x-input-label for="edit_location" :value="__('Lokasi')" class="mb-2" />
                    <x-text-input id="edit_location" name="location" type="text" class="block w-full" />
                </div>
            </div>

            <x-primary-button type="submit">
                {{ __('Simpan') }}
            </x-primary-button>
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="deleteRoomModal" title="Konfirmasi Hapus">
        <form x-data="deleteRoomForm" x-init="init" method="POST" :action="deleteUrl">
            @csrf
            @method('DELETE')

            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin menghapus Ruang
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
        const editButtons = document.querySelectorAll('.edit-room-btn');
        const editRoomModal = document.getElementById('editRoomModal');
        const editRoomForm = document.getElementById('editRoomForm');

        editButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const { id, name, capacity, type, location } = event.currentTarget.dataset;
                // Mengisi nilai input
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_capacity').value = capacity;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_location').value = location;

                // Menetapkan action form
                editRoomForm.action = `/rooms/${id}`;

                // Menampilkan modal
                new Modal(editRoomModal).show();
                });
            });
        });
        document.addEventListener('alpine:init', () => {
            Alpine.data('deleteRoomForm', () => ({
                deleteUrl: '',
                itemName: '',

                init() {
                    // Listen for delete event
                    document.addEventListener('trigger-delete', (event) => {
                        const { id, name } = event.detail;
                        this.deleteUrl = `/rooms/${id}`;
                        this.itemName = name;

                        // Open modal using Flowbite
                        const modalElement = document.getElementById('deleteRoomModal');
                        const modal = new Modal(modalElement);
                        modal.show();
                    });
                },

                closeModal() {
                    const modalElement = document.getElementById('deleteRoomModal');
                    const modal = new Modal(modalElement);
                    modal.hide();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>