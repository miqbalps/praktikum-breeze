<div class="flex items-center p-4
    {{ $type === 'success' ? 'bg-green-50 text-green-800 border-green-300' : '' }}
    {{ $type === 'warning' ? 'bg-yellow-50 text-yellow-800 border-yellow-300' : '' }}
    {{ $type === 'error' ? 'bg-red-50 text-red-800 border-red-300' : '' }}
    {{ $type === 'info' ? 'bg-blue-50 text-blue-800 border-blue-300' : '' }}
    border rounded-lg" role="alert" x-data="{ show: true }" x-show="show">
    <div class="flex items-center">
        {{-- Icon --}}
        <svg class="flex-shrink-0 w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            @switch($type)
            @case('success')
            {{-- Ikon Centang/Check --}}
            <path fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd" />
            @break
            @case('error')
            {{-- Ikon Silang/Error --}}
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                clip-rule="evenodd" />
            @break
            @case('warning')
            {{-- Ikon Segitiga Peringatan --}}
            <path fill-rule="evenodd"
                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
            @break
            @case('info')
            {{-- Ikon Informasi --}}
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd" />
            @break
            @default
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd" />
            @endswitch
        </svg>

        {{-- Message --}}
        <span class="font-medium mr-2">{{ $message }}</span>
    </div>

    {{-- Dismiss Button (Optional) --}}
    @if($dismissible)
    <button @click="show = false" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5
                inline-flex items-center justify-center
                hover:bg-opacity-50
                focus:outline-none">
        <span class="sr-only">Close</span>
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>
    </button>
    @endif
</div>