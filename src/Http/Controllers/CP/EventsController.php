<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Cboxdk\StatamicOverseer\Http\Resources\EventCollection;
use Cboxdk\StatamicOverseer\Http\Resources\EventResource;
use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Illuminate\Http\Request;
use Statamic\CP\Column;
use Statamic\Facades\Scope;
use Statamic\Http\Controllers\CP\CpController;

class EventsController extends CpController
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', OverseerEvent::class);

        return view('statamic-overseer::events.index', [
            'initialColumns' => $this->columns(),
            'filters' => Scope::filters('overseer_event', []),
        ]);
    }

    public function list(Request $request)
    {
        $this->authorize('viewAny', OverseerEvent::class);

        $query = OverseerEvent::query()
            ->orderBy($request->sort, $request->order);

        $paginator = $query->paginate($request->perPage);

        return (new EventCollection($paginator))
            ->additional([
                'meta' => [
                    'columns' => $this->columns(),
                ],
            ]);
    }

    public function show(OverseerEvent $event)
    {
        $this->authorize('viewAny', $event);

        return new EventResource($event);
    }

    protected function columns()
    {
        return [
            Column::make('recorded_at')
                ->label(__('Recorded')),
            Column::make('type')
                ->label(__('Type'))
                ->sortable(false),
            Column::make('user')
                ->label(__('User'))
                ->sortable(false),
        ];
    }
}
