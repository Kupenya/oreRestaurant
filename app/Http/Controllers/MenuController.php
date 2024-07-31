<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MenuController extends Controller
{
/**
* Retrieve all menu items.
*
* @return \Illuminate\Http\JsonResponse
*/
public function index()
{
$menus = Menu::all(); // Retrieve all menu items
return response()->json($menus); // Return as JSON response
}

/**
* Retrieve a specific menu item by ID.
*
* @param int $id
* @return \Illuminate\Http\JsonResponse
*/
public function show(int $id)
{
$menu = Menu::find($id); // Find the menu item by ID
if (!$menu) {
return response()->json(['message' => 'Menu item not found'], 404); // Item not found
}
return response()->json($menu); // Return the menu item as JSON response
}

/**
* Create a new menu item.
*
* @param \Illuminate\Http\Request $request
* @return \Illuminate\Http\JsonResponse
* @throws ValidationException
*/
public function store(Request $request)
{
$this->authorize('create', Menu::class); // Check if the user has permission to create a menu item

$validated = $request->validate([
'name' => 'required|string|max:255',
'price' => 'required|numeric',
'category' => 'required|string',
'description' => 'nullable|string',
'is_discounted' => 'nullable|boolean', // Nullable boolean validation
]);

$menu = Menu::create($validated); // Create and save the new menu item
return response()->json($menu, 201); // Return created menu item with 201 status
}

/**
* Update an existing menu item.
*
* @param \Illuminate\Http\Request $request
* @param int $id
* @return \Illuminate\Http\JsonResponse
* @throws ValidationException
*/
public function update(Request $request, int $id)
{
$menu = Menu::find($id); // Find the menu item by ID
if (!$menu) {
return response()->json(['message' => 'Menu item not found'], 404); // Item not found
}

$this->authorize('update', $menu); // Check if the user has permission to update the menu item

$validated = $request->validate([
'name' => 'sometimes|string|max:255',
'price' => 'sometimes|numeric',
'category' => 'sometimes|string',
'description' => 'nullable|string',
'is_discounted' => 'nullable|boolean', // Nullable boolean validation
]);

$menu->update($validated); // Update the menu item with new data
return response()->json($menu); // Return updated menu item
}

/**
* Delete a menu item.
*
* @param int $id
* @return \Illuminate\Http\JsonResponse
*/
public function destroy(int $id)
{
$menu = Menu::find($id); // Find the menu item by ID
if (!$menu) {
return response()->json(['message' => 'Menu item not found'], 404); // Item not found
}

$this->authorize('delete', $menu); // Check if the user has permission to delete the menu item

$menu->delete(); // Delete the menu item
return response()->json(['message' => 'Menu item deleted successfully']); // Return success message
}

/**
* Retrieve discounted menu items.
*
* @return \Illuminate\Http\JsonResponse
*/
public function discounted()
{
$menus = Menu::where('is_discounted', true)->get(); // Retrieve discounted menu items
return response()->json($menus); // Return as JSON response
}

/**
* Retrieve menu items by category.
*
* @param string $category
* @return \Illuminate\Http\JsonResponse
*/
public function byCategory(string $category)
{
$menus = Menu::where('category', $category)->get(); // Retrieve menu items by category
return response()->json($menus); // Return as JSON response
}

/**
* Retrieve drinks menu items.
*
* @return \Illuminate\Http\JsonResponse
*/

}