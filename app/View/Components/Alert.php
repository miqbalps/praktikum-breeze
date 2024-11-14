<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public $dismissible;

    protected $validTypes = ['success', 'error', 'warning', 'info'];

    public function __construct(
        $type = 'info',
        $message = '',
        $dismissible = false
    ) {
        // Validasi tipe alert
        if (!in_array($type, $this->validTypes)) {
            $type = 'info'; // Default ke 'info' jika tipe tidak valid
        }

        $this->type = $type;
        $this->message = $message;
        $this->dismissible = $dismissible;
    }

    public function render()
    {
        return view('components.alert');
    }

    public function getTypeClass()
    {
        $alertTypes = [
            'success' => [
                'text' => 'text-green-800',
                'bg' => 'bg-green-50',
                'border' => 'border-green-300'
            ],
            'error' => [
                'text' => 'text-red-800',
                'bg' => 'bg-red-50',
                'border' => 'border-red-300'
            ],
            'warning' => [
                'text' => 'text-yellow-800',
                'bg' => 'bg-yellow-50',
                'border' => 'border-yellow-300'
            ],
            'info' => [
                'text' => 'text-blue-800',
                'bg' => 'bg-blue-50',
                'border' => 'border-blue-300'
            ]
        ];

        return $alertTypes[$this->type];
    }
}
