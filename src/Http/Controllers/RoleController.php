<?php

namespace Thotam\ThotamPermission\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class RoleController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index(AdminRoleDataTable $dataTable)
    {
        if (Auth::user()->hr->hasAnyPermission(["view-role", "add-role", "edit-role", "set-role-permission", "delete-role"])) {
            return $dataTable->render('thotam-permission::role', ['title' => 'Quản lý Role']);
        } else {
            return view('errors.dynamic', [
                'error_code' => '403',
                'error_description' => 'Không có quyền truy cập',
                'title' => 'Quản lý Role',
            ]);
        }
    }
}
