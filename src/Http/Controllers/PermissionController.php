<?php

namespace Thotam\ThotamPermission\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Thotam\ThotamPermission\DataTables\AdminPermissionDataTable;

class PermissionController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(AdminPermissionDataTable $dataTable)
    {
        if (Auth::user()->hr->hasAnyPermission(["view-permission", "add-permission", "edit-permission", "delete-permission"])) {
            return $dataTable->render('thotam-permission::permission', ['title' => 'Quản lý Permission']);
        } else {
            return view('errors.dynamic', [
                'error_code' => '403',
                'error_description' => 'Không có quyền truy cập',
                'title' => 'Quản lý Permission',
            ]);
        }
    }
}
