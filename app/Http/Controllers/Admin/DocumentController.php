<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Language;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::with('category.translations');

        // Search (title + description)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Document Type filter
        if ($request->filled('documentType')) {
            $query->where('documentType', $request->input('documentType'));
        }

        // Category filter
        if ($request->filled('categoryID')) {
            $query->where('categoryID', $request->input('categoryID'));
        }

        // Language filter
        if ($request->filled('languageCode')) {
            $query->where('languageCode', $request->input('languageCode'));
        }

        // Year filter (based on publicationDate)
        if ($request->filled('year')) {
            $year = $request->input('year');
            $query->whereYear('publicationDate', $year);
        }

        $documents = $query
            ->orderByDesc('publicationDate')
            ->get()
            ->map(function ($doc) {
                $categoryName = $doc->category?->translation()?->categoryName ?? '—';
                $ext = strtolower($doc->format ?? 'pdf');

                return [
                    'id' => $doc->documentID,
                    'title' => $doc->title,
                    'desc' => $doc->description,
                    'type' => $doc->documentType,
                    'category' => $categoryName,
                    'lang' => strtoupper($doc->languageCode),
                    'date' => $doc->publicationDate ? Carbon::parse($doc->publicationDate)->format('M j, Y') : '',
                    'size' => $doc->size ? number_format($doc->size / 1048576, 1) . ' MB' : '',
                    'ext' => in_array($ext, ['pdf', 'doc', 'ppt']) ? $ext : 'pdf',
                    'file' => $doc->file,
                    'externalLink' => $doc->externalLink,
                ];
            });

        // Options for the filter dropdowns
        $documentTypes = Document::whereNotNull('documentType')
            ->where('documentType', '!=', '')
            ->distinct()
            ->orderBy('documentType')
            ->pluck('documentType');

        $categories = DocumentCategory::with('translations')->get()->map(function ($c) {
            return [
                'id' => $c->categoryID,
                'name' => $c->translation()?->categoryName ?? '—',
            ];
        });

        $languages = Language::all(['languageCode', 'label']);

        $years = Document::whereNotNull('publicationDate')
            ->get()
            ->map(fn ($doc) => Carbon::parse($doc->publicationDate)->format('Y'))
            ->unique()
            ->sortDesc()
            ->values();

        return view('admin.documents', [
            'documents' => $documents,
            'documentTypes' => $documentTypes,
            'categories' => $categories,
            'languages' => $languages,
            'years' => $years,
            'filters' => [
                'search' => $request->input('search', ''),
                'documentType' => $request->input('documentType', ''),
                'categoryID' => $request->input('categoryID', ''),
                'languageCode' => $request->input('languageCode', ''),
                'year' => $request->input('year', ''),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'documentType' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'version' => 'required|string|max:20',
            'publicationDate' => 'required|date',
            'visibilityLevel' => 'required|in:public,restricted',
            'categoryID' => 'required|exists:DocumentCategory,categoryID',
            'languageCode' => 'required|exists:Language,languageCode',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:20480',
        ]);

        $file = $request->file('file');
        $path = $file->store('documents', 'public');

        Document::create([
            'title' => $validated['title'],
            'documentType' => $validated['documentType'] ?? null,
            'description' => $validated['description'] ?? null,
            'version' => $validated['version'],
            'publicationDate' => $validated['publicationDate'],
            'format' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'visibilityLevel' => $validated['visibilityLevel'],
            'categoryID' => $validated['categoryID'],
            'languageCode' => $validated['languageCode'],
            'uploadedByUserID' => auth('admin')->id() ?? 1,
            'publicationStatus' => 'published',
            'publishedAt' => now(),
            'file' => $path,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    public function create()
    {
        $categories = DocumentCategory::with('translations')->get()->map(fn ($c) => [
            'id' => $c->categoryID,
            'name' => $c->translation()?->categoryName ?? '—',
        ]);

        $languages = Language::all(['languageCode', 'label']);

        return response()->json(['categories' => $categories, 'languages' => $languages]);
    }

    public function destroy(int $documentID)
    {
        $document = Document::findOrFail($documentID);

        // Remove the physical file from storage if one exists.
        // externalLink-only documents have nothing to delete on disk.
        if ($document->file) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($document->file);
        }

        $document->delete();

        return redirect()->route('admin.documents')->with('success', 'Document deleted.');
    }
}