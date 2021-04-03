<?php

namespace Thotam\ThotamPermission\Http\Livewire;

use Livewire\Component;
use Auth;
use Spatie\Permission\Models\Role;

class RoleLivewire extends Component
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
    public $role_id, $role;

    /**
     * @var bool
     */
    public $addStatus = false;
    public $viewStatus = false;
    public $editStatus = false;
    public $deleteStatus = false;

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
            'name' => 'required|not_regex:/^[0-9]*$/|unique:roles,name,'.$this->role_id,
            'description' => 'required',
            'group' => 'nullable',
            'order' => 'required|numeric|min:0',
        ];
    }

    /**
     * updatedDescription
     *
     * @return void
     */
    public function updatedDescription()
    {
        if (!!!$this->role_id) {
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
        return view('thotam-permission::livewire.role.role-livewire');
    }

    /**
     * add_role method
     *
     * @return void
     */
    public function add_role()
    {
        if ($this->hr->cannot("add-role")) {
            $this->dispatchBrowserEvent('toastr', ['type' => 'warning', 'title' => "Thất bại", 'message' => "Bạn không có quyền thực hiện hành động này"]);
            return null;
        }

        $this->addStatus = true;
        $this->modal_title = "Thêm Role mới";
        $group_arrays = Role::all()->pluck("group")->toArray();
        $this->group_arrays = array_filter(array_unique($group_arrays));

        $this->dispatchBrowserEvent('unblockUI');
        $this->dispatchBrowserEvent('dynamic_update');
        $this->dispatchBrowserEvent('show_modal', "#add_edit_modal");
    }

    /**
     * vn_to_str
     *
     * @param  mixed $str
     * @return void
     */
    protected function vn_to_str($str=null){

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
