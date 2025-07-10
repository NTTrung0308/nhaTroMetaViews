<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesControler extends Controller
{
     public function __construct()
    {
        // Kiểm tra quyền của người dùng để tạo, sửa, xóa hợp đồng
        $this->middleware('can:Xem vai trò')->only(['index']);
        $this->middleware('can:Thêm vai trò')->only(['create', 'store']);
        $this->middleware('can:Sửa vai trò')->only(['edit', 'update']);
        $this->middleware('can:Xóa vai trò')->only(['destroy']);
    }
     public function index()
    {
        // Get all roles with their permissions
        $roles = Role::with('permissions')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    // Show the form to create a new role
    public function create()
    {
        // Get all permissions
        $permissions = Permission::all();

        return view('admin.roles.create', compact('permissions'));
    }

    // Store a newly created role
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array', // Kiểm tra nếu có ít nhất 1 quyền
        ],[
            'name.unique' => 'Tên đã tồn tại',
            'permissions.required' => 'Vui lòng chọn 1 quyền'
        ]);

        // Tạo vai trò mới
        $role = Role::create(['name' => $request->name]);

        // Gán quyền cho vai trò, dùng tên quyền thay vì ID
        $permissions = Permission::whereIn('name', $request->permissions)->get();
        $role->givePermissionTo($permissions);
         LogHelper::ghi( Auth::user()->name . 'Đã tạo vai trò mới ' . $role->name, 'Vai trò', Auth::user()->name . 'Đã tạo vai trò mới ' . $role->name . 'trong quản trị viên');
        
        return redirect()->route('admin.roles.index')->with('success', 'Tạo vai trò và gán quyền thành công.');
    }

    
    // Show the form for editing the specified role
    public function edit(Role $role)
    {
        // Get all permissions
        $permissions = Permission::all();

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    // Update the specified role in storage
    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::whereIn('id', $request->permissions)->get();

        // Gán quyền cho vai trò
        $role->syncPermissions($permissions);
               LogHelper::ghi( Auth::user()->name . 'Đã cập nhật vai trò mới ' . $role->name, 'Vai trò', Auth::user()->name . 'Đã cập nhật vai trò mới ' . $role->name . 'trong quản trị viên');

        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật vai trò thành công.');
    }

    // Remove the specified role from storage
    public function destroy(Role $role)
{
    // Không cho xóa vai trò đặc biệt
    if ($role->name === 'nguoi-thue-tro') {
        return redirect()->route('admin.roles.index')->with('error', 'Không được phép xóa vai trò người thuê trọ.');
    }
    if ($role->name === 'Super Admin') {
        return redirect()->route('admin.roles.index')->with('error', 'Không được phép xóa vai trò này.');
    }

    // Thực hiện xóa vai trò
    $role->delete();

    LogHelper::ghi(
        Auth::user()->name . ' đã xóa vai trò ' . $role->name,
        'Vai trò',
        Auth::user()->name . ' đã xóa vai trò ' . $role->name . ' trong quản trị viên'
    );

    return redirect()->route('admin.roles.index')->with('success', 'Xóa vai trò thành công.');
}

}
