<?php

namespace App\DataTables;

use App\Models\Post;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class PostsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('description', function ($post) {
                return $post->description;
            })
            ->addColumn('image', function ($post) {
                return $post->image
                    ? '<img src="' . asset('storage/' . $post->image) . '" class="w-24 max-w-xs">'
                    : '';
            })
            ->editColumn('date', function ($post) {

                return $post->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($post) {
                $url = route('posts.status', $post->slug);

                return $post->status
                    ? '<button data-url="' . $url . '" class="btn-status text-green-600 font-semibold">active</button>'
                    : '<button  data-url="' . $url . '" class="btn-status text-red-600 font-semibold">inactive</button>';
                // one button
            })
            ->addColumn('control', function ($post) {
                return view('components.controls', compact('post'))->render();
            })
            ->setRowId('id')
            // need this because I have html for these columns
            ->rawColumns(['image', 'status', 'control']);
    }

    public function query(Post $post)
    {
        return $post->newQuery();
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                // 'responsive' => true,
                'processing' => true,
                'serverSide' => true,
                'orderCellsTop' => true,
                'layout' => [
                    'top9Start'    => 'buttons',
                    'topEnd'      => 'search',
                    'bottomStart' => 'info',
                    'bottomEnd'   => 'paging',
                ],
                'buttons' => ['csv', 'excel'],

                'initComplete' => 'function(){
                    const table = this.api();
                    const $thead = $(table.table().header());
                    const $filterRow = $thead.find("tr").clone().addClass("filter");

                    $filterRow.find("th").each(function() {

                        const $currentTh = $(this);

                        if(!$currentTh.hasClass("no-search")) {

                            const input = $(`<input type="text" class="w-full border px-1 py-1 text-sm rounded" placeholder="Search" /> `);
                            $currentTh.html(input);

                            $(input).on("click", function(event) {
                                event.stopPropagation();
                            });

                            $(input).on("keyup change clear", function() {
                                if (table.column($currentTh.index()).search() !== this.value) {
                                    table.column($currentTh.index()).search(this.value).draw();
                                }
                            });

                        } else if ($currentTh.hasClass("status-filter")) {
                            const select = $(`<select class="w-full border px-1 py-1 text-sm rounded" placeholder="Search" /> `);

                            const op1 = $(`<option value ="">all</option>`);
                            const op2 = $(`<option value ="1">active</option>`);
                            const op3 = $(`<option value ="0">inactive</option>`);

                            $(select).append(op1);
                            $(select).append(op2);
                            $(select).append(op3);

                            $currentTh.html(select);

                            $(select).on("change", function() {
                                table.column($currentTh.index()).search(this.value).draw();
                            });
                            
                        } else {
                            $currentTh.empty();
                            
                        }
                    });

                    $thead.append($filterRow);
                }'
            ]);
    }



    public function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('description'),
            Column::make('image')
                ->orderable(false)
                ->searchable(false)
                ->addClass('no-search'),
            Column::make('date')
                ->data('date')
                ->name('created_at')
                ->width(120),
            Column::make('status')
                ->addClass('no-search status-filter'),
            Column::make('control')
                ->orderable(false)
                ->searchable(false)
                ->addClass('no-search')
        ];
    }
}
