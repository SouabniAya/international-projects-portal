<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $query = Document::with('category.translations')->visible();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }
        if ($request->filled('category')) {
            $query->where('categoryID', $request->input('category'));
        }
        if ($request->filled('lang')) {
            $query->where('languageCode', strtolower($request->input('lang')));
        }

        $documents = $query->orderByDesc('publicationDate')->paginate(10)->withQueryString();

        $categories = DocumentCategory::with('translations')
            ->get()
            ->map(function ($cat) use ($locale) {
                $t = $cat->translations->firstWhere('languageCode', $locale);
                return [
                    'id'   => $cat->categoryID,
                    'name' => $t->categoryName ?? '',
                ];
            });

        return view('documents', [
            'documents'  => $documents,
            'categories' => $categories,
        ]);
    }

    public function download(int $documentID)
    {
        $document = Document::visible()->findOrFail($documentID);

        if ($document->externalLink) {
            return redirect()->away($document->externalLink);
        }

        if ($document->file && Storage::exists($document->file)) {
            return Storage::download($document->file, $document->title . '.' . strtolower($document->format));
        }

        abort(404);
    }
}