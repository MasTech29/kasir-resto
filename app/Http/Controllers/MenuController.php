<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required'
        ]);

        Menu::create($request->all());
        return redirect('/menu')->with('success', 'Menu ditambah');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'nama_menu' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($request->hasFile('gambar')){
            $nama_gambar = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('uploads'), $nama_gambar);
            $data['gambar'] = $nama_gambar;
        }

        $menu->update($data);
        return redirect('/menu')->with('success', 'Menu diupdate');
    }

    public function destroy($id)
    {
        Menu::findOrFail($id)->delete();
        return redirect('/menu')->with('success', 'Menu dihapus');
    }
}
