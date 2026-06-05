<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class NotificationController extends Controller
{
    private function getAuth(): array
    {
        return [
            'VAPID' => [
                'subject'    => env('APP_URL'),
                'publicKey'  => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];
    }

    // POST /api/push/subscribe
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint'   => 'required|string',
            'public_key' => 'required|string',
            'auth_token' => 'required|string',
        ]);

        PushSubscription::updateOrCreate(
            ['endpoint' => $request->endpoint],
            ['public_key' => $request->public_key, 'auth_token' => $request->auth_token]
        );

        return response()->json(['success' => true]);
    }

    // DELETE /api/push/unsubscribe
    public function unsubscribe(Request $request)
    {
        PushSubscription::where('endpoint', $request->endpoint)->delete();
        return response()->json(['success' => true]);
    }

    // POST /api/push/send
    public function send(Request $request)
    {
        $request->validate([
            'title'   => 'required|string',
            'body'    => 'required|string',
            'url'     => 'nullable|string',
            'icon'    => 'nullable|string',
        ]);

        $subscriptions = PushSubscription::all();
        if ($subscriptions->isEmpty()) {
            return response()->json(['sent' => 0, 'message' => 'Aucun abonné']);
        }

        $webPush = new WebPush($this->getAuth());

        $payload = json_encode([
            'title' => $request->title,
            'body'  => $request->body,
            'url'   => $request->url ?? '/',
            'icon'  => $request->icon ?? '/logo_leer_app.svg',
        ]);

        foreach ($subscriptions as $sub) {
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint'        => $sub->endpoint,
                    'publicKey'       => $sub->public_key,
                    'authToken'       => $sub->auth_token,
                    'contentEncoding' => 'aesgcm',
                ]),
                $payload
            );
        }

        $sent = 0;
        $failed = [];
        foreach ($webPush->flush() as $report) {
            if ($report->isSuccess()) {
                $sent++;
            } else {
                // Supprimer les subscriptions invalides
                if ($report->isSubscriptionExpired()) {
                    PushSubscription::where('endpoint', $report->getEndpoint())->delete();
                }
                $failed[] = $report->getReason();
            }
        }

        return response()->json(['sent' => $sent, 'failed' => count($failed)]);
    }

    // GET /api/push/vapid-key
    public function vapidKey()
    {
        return response()->json(['key' => env('VAPID_PUBLIC_KEY')]);
    }
}
