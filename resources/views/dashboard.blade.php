<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <div class="sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-4 md:grid-cols-4 gap-6">
                        @foreach (Auth::user()->roles as $role)
                        @if($role->slug == 'student')
                        <x-card title="Praktikum" description="Praktikum yang diikuti."
                            link="{{ route('registrations.index') }}" wave-color="#6875F5">
                            {{ $registrations }}
                        </x-card>
                        @elseif($role->slug == 'assistant')
                        <x-card title="Praktikum" description="Praktikum yang diikuti."
                            link="{{ route('pracassistants.index') }}" wave-color="#F05252">
                            {{ $pracassistants }}
                        </x-card>
                        <x-card title="Persetujuan Peserta"
                            description="Persetujuan pendaftaran jadwal praktikum peserta."
                            link="{{ route('approvals.index') }}" wave-color="#0E9F6E">
                            {{ $registration_approvals }}
                        </x-card>
                        @elseif($role->slug == 'admin')
                        <x-card title="Ruangan" description="Jumlah ruangan yang tersedia."
                            link="{{ route('rooms.index') }}" wave-color="#0E9F6E">
                            {{ $rooms }}
                        </x-card>
                        <x-card title="Asisten" description="Jumlah keseluruhan asisten."
                            link="{{ route('assistants.index') }}" wave-color="#C27803">
                            {{ $assistants }}
                        </x-card>
                        <x-card title="Jadwal Praktikum" description="Keseluruhan jadwal praktikum."
                            link="{{ route('schedules.index') }}" wave-color="#6875F5">
                            {{ $schedules }}
                        </x-card>
                        <x-card title="Persetujuan Asisten" description="Persetujuan pendaftaran asisten praktikum."
                            link="{{ route('approvals.index') }}" wave-color="#F05252">
                            {{ $assistant_approvals }}
                        </x-card>
                        <x-card title="Persetujuan Peserta"
                            description="Persetujuan pendaftaran jadwal praktikum peserta."
                            link="{{ route('approvals.index') }}" wave-color="#0E9F6E">
                            {{ $registration_approvals }}
                        </x-card>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>