<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asisten') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6  lg:px-8">
            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header class="flex align-items-center justify-between">
                    <h2 class="text-lg font-medium mb-6 text-gray-900">
                        {{ __('Tampil Data') }}
                    </h2>

                    <div class="button-add">
                        <x-primary-button data-modal-target="addAssistantModal" data-modal-toggle="addAssistantModal"
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
                                <th scope="col" class="px-6 py-3">Jenis</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assistants as $assistant)
                            @if (($assistant->status == 'active' || $assistant->status == 'inactive'))
                            <tr class="border-b hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $assistant->user->name }}
                                </th>

                                <td class="px-6 py-4">
                                    @if ($assistant->type == 'student')
                                    Mahasiswa
                                    @elseif($assistant->type == 'non_student')
                                    Umum
                                    @endif
                                </td>
                                <td class="px-6 py-4"><span class="px-3 py-1
                                    {{ $assistant->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $assistant->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $assistant->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                    rounded-full text-xs">
                                        {{ ucfirst($assistant->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <x-secondary-button class="edit-assistant-btn" data-id="{{ $assistant->id }}"
                                        data-name="{{ $assistant->user->name }}" data-type="{{ $assistant->type }}"
                                        data-status="{{ $assistant->status }}" data-modal-target="editAssistantModal"
                                        data-modal-toggle="editAssistantModal">
                                        {{ __('Ubah') }}
                                    </x-secondary-button>
                                    <x-danger-button x-data x-on:click="$dispatch('trigger-delete', {
                                        id: '{{ $assistant->id }}',
                                        name: '{{ $assistant->user->name }}'
                                    })" data-modal-target="deleteAssistantModal"
                                        data-modal-toggle="deleteAssistantModal" type="button" class="ms-1">
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
                    {{ $assistants->links() }}
                </nav>
            </div>
        </div>
    </div>

    <x-modal-flowbite id="addAssistantModal" title="Tambah Data">
        <form method="post" action="{{ route('assistants.store') }}">
            @csrf
            @method('post')
            <div class='grid gap-4 mb-4 grid-cols-2'>

                <div class='col-span-2'>
                    <x-input-label for="name" class="block mb-2" :value="__('Nama')" />
                    <x-text-input id="name" class="block w-full" type="text" name="name" required
                        autocomplete="current-name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class='col-span-2'>
                    <x-input-label for="email" class="block mb-2" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full" type="text" name="email" required
                        autocomplete="current-email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class='col-span-2'>
                    <x-input-label for="password" class="block mb-2" :value="__('Password')" />
                    <x-text-input id="password" class="block w-full" type="text" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class='col-span-2'>
                    <x-input-label for="password_confirmation" class="block mb-2" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" class="block w-full" type="text"
                        name="password_confirmation" required autocomplete="current-password-confirmation" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class='col-span-2'>
                    <x-input-label for="type" class="block mb-2" :value="__('Jenis')" />
                    <select id="type" name="type"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="student">Mahasiswa</option>
                        <option value="non_student">Umum</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
                <div class='col-span-2'>
                    <x-input-label for="status" class="block mb-2" :value="__('Status')" />
                    <select id="status" name="status"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        readonly>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
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

    <x-modal-flowbite id="editAssistantModal" title="Ubah Data Assistant">
        <form method="POST" id="editAssistantForm">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <x-input-label for="edit_name" :value="__('Nama')" class="mb-2" />
                    <x-text-input id="edit_name" name="name" type="text" class="block w-full" readonly />
                </div>

                <div class="col-span-2">
                    <x-input-label for="edit_type" :value="__('Jenis')" class="mb-2" />
                    <select id="edit_type" name="type" type="text"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih jenis</option>
                        <option value="student">Mahasiswa</option>
                        <option value="non_student">Umum</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <x-input-label for="edit_status" :value="__('Status')" class="mb-2" />
                    <select id="edit_status" name="status" type="text"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option disabled selected>Pilih status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <x-primary-button type="submit">
                {{ __('Simpan') }}
            </x-primary-button>
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="deleteAssistantModal" title="Konfirmasi Hapus">
        <form x-data="deleteAssistantForm" x-init="init" method="POST" :action="deleteUrl">
            @csrf
            @method('DELETE')

            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin menghapus Assistant
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
        const editAssistantBtn = document.querySelectorAll('.edit-assistant-btn');
        const editAssistantModal = document.getElementById('editAssistantModal');
        const editAssistantForm = document.getElementById('editAssistantForm');

        editAssistantBtn.forEach(button => {
            button.addEventListener('click', (event) => {
                const { id, name, type, status } = event.currentTarget.dataset;
                // Mengisi nilai input
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_type').value = type;
                document.getElementById('edit_status').value = status;

                // Menetapkan action form
                editAssistantForm.action = `/assistants/${id}`;

                // Menampilkan modal
                new Modal(editAssistantModal).show();
                });
            });
        });
        document.addEventListener('alpine:init', () => {
            Alpine.data('deleteAssistantForm', () => ({
                deleteUrl: '',
                itemName: '',

                init() {
                    // Listen for delete event
                    document.addEventListener('trigger-delete', (event) => {
                        const { id, name } = event.detail;
                        this.deleteUrl = `/assistants/${id}`;
                        this.itemName = name;

                        // Open modal using Flowbite
                        const modalElement = document.getElementById('deleteAssistantModal');
                        const modal = new Modal(modalElement);
                        modal.show();
                    });
                },

                closeModal() {
                    const modalElement = document.getElementById('deleteAssistantModal');
                    const modal = new Modal(modalElement);
                    modal.hide();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>