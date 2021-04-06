<?php

namespace Thotam\ThotamPermission\Http\Livewire;

use Livewire\Component;
use Auth;
use Spatie\Permission\Models\Permission;

class PermissionLivewire extends Component
{
    /**
    * Các biến sử dụng trong Component
    *
    * @var mixed
    */
    public $name, $description, $group, $order;
    public $user_info, $modal_title, $toastr_message;
    public $group_arrays = [];
    public $hr;
    public $permission_id, $permission;

    /**
     * @var bool
     */
    public $addStatus = false;
    public $viewStatus = false;
    public $editStatus = false;
    public $deleteStatus = false;

    /**
     * Các biển sự kiện
     *
     * @var array
     */
    protected $listeners = ['dynamic_update_method', 'edit_permission', 'delete_permission', ];

    /**
     * dynamic_update_method
     *
     * @return void
     */
    public function dynamic_update_method()
    {
        $this->dispatchBrowserEvent('dynamic_update');
    }

    /**
     * On updated action
     *
     * @param  mixed $propertyName
     * @return void
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Validation rules
     *
     * @var array
     */
    protected function rules() {
        return [
            'name' => 'required|not_regex:/^[0-9]*$/|unique:permissions,name,'.$this->permission_id,
            'description' => 'required',
            'group' => 'nullable',
            'order' => 'required|numeric|min:0',
        ];
    }

    /**
     * Custom attributes
     *
     * @var array
     */
    protected $validationAttributes = [
        'name' => 'tên Permission',
        'description' => 'mô tả Permission',
        'group' => 'nhóm Permission',
        'order' => 'số thứ tự',
    ];

    /**
     * updatedDescription
     *
     * @return void
     */
    public function updatedDescription()
    {
        if (!!!$this->permission_id) {
            $this->name = mb_convert_case($this->vn_to_str(trim($this->description)), MB_CASE_LOWER, "UTF-8");
        }
    }

    /**
     * cancel
     *
     * @return void
     */
    public function cancel()
    {
        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('hide_modals');
        $this->reset();
        $this->addStatus = false;
        $this->editStatus = false;
        $this->viewStatus = false;
        $this->deleteStatus = false;
        $this->resetValidation();
        $this->mount();
    }

    /**
     * mount data
     *
     * @return void
     */
    public function mount()
    {
        $this->hr = Auth::user()->hr;
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('thotam-permission::livewire.permission.permission-livewire');
    }

    /**
     * add_permission method
     *
     * @return void
     */
    public function add_permission()
    {
        if ($this->hr->cannot("add-permission")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            $this->cancel();
            return null;
        }

        $this->addStatus = true;
        $this->modal_title = "Thêm Permission mới";
        $this->toastr_message = "Thêm Permission mới thành công";
        $group_arrays = Permission::all()->pluck("group")->toArray();
        $this->group_arrays = array_filter(array_unique($group_arrays));

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#add_edit_modal");
    }

    /**
     * edit_permission
     *
     * @param  mixed $permission
     * @return void
     */
    public function edit_permission(Permission $permission)
    {
        if ($this->hr->cannot("edit-permission")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            $this->cancel();
            return null;
        }

        $this->permission = $permission;
        $this->permission_id = $this->permission->id;
        $this->name = $this->permission->name;
        $this->description = $this->permission->description;
        $this->group = $this->permission->group;
        $this->order = $this->permission->order;
        $this->editStatus = true;
        $this->modal_title = "Chỉnh sửa Permission";
        $this->toastr_message = "Chỉnh sửa Permission thành công";
        $group_arrays = Permission::all()->pluck("group")->toArray();
        $this->group_arrays = array_filter(array_unique($group_arrays));

        if (!!$this->permission->lock) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Permission đã khóa, không thể chỉnh sửa"]);
            $this->cancel();
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#add_edit_modal");
    }

    /**
     * Lưu lại thông tin
     *
     * @return void
     */
    public function save()
    {
        if (!$this->hr->canAny(["add-permission", "edit-permission"])) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        //Xác thực dữ liệu
        if (!!optional($this->permission)->lock) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Permission đã khóa, không thể chỉnh sửa"]);
            return null;
        }

        $this->dispatchBrowserEvent('unblockUI');
        $this->validate();
        $this->dispatchBrowserEvent('blockUI');

        try {
            Permission::updateOrCreate([
                "id" => $this->permission_id,
            ], [
                'name' => mb_convert_case($this->vn_to_str(trim($this->name)), MB_CASE_LOWER, "UTF-8"),
                "description" => $this->description,
                "group" => $this->group,
                "order" => $this->order
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        //Đẩy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }

    /**
     * delete_permission
     *
     * @param  mixed $permission
     * @return void
     */
    public function delete_permission(Permission $permission)
    {
        if ($this->hr->cannot("delete-permission")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            $this->cancel();
            return null;
        }

        $this->permission = $permission;
        $this->name = $this->permission->name;
        $this->description = $this->permission->description;
        $this->group = $this->permission->group;
        $this->order = $this->permission->order;

        if (!!$this->permission->lock) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Permission đã khóa, không thể xóa"]);
            $this->cancel();
            return null;
        }

        $this->deleteStatus = true;
        $this->modal_title = "Xóa Permission";
        $this->toastr_message = "Xóa Permission thành công";

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#delete_modal");
    }

    /**
     * Xóa thôi nào
     *
     * @return void
     */
    public function delete()
    {
        if ($this->hr->cannot("delete-permission")) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        //Xác thực dữ liệu
        if (!!$this->permission->lock) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Permission đã khóa, không thể xóa"]);
            return null;
        }

        try {
            $this->permission->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => implode(" - ", $e->errorInfo)]);
            return null;
        } catch (\Exception $e2) {
            $this->dispatchBrowserEvent('unblockUI');
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => $e2->getMessage()]);
            return null;
        }

        //Đẩy thông tin về trình duyệt
        $this->dispatchBrowserEvent('dt_draw');
        $toastr_message = $this->toastr_message;
        $this->cancel();
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'title' => "Thành công", 'message' => $toastr_message]);
    }

    /**
     * vn_to_str
     *
     * @param  mixed $str
     * @return void
     */
    protected function vn_to_str($str=null) {

        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach($unicode as $nonUnicode=>$uni){
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        $str = str_replace(' ','-',$str);

        return $str;
    }
}
