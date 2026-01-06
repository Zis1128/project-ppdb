<?php

namespace App\Livewire;

use Livewire\Component;

class TestButton extends Component
{
    public $message = 'Belum diklik';

    public function testClick()
    {
        $this->message = 'Tombol berhasil diklik! Livewire jalan!';
    }

    public function render()
    {
        return view('livewire.test-button');
    }
}