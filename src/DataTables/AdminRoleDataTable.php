<?php

namespace Thotam\ThotamPermission\DataTables;

use Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminRoleDataTable extends DataTable
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

                if ($hr->can("edit-role")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' thotam-livewire-method='edit_role' thotam-model-id='$query->id'><i class='text-indigo fas fa-edit'></i></div>";
                }

                if ($hr->can("set-role-permission")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' thotam-livewire-method='set_role_permission' thotam-model-id='$query->id'><i class='text-success fas fa-tools'></i></div>";
                }

                if ($hr->can("delete-role")) {
                    $Action_Icon.="<div class='col action-icon-w-50 action-icon' thotam-livewire-method='delete_role' thotam-model-id='$query->id'><i class='text-danger fas fa-trash-alt'></i></div>";
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
     * @param \Spatie\Permission\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
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
                    ->setTableId('role-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom("<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'row'<'col-sm-12 table-responsive't>><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>")
                    ->parameters([
                        "autoWidth" => false,
                        "lengthMenu" => [
                            [10, 25, 50, -1],
                            [10, 25, 50, "Tất cả"]
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
                  ->title("Tên Role")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("Tên Role"),
          Column::make('description')
                  ->title("Mô tả")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("Mô tả"),
          Column::make('group')
                  ->title("Nhóm")
                  ->width(150)
                  ->searchable(true)
                  ->orderable(true)
                  ->footer("Nhóm"),
          Column::computed('created_at')
                  ->width(200)
                  ->orderable(true)
                  ->title("Thời gian tạo")
                  ->footer("Thời gian tạo"),
          Column::computed('updated_at')
                  ->title("Thời gian cập nhật")
                  ->footer("Thời gian cập nhật"),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Role_' . date('YmdHis');
    }
}
