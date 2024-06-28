<?php

namespace Cboxdk\StatamicOverseer\Traits;

use Cboxdk\StatamicOverseer\Models\AuditLog;

trait ListensToEvents
{

    public function createEvent($event, $model = null, $old = null, $new = null): AuditLog {
        $logData = [
            'event' => $event::class,
            'data' => json_encode($event),
            'user_id' => auth()->id(),
        ];

        if ($request = request()) {
            $logData['ip_address'] = $request->getClientIp();
            $logData['ip_addresses'] = $request->ips();
            $logData['user_agent'] = $request->header('User-Agent');
            $logData['url'] = $request->url();
            $logData['method'] = $request->method();
        }
        if ($model) {
            $logData['model_type'] = $model::class;
            $logData['model_id'] = $model->id() ?? $model->id ?? null;
        }

        return AuditLog::create($logData);
    }
}