<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gunakan Bootstrap 5 pagination
        Paginator::useBootstrapFive();

        // Force APP_URL via resolving callback — aman dipanggil kapanpun URL service siap
        $this->app->resolving('url', function ($url, $app) {
            $appUrl = rtrim($app['config']['app.url'] ?? '', '/');
            if ($appUrl) {
                $url->forceRootUrl($appUrl);
            }
        });

        // Patch SMTP — nonaktifkan SSL verify untuk XAMPP localhost
        Mail::extend('smtp', function (array $config) {
            $encryption  = strtolower($config['encryption'] ?? 'tls');
            $port        = (int) ($config['port'] ?? 587);
            $implicitTls = ($encryption === 'ssl' || $port === 465);

            $transport = new EsmtpTransport(
                host:       $config['host'] ?? '127.0.0.1',
                port:       $port,
                tls:        $implicitTls,
                dispatcher: null,
                logger:     null
            );

            if (!empty($config['username'])) {
                $transport->setUsername($config['username']);
            }
            if (!empty($config['password'])) {
                $transport->setPassword($config['password']);
            }

            $stream = $transport->getStream();
            $stream->setStreamOptions([
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                ],
            ]);

            return $transport;
        });
    }
}
