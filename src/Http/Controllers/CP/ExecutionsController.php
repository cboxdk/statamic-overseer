<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Cboxdk\StatamicOverseer\Contracts\Execution as ExecutionContract;
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
        // $this->authorize('index', ExecutionContract::class);

        return view('statamic-overseer::executions.index', [
            'initialColumns' => $this->columns(),
            'filters' => Scope::filters('overseer_execution', []),
        ]);
    }

    public function list(Request $request)
    {
        // $this->authorize('index', ExecutionContract::class);

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
        // $this->authorize('index', \Tv2regionerne\StatamicExecution\Contracts\Post::class);

        return view('statamic-overseer::executions.show', [
            'execution' => $execution,
        ]);
    }

    protected function columns()
    {
        return [
            Column::make('created_at')
                ->label(__('Date')),
            // Column::make('host')
            //     ->label(__('Host'))
            //     ->sortable(false),
            // Column::make('pid')
            //     ->label(__('PID'))
            //     ->sortable(false),
            Column::make('duration')
                ->label(__('Duration'))
                ->numeric(true)
                ->sortable(false),
            Column::make('memory')
                ->label(__('Memory'))
                ->numeric(true)
                ->sortable(false),
            Column::make('cpu_user_time')
                ->label(__('CPU User Time'))
                ->numeric(true)
                ->sortable(false),
            Column::make('cpu_system_time')
                ->label(__('CPU System Time'))
                ->numeric(true)
                ->sortable(false),
            Column::make('cpu_usage_percentage')
                ->label(__('CPU Usage Percentage'))
                ->numeric(true)
                ->sortable(false),
            Column::make('user')
                ->label(__('User'))
                ->sortable(false),
        ];
    }
}
