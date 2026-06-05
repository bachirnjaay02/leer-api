<?php

namespace App\Console\Commands;

use App\Models\PushSubscription;
use Illuminate\Console\Command;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class SendPrayerNotifications extends Command
{
    protected $signature   = 'prayers:notify';
    protected $description = 'Envoie les notifications de prières à l\'heure exacte';

    private array $prayerNames = [
        'fajr'    => ['fr' => 'Fajr',    'ar' => 'الفجر',   'icon' => '🌙'],
        'sunrise' => ['fr' => 'Lever',   'ar' => 'الشروق',  'icon' => '🌅'],
        'dhuhr'   => ['fr' => 'Dhuhr',   'ar' => 'الظهر',   'icon' => '☀️'],
        'asr'     => ['fr' => 'Asr',     'ar' => 'العصر',   'icon' => '🌤'],
        'maghrib' => ['fr' => 'Maghrib', 'ar' => 'المغرب',  'icon' => '🌇'],
        'isha'    => ['fr' => 'Isha',    'ar' => 'العشاء',  'icon' => '🌃'],
    ];

    public function handle(): void
    {
        $subscriptions = PushSubscription::whereNotNull('prayer_times')->get();
        if ($subscriptions->isEmpty()) return;

        $auth = [
            'VAPID' => [
                'subject'    => env('APP_URL'),
                'publicKey'  => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);
        $sent    = 0;

        foreach ($subscriptions as $sub) {
            $times    = $sub->prayer_times;
            $timezone = $sub->timezone ?? 'Africa/Dakar';

            try {
                $tz  = new \DateTimeZone($timezone);
                $now = new \DateTime('now', $tz);
                $currentTime = $now->format('H:i');
            } catch (\Exception $e) {
                $currentTime = (new \DateTime('now', new \DateTimeZone('Africa/Dakar')))->format('H:i');
            }

            foreach ($this->prayerNames as $key => $info) {
                if (empty($times[$key])) continue;
                if ($times[$key] !== $currentTime) continue;

                $title   = "{$info['icon']} {$info['fr']} — وقت الصلاة";
                $body    = "C'est l'heure de {$info['fr']} · {$info['ar']}";
                $payload = json_encode([
                    'title' => $title,
                    'body'  => $body,
                    'url'   => '/prieres',
                    'icon'  => '/logo_leer_app.svg',
                ]);

                $webPush->queueNotification(
                    Subscription::create([
                        'endpoint'        => $sub->endpoint,
                        'publicKey'       => $sub->public_key,
                        'authToken'       => $sub->auth_token,
                        'contentEncoding' => 'aesgcm',
                    ]),
                    $payload
                );
                $sent++;
            }
        }

        if ($sent > 0) {
            foreach ($webPush->flush() as $report) {
                if ($report->isSubscriptionExpired()) {
                    PushSubscription::where('endpoint', $report->getEndpoint())->delete();
                }
            }
            $this->info("$sent notification(s) de prière envoyée(s).");
        }
    }
}
