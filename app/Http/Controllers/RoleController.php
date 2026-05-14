<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService) {}

    public function index()
    {
        return view('pages.role', [
            'title'          => 'Roles',
            'availableMenus' => $this->roleService->availableMenus(),
        ]);
    }

    public function datatableAjax(Request $request)
    {
        $params = $request->only(['draw', 'start', 'length', 'search', 'order', 'columns']);
        $result = $this->roleService->getDatatable($params);

        if ($result->success) {
            return response()->json($result->data);
        }

        return response()->json(['error' => $result->message], $result->statusCode);
    }

    public function store(Request $request)
    {
        $result = $this->roleService->createRole($request->only(['name']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Role created successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function update(Request $request, string $id)
    {
        $result = $this->roleService->updateRole($id, $request->only(['name']));

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Role updated successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function destroy(string $id)
    {
        $result = $this->roleService->deleteRole($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Role deleted successfully.' : $result->message,
        ], $result->statusCode);
    }

    public function getRoleMenus(string $roleId)
    {
        $result = $this->roleService->getRoleMenus($roleId);

        if ($result->success) {
            return response()->json(['success' => true, 'data' => $result->data]);
        }

        return response()->json(['success' => false, 'message' => $result->message], $result->statusCode);
    }

    public function assignMenus(Request $request, string $roleId)
    {
        $menuIds = $request->input('menuIds', []);
        $result  = $this->roleService->assignMenus($roleId, $menuIds);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Menus assigned successfully.' : $result->message,
            'data'    => $result->data,
        ], $result->statusCode);
    }

    public function removeMenu(string $roleId, string $menuId)
    {
        $result = $this->roleService->removeMenu($roleId, $menuId);

        return response()->json([
            'success' => $result->success,
            'message' => $result->success ? 'Menu removed successfully.' : $result->message,
        ], $result->statusCode);
    }
}
