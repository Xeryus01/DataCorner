<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use App\Models\FooterItem;
use App\Models\SubjekMateri;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('id');

        // Paksa skema HTTPS saat di belakang proxy/SSL cPanel.
        // Tanpa ini, Laravel meng-generate URL form/aset dengan skema http://
        // sehingga diblokir oleh CSP "form-action 'self' https://...".
        if (filter_var(env('FORCE_HTTPS', false), FILTER_VALIDATE_BOOLEAN) || $this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        View::composer('*', function ($view) {
            $footerSections = collect();
            $semuaSubjekMateri = collect();

            try {
                if (Schema::hasTable('footer_items')) {
                    $footerSections = FooterItem::where('is_active', true)
                        ->orderBy('section', 'asc')
                        ->orderBy('sort_order', 'asc')
                        ->get()
                        ->groupBy('section');
                }

                if (Schema::hasTable('subjek_materis')) {
                    $semuaSubjekMateri = SubjekMateri::orderBy('judul')->get();
                }
            } catch (\Throwable $e) {
                // Aman untuk kondisi awal sebelum migrate.
                $footerSections = collect();
                $semuaSubjekMateri = collect();
            }

            $view->with('footerSections', $footerSections);
            $view->with('semua_subjek_materi', $semuaSubjekMateri);
        });
    }
}
