<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach (Auth::user()->roles as $role)
            @if($role->slug == 'assistant')
            <div class="p-4 sm:p-8 bg-white mb-6 overflow-hidden shadow-sm sm:rounded-lg">
                <header class="flex align-items-center justify-between">
                    <h2 class="text-lg font-medium mb-6 text-gray-900">
                        {{ __('Data Pendaftaran Praktikum') }}
                    </h2>
                </header>

                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Peserta</th>
                                <th scope="col" class="px-6 py-3">Praktikum</th>
                                <th scope="col" class="px-6 py-3">Kelas</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pendaftaran</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                            @if ($registration->status == 'pending' )
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrape">
                                    {{ $registration->student->user->name }}
                                </th>
                                <td class="px-6 py-4">{{ $registration->schedule->practicum->name}}</td>
                                <td class="px-6 py-4">{{ $registration->schedule->class}}</td>
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
                                <td class="flex flex-row px-6 py-4">
                                    <div>
                                        <form action="{{ route('approve.registration', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-primary-button type='submit'>
                                                {{ __('Setuju') }}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                    <div class="ms-2">
                                        <form action="{{ route('reject.registration', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-danger-button type='submit'>
                                                {{ __('Tolak') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
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

            @elseif($role->slug == 'admin')
            <div class="p-4 sm:p-8 bg-white mb-6 overflow-hidden shadow-sm sm:rounded-lg">
                <header class="flex align-items-center justify-between">
                    <h2 class="text-lg font-medium mb-6 text-gray-900">
                        {{ __('Data Pendaftaran Praktikum') }}
                    </h2>
                </header>

                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nama Peserta</th>
                                <th scope="col" class="px-6 py-3">Praktikum</th>
                                <th scope="col" class="px-6 py-3">Kelas</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pendaftaran</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registrations as $registration)
                            @if ($registration->status == 'pending' )
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrape">
                                    {{ $registration->student->user->name }}
                                </th>
                                <td class="px-6 py-4">{{ $registration->schedule->practicum->name}}</td>
                                <td class="px-6 py-4">{{ $registration->schedule->class}}</td>
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
                                <td class="flex flex-row px-6 py-4">
                                    <div>
                                        <form action="{{ route('approve.registration', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-primary-button type='submit'>
                                                {{ __('Setuju') }}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                    <div class="ms-2">
                                        <form action="{{ route('reject.registration', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-danger-button type='submit'>
                                                {{ __('Tolak') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
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

            <div class="p-4 sm:p-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <header class="flex align-items-center justify-between">
                    <h2 class="text-lg font-medium mb-6 text-gray-900">
                        {{ __('Data Pendaftaran Asisten') }}
                    </h2>
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
                            @if ($assistant->status == 'pending' )
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
                                <td class="flex flex-row px-6 py-4">
                                    <div>
                                        <form action="{{ route('approve.assistant', $assistant->id) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-primary-button type='submit'>
                                                {{ __('Setuju') }}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                    <div class="ms-2">
                                        <form action="{{ route('reject.assistant', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('patch')
                                            <x-danger-button type='submit'>
                                                {{ __('Tolak') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
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
            @endif
            @endforeach
        </div>
    </div>
</x-app-layout>