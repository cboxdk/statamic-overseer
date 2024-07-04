<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Cboxdk\StatamicOverseer\Contracts\Event as EventContract;
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
        // $this->authorize('index', EventContract::class);

        return view('statamic-overseer::events.index', [
            'initialColumns' => $this->columns(),
            'filters' => Scope::filters('overseer_event', []),
        ]);
    }

    public function list(Request $request)
    {
        // $this->authorize('index', EventContract::class);

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
        // $this->authorize('index', \Tv2regionerne\StatamicEvent\Contracts\Post::class);

        return new EventResource($event);
    }

    protected function columns()
    {
        return [
            Column::make('created_at')
                ->label(__('Date')),
            Column::make('type')
                ->label(__('Type'))
                ->sortable(false),
            Column::make('recorded_at')
                ->label(__('Recorded'))
                ->sortable(false),
            Column::make('user')
                ->label(__('User'))
                ->sortable(false),
        ];
    }
}
