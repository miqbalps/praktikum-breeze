<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Praktikum') }}
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
                        <x-primary-button data-modal-target="addPracticumModal" data-modal-toggle="addPracticumModal"
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
                                <th scope="col" class="px-6 py-3">Semester</th>
                                <th scope="col" class="px-6 py-3">Tahun Akademik</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($practicums as $practicum)
                            <tr class="border-b hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $practicum->name }}
                                </th>
                                <td class="px-6 py-4">{{ $practicum->semester }}</td>
                                <td class="px-6 py-4">{{ $practicum->academic_year }}</td>
                                <td class="px-6 py-4"><span class="px-3 py-1
                                    {{ $practicum->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $practicum->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $practicum->status === 'inactive' ? 'bg-red-100 text-red-800' : '' }}
                                    rounded-full text-xs">
                                        {{ ucfirst($practicum->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- <x-primary-button data-modal-target="editPracticumModal"
                                        data-modal-toggle="editPracticumModal"
                                        onclick="openEditModal('{{ $practicum->id }}', '{{ $practicum->name }}', '{{ $practicum->semester }}', '{{ $practicum->academic_year }}', '{{ $practicum->status }}')"
                                        type="button">
                                        {{ __('Edit') }}
                                    </x-primary-button> --}}
                                    <x-secondary-button x-data x-on:click="$dispatch('open-modal', {
                                        id: '{{ $practicum->id }}',
                                        name: '{{ $practicum->name }}',
                                        semester: '{{ $practicum->semester }}',
                                        academicYear: '{{ $practicum->academic_year }}',
                                        status: '{{ $practicum->status }}'
                                    })" data-modal-target="editPracticumModal" data-modal-toggle="editPracticumModal"
                                        type="button">
                                        {{ __('Ubah') }}
                                    </x-secondary-button>
                                    <x-danger-button x-data x-on:click="$dispatch('trigger-delete', {
                                        id: '{{ $practicum->id }}',
                                        name: '{{ $practicum->name }}'
                                    })" data-modal-target="deletePracticumModal"
                                        data-modal-toggle="deletePracticumModal" type="button" class="ms-1">
                                        {{ __('Hapus') }}
                                    </x-danger-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav class="items-center md:flex-row pt-4" aria-label="Table navigation">
                    {{ $practicums->links() }}
                </nav>
            </div>
        </div>
    </div>

    <x-modal-flowbite id="addPracticumModal" title="Tambah Data">
        <form method="post" action="{{ route('practicums.store') }}">
            @csrf
            @method('post')
            <div class='grid gap-4 mb-4 grid-cols-2'>
                <div class='col-span-2'>
                    <x-input-label for="name" class="block mb-2" :value="__('Nama')" />
                    <x-text-input id="name" class="block w-full" type="name" name="name" required
                        autocomplete="current-name" type="text" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="semester" class="block mb-2" :value="__('Semester')" />
                    <x-text-input id="semester" class="block w-full" type="semester" name="semester" required
                        autocomplete="current-semester" type="text" />
                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                </div>
                <div class='col-span-2 sm:col-span-1'>
                    <x-input-label for="academic_year" class="block mb-2" :value="__('Tahun Akademik')" />
                    <x-text-input id="academic_year" class="block w-full" type="academic_year" name="academic_year"
                        required autocomplete="current-academic_year" type="text" />
                    <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
                </div>
                <div class='col-span-2'>
                    <x-input-label for="status" class="block mb-2" :value="__('Status')" />
                    <x-text-input id="status" class="bg-gray-50 border text-gray-500 text-sm block w-full p-2.5"
                        type="status" name="status" value="active" readonly required autocomplete="current-status"
                        type="text" />
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

    <x-modal-flowbite id="editPracticumModal" title="Ubah Data Praktikum">
        <form x-data="editPracticumForm()" x-init="init" method="POST" :action="formAction">
            @csrf
            @method('PUT')

            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <x-input-label for="edit_name" :value="__('Nama Praktikum')" class="mb-2" />
                    <x-text-input x-model="form.name" id="edit_name" name="name" type="text" class="block w-full" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_semester" :value="__('Semester')" class="mb-2" />
                    <x-text-input x-model="form.semester" id="edit_semester" name="semester" type="text"
                        class="block w-full" />
                </div>

                <div class="col-span-2 sm:col-span-1">
                    <x-input-label for="edit_academic_year" :value="__('Tahun Akademik')" class="mb-2" />
                    <x-text-input x-model="form.academicYear" id="edit_academic_year" name="academic_year" type="text"
                        class="block w-full" />
                </div>

                <div class="col-span-2">
                    <x-input-label for="edit_status" :value="__('Status')" class="mb-2" />
                    <select x-model="form.status" id="edit_status" name="status" class="block w-full">
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <x-primary-button type="submit">
                {{ __('Simpan') }}
            </x-primary-button>
        </form>
    </x-modal-flowbite>

    <x-modal-flowbite id="deletePracticumModal" title="Konfirmasi Hapus">
        <form x-data="deletePracticumForm" x-init="init" method="POST" :action="deleteUrl">
            @csrf
            @method('DELETE')

            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Apakah Anda yakin ingin menghapus
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
        document.addEventListener('alpine:init', () => {
            Alpine.data('editPracticumForm', () => ({
                formAction: '',
                form: { name: '', semester: '', academicYear: '', status: '' },

                init() {
                    document.addEventListener('open-modal', (event) => {
                        const { id, name, semester, academicYear, status } = event.detail;

                        this.formAction = `/practicums/${id}`;
                        this.form = { name, semester, academicYear, status };

                        new Modal(document.getElementById('editPracticumModal')).show();
                    });
                }
            }));
            Alpine.data('deletePracticumForm', () => ({
                deleteUrl: '',
                itemName: '',

                init() {
                    // Listen for delete event
                    document.addEventListener('trigger-delete', (event) => {
                        const { id, name } = event.detail;
                        this.deleteUrl = `/practicums/${id}`;
                        this.itemName = name;

                        // Open modal using Flowbite
                        const modalElement = document.getElementById('deletePracticumModal');
                        const modal = new Modal(modalElement);
                        modal.show();
                    });
                },

                closeModal() {
                    const modalElement = document.getElementById('deletePracticumModal');
                    const modal = new Modal(modalElement);
                    modal.hide();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>