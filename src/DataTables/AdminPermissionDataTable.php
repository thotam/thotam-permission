<?php

namespace Thotam\ThotamPermission\DataTables;

use Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminPermissionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $hr = Auth::user()->hr;

        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($query) use ($hr) {
                $Action_Icon="<div class='action-div icon-4 px-0 mx-1 d-flex justify-content-around text-center'>";

                if ($hr->can("edit-permission")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' thotam-livewire-method='edit_permission' thotam-model-id='$query->id'><i class='text-indigo fas fa-edit'></i></div>";
                }

                if ($hr->can("delete-permission")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' thotam-livewire-method='delete_permission' thotam-model-id='$query->id'><i class='text-danger fas fa-trash-alt'></i></div>";
                }

                $Action_Icon.="</div>";

                return $Action_Icon;
            })
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format("d-m-Y H:i:s");
            })
            ->editColumn('updated_at', function ($query) {
                return $query->updated_at->format("d-m-Y H:i:s");
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Spatie\Permission\Models\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model)
    {
        $query = $model->newQuery();

        if (!request()->has('order')) {
            $query->orderBy('group')->orderBy('order');
        };

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('permission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'row'<'col-sm-12 table-responsive't>><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>")
                    ->parameters([
                        "autoWidth" => false,
                        "lengthMenu" => [
                            [10, 25, 50, -1],
                            [10, 25, 50, "T???t c???"]
                        ],
                        "order" => [],
                        'initComplete' => 'function(settings, json) {
                            var api = this.api();
                            window.addEventListener("dt_draw", function(e) {
                                api.draw(false);
                                e.preventDefault();
                            })
                            api.buttons()
                                .container()
                                .appendTo($("#datatable-buttons"));
                        }',
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
                  ->title("")
                  ->footer(""),
          Column::make('name')
                  ->title("T??n Permission")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("T??n Permission"),
          Column::make('description')
                  ->title("M?? t???")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("M?? t???"),
          Column::make('group')
                  ->title("Nh??m")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("Nh??m"),
          Column::computed('created_at')
                  ->width(200)
                  ->orderable(true)
                  ->title("Th???i gian t???o")
                  ->footer("Th???i gian t???o"),
          Column::computed('updated_at')
                  ->title("Th???i gian c???p nh???t")
                  ->footer("Th???i gian c???p nh???t"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Permission_' . date('YmdHis');
    }
}
