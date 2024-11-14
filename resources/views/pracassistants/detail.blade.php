<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asisten Praktikum') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 mb-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium mb-6 text-gray-900">
                            {{ __('Detail Praktikum') }}
                        </h2>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $pracassistant->schedule->practicum->name }}
                                    </th>
                                    <td class="px-6 py-4">{{ $pracassistant->schedule->room->name }}</td>
                                    <td class="px-6 py-4">{{ $pracassistant->schedule->class }}</td>
                                    <td class="px-6 py-4">{{ $pracassistant->schedule->day }}</td>
                                    <td class="px-6 py-4">{{ date('H:i:s',
                                        strtotime($pracassistant->schedule->start_time))
                                        }}</td>
                                    <td class="px-6 py-4">{{ date('H:i:s',
                                        strtotime($pracassistant->schedule->end_time)) }}
                                    </td>
                                    <td class="px-6 py-4">{{ $pracassistant->schedule->capacity }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg h-fit">
                <section>
                    <header>
                        <h2 class="text-lg font-medium mb-6 text-gray-900">
                            {{ __('Data Peserta') }}
                        </h2>
                    </header>

                    <div class="relative overflow-x-auto sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">NRP</th>
                                    <th scope="col" class="px-6 py-3">Prodi</th>
                                    <th scope="col" class="px-6 py-3">Angkatan</th>
                                    <th scope="col" class="px-6 py-3">Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr class="border-b hover:bg-gray-50 odd:bg-white even:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $student->user->name }}
                                    </th>
                                    <td class="px-6 py-4">{{ $student->user->email }}</td>
                                    <td class="px-6 py-4">{{ $student->nrp }}</td>
                                    <td class="px-6 py-4">{{ $student->department }}</td>
                                    <td class="px-6 py-4">{{ $student->batch }}</td>
                                    <td class="px-6 py-4">{{ $student->phone }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <nav class="items-center md:flex-row pt-4" aria-label="Table navigation">
                        {{ $students->links() }}
                    </nav>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>