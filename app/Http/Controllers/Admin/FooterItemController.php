<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FooterItemController extends Controller
{
    public function index()
    {
        $footerItems = FooterItem::orderBy('section')
            ->orderBy('sort_order')
            ->get();

        return view('admin.footer-item.index', compact('footerItems'));
    }

    public function create()
    {
        return view('admin.footer-item.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'type' => 'required|in:link,pdf,image',
            'url' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        $filePath = null;

        if (in_array($request->type, ['pdf', 'image']) && $request->hasFile('file')) {
            $filePath = $request->file('file')->store('footer-files', 'public');
        }

        FooterItem::create([
            'section' => $request->section,
            'title' => $request->title,
            'type' => $request->type,
            'url' => $request->type === 'link' ? $request->url : null,
            'file_path' => $filePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'open_new_tab' => $request->has('open_new_tab'),
        ]);

        return redirect()
            ->route('footer-item.index')
            ->with('success', 'Item footer berhasil ditambahkan.');
    }

    public function edit(FooterItem $footerItem)
    {
        return view('admin.footer-item.edit', compact('footerItem'));
    }

    public function update(Request $request, FooterItem $footerItem)
    {
        $request->validate([
            'section' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'type' => 'required|in:link,pdf,image',
            'url' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,webp|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        $filePath = $footerItem->file_path;

        if ($request->hasFile('file')) {
            if ($footerItem->file_path) {
                Storage::disk('public')->delete($footerItem->file_path);
            }

            $filePath = $request->file('file')->store('footer-files', 'public');
        }

        if ($request->type === 'link') {
            $filePath = null;
        }

        $footerItem->update([
            'section' => $request->section,
            'title' => $request->title,
            'type' => $request->type,
            'url' => $request->type === 'link' ? $request->url : null,
            'file_path' => $request->type !== 'link' ? $filePath : null,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'open_new_tab' => $request->has('open_new_tab'),
        ]);

        return redirect()
            ->route('footer-item.index')
            ->with('success', 'Item footer berhasil diperbarui.');
    }

    public function destroy(FooterItem $footerItem)
    {
        if ($footerItem->file_path) {
            Storage::disk('public')->delete($footerItem->file_path);
        }

        $footerItem->delete();

        return redirect()
            ->route('footer-item.index')
            ->with('success', 'Item footer berhasil dihapus.');
    }
}