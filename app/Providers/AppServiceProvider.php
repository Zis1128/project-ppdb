<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pendaftaran;
use App\Observers\PendaftaranObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        
        // Register Observer
        Pendaftaran::observe(PendaftaranObserver::class);

        // Debug Jurusan updates
    \App\Models\Jurusan::updating(function ($jurusan) {
        \Log::info('Jurusan updating', [
            'id' => $jurusan->id,
            'logo_old' => $jurusan->getOriginal('logo'),
            'logo_new' => $jurusan->logo,
            'attributes' => $jurusan->getAttributes()
        ]);
    });
    }
}