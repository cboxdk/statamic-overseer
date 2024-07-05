<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Cboxdk\StatamicOverseer\Contracts\Audit as AuditContract;
use Cboxdk\StatamicOverseer\Http\Resources\AuditCollection;
use Cboxdk\StatamicOverseer\Http\Resources\AuditResource;
use Cboxdk\StatamicOverseer\Models\OverseerAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Statamic\CP\Column;
use Statamic\Facades\Scope;
use Statamic\Http\Controllers\CP\CpController;

class AuditsController extends CpController
{

    public function __construct()
    {
        $this->authorize('access overseer');
    }

    public function index(Request $request)
    {
        // $tis->authorize('index', AuditContract::class);

        return view('statamic-overseer::audits.index', [
            'initialColumns' => $this->columns(),
            'filters' => Scope::filters('overseer_audit', []),
        ]);
    }

    public function list(Request $request)
    {
        // $this->authorize('index', AuditContract::class);

        $query = OverseerAudit::query()
            ->orderBy($request->sort, $request->order);

        $paginator = $query->paginate($request->perPage);

        return (new AuditCollection($paginator))
            ->additional([
                'meta' => [
                    'columns' => $this->columns(),
                ],
            ]);
    }

    public function show(OverseerAudit $audit)
    {
        // $this->authorize('index', \Tv2regionerne\StatamicAudit\Contracts\Post::class);

        return new AuditResource($audit);
    }

    protected function columns()
    {
        return [
            Column::make('created_at')
                ->label(__('Date')),
            Column::make('message')
                ->label(__('Message'))
                ->sortable(false),
            Column::make('subject')
                ->label(__('Subject'))
                ->sortable(false),
            Column::make('execution_id')
                ->label(__('Execution'))
                ->sortable(false),
            Column::make('user')
                ->label(__('User'))
                ->sortable(false),
        ];
    }
}
