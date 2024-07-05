<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Cboxdk\StatamicOverseer\Http\Resources\ExecutionCollection;
use Cboxdk\StatamicOverseer\Models\OverseerExecution;
use Illuminate\Http\Request;
use Statamic\CP\Column;
use Statamic\Facades\Scope;
use Statamic\Http\Controllers\CP\CpController;

class ExecutionsController extends CpController
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', OverseerExecution::class);

        return view('statamic-overseer::executions.index', [
            'initialColumns' => $this->columns(),
            'filters' => Scope::filters('overseer_execution', []),
        ]);
    }

    public function list(Request $request)
    {
        $this->authorize('viewAny', OverseerExecution::class);

        $query = OverseerExecution::query()
            ->orderBy($request->sort, $request->order);

        $paginator = $query->paginate($request->perPage);

        return (new ExecutionCollection($paginator))
            ->additional([
                'meta' => [
                    'columns' => $this->columns(),
                ],
            ]);
    }

    public function show(OverseerExecution $execution)
    {
        $this->authorize('viewAny', $execution);

        return view('statamic-overseer::executions.show', [
            'execution' => $execution,
        ]);
    }

    protected function columns()
    {
        return [
            Column::make('created_at')
                ->label(__('Date')),
            Column::make('initiator')
                ->label(__('Initiator'))
                ->sortable(false),
            Column::make('counts')
                ->label(__('Counts'))
                ->numeric(true)
                ->sortable(false),
            Column::make('duration')
                ->label(__('Duration'))
                ->numeric(true)
                ->sortable(false),
            Column::make('memory')
                ->label(__('Memory'))
                ->numeric(true)
                ->sortable(false),
            Column::make('cpu')
                ->label(__('CPU Times / Usage'))
                ->numeric(true)
                ->sortable(false),
            Column::make('user')
                ->label(__('User'))
                ->sortable(false),
        ];
    }
}
