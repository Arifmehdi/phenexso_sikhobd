<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageContentController extends Controller
{
    public function index()
    {
        menuSubmenu('masters', 'pageContentsAll');
        $pageContents = PageContent::latest()->paginate(20);
        return view('admin.page_contents.index', compact('pageContents'));
    }

    public function create()
    {
        menuSubmenu('masters', 'pageContentsAll');
        return view('admin.page_contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_slug' => 'required|unique:page_contents',
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string',
            'subtitle_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
        ]);

        PageContent::create([
            'page_slug' => $request->page_slug,
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'subtitle_en' => $request->subtitle_en,
            'subtitle_bn' => $request->subtitle_bn,
            'description_en' => $request->description_en,
            'description_bn' => $request->description_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'highlights' => $request->highlights,
            'meta' => $request->meta,
            'addedby_id' => Auth::id(),
        ]);

        return redirect()->route('admin.page_contents.index')->with('success', 'Page content created successfully.');
    }

    public function show($id)
    {
        menuSubmenu('masters', 'pageContentsAll');
        $pageContent = PageContent::findOrFail($id);
        return view('admin.page_contents.show', compact('pageContent'));
    }

    public function edit($id)
    {
        menuSubmenu('masters', 'pageContentsAll');
        $pageContent = PageContent::findOrFail($id);
        return view('admin.page_contents.edit', compact('pageContent'));
    }

    public function update(Request $request, $id)
    {
        $pageContent = PageContent::findOrFail($id);

        $request->validate([
            'page_slug' => 'required|unique:page_contents,page_slug,' . $id,
            'title_en' => 'nullable|string|max:255',
            'title_bn' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string',
            'subtitle_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'description_bn' => 'nullable|string',
            'content_en' => 'nullable|string',
            'content_bn' => 'nullable|string',
        ]);

        $pageContent->update([
            'page_slug' => $request->page_slug,
            'title_en' => $request->title_en,
            'title_bn' => $request->title_bn,
            'subtitle_en' => $request->subtitle_en,
            'subtitle_bn' => $request->subtitle_bn,
            'description_en' => $request->description_en,
            'description_bn' => $request->description_bn,
            'content_en' => $request->content_en,
            'content_bn' => $request->content_bn,
            'highlights' => $request->highlights,
            'meta' => $request->meta,
            'editedby_id' => Auth::id(),
        ]);

        return redirect()->route('admin.page_contents.index')->with('success', 'Page content updated successfully.');
    }

    public function destroy($id)
    {
        $pageContent = PageContent::findOrFail($id);
        $pageContent->delete();

        return redirect()->route('admin.page_contents.index')->with('success', 'Page content deleted successfully.');
    }

    public function toggleActive(PageContent $pageContent)
    {
        $pageContent->active = !$pageContent->active;
        $pageContent->save();

        return back()->with('success', 'Status updated successfully.');
    }
}
