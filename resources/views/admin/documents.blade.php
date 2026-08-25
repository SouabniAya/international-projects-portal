@extends('layouts.admin')

@section('title', 'Documents')

@section('content')
<div class="documents-page">

    <a href="{{ url('/admin/projects') }}" class="documents-page__back">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Back to Projects
    </a>

    <div class="documents-page__head">
        <div>
            <h1>Documents</h1>
            <p>Access and download all important documents, guidelines, and resources.</p>
        </div>
<button type="button" class="documents-page__btn" onclick="document.getElementById('upload-modal').showModal()">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 15V3m0 0l-4 4m4-4l4 4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    Upload Document
</button>
    </div>

    @if (session('success'))
    <div class="documents-page__alert">{{ session('success') }}</div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.documents') }}" id="documents-filter-form" class="documents-filters">
        <div class="documents-filters__top">
            <div class="documents-filters__search">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M21 21l-4.3-4.3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                <input type="search" name="search" id="documents-search" placeholder="Search documents..." value="{{ $filters['search'] }}">
            </div>
            <a href="{{ route('admin.documents') }}" class="documents-filters__reset">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 12a9 9 0 1 1 3 6.7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M3 8v5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Reset Filters
            </a>
        </div>

        <div class="documents-filters__row">
            <label class="documents-filters__field">
                <span>Document Type</span>
                <select name="documentType" class="documents-filters__native-select" onchange="document.getElementById('documents-filter-form').submit()">
                    <option value="">All Types</option>
                    @foreach ($documentTypes as $type)
                        <option value="{{ $type }}" @selected($filters['documentType'] === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </label>
            <label class="documents-filters__field">
                <span>Programme / Category</span>
                <select name="categoryID" class="documents-filters__native-select" onchange="document.getElementById('documents-filter-form').submit()">
                    <option value="">All Programmes</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat['id'] }}" @selected((string) $filters['categoryID'] === (string) $cat['id'])>{{ $cat['name'] }}</option>
                    @endforeach
                </select>
            </label>
            <label class="documents-filters__field">
                <span>Language</span>
                <select name="languageCode" class="documents-filters__native-select" onchange="document.getElementById('documents-filter-form').submit()">
                    <option value="">All Languages</option>
                    @foreach ($languages as $lang)
                        <option value="{{ $lang->languageCode }}" @selected($filters['languageCode'] === $lang->languageCode)>{{ $lang->label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="documents-filters__field">
                <span>Year</span>
                <select name="year" class="documents-filters__native-select" onchange="document.getElementById('documents-filter-form').submit()">
                    <option value="">All Years</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" @selected((string) $filters['year'] === (string) $year)>{{ $year }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </form>

    {{-- Toolbar --}}
    <div class="documents-toolbar">
        <span class="documents-toolbar__count">{{ count($documents) }} Documents found</span>
    </div>

    {{-- Documents table (full width) --}}
    <div class="documents-table-wrap">
        <table class="documents-table">
            <thead>
                <tr>
                    <th>Document</th>
                    <th>Type</th>
                    <th>Programme / Category</th>
                    <th>Language</th>
                    <th>Date</th>
                    <th>Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $doc)
                <tr>
                    <td>
                        <div class="documents-table__doc">
                            <span class="documents-table__icon documents-table__icon--{{ $doc['ext'] }}">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 2h9l5 5v15H6V2Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M15 2v5h5" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>
                            </span>
                            <div>
                                <strong>{{ $doc['title'] }}</strong>
                                <span>{{ $doc['desc'] }}</span>
                            </div>
                        </div>
                    </td>
                    <td><span class="documents-table__tag documents-table__tag--type">{{ $doc['type'] }}</span></td>
                    <td><span class="documents-table__tag documents-table__tag--category">{{ $doc['category'] }}</span></td>
                    <td>{{ $doc['lang'] }}</td>
                    <td>{{ $doc['date'] }}</td>
                    <td>{{ $doc['size'] }}</td>
                    <td>
                        <div class="documents-table__actions">
                            @if($doc['file'])
                            <a href="{{ asset('storage/'.$doc['file']) }}" download aria-label="Download">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            @elseif($doc['externalLink'])
                            <a href="{{ $doc['externalLink'] }}" target="_blank" aria-label="Download">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                            @endif

                            <form method="POST" action="{{ route('admin.documents.destroy', $doc['id']) }}" class="documents-table__delete-form" onsubmit="return confirm('Delete \'{{ $doc['title'] }}\'? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="documents-table__delete-btn" aria-label="Delete {{ $doc['title'] }}">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 7h16M9 7V4h6v3M6 7l1 13a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-13" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:40px 0; color:var(--color-neutral-500); font-family:var(--font-body);">
                        No documents match your filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if(count($documents) > 0)
        <nav class="documents-pagination" aria-label="Documents pagination">
            <button type="button" aria-label="Previous page">‹</button>
            <button type="button" class="is-active">1</button>
            <button type="button" aria-label="Next page">›</button>
        </nav>
        @endif
    </div>
<dialog id="upload-modal" class="upload-modal">
   <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data" class="upload-modal__form" novalidate>
        @csrf
        <div class="upload-modal__head">
            <h2>Upload Document</h2>
            <button type="button" onclick="document.getElementById('upload-modal').close()" aria-label="Close">&times;</button>
        </div>

        @if ($errors->any())
        <div class="upload-modal__error">{{ $errors->first() }}</div>
        @endif

        <label>Title
            <input type="text" name="title" required>
        </label>

        <label>Document Type
            <input type="text" name="documentType" placeholder="e.g. Guide, Template, Policy">
        </label>

        <label>Description
            <textarea name="description" rows="3"></textarea>
        </label>

        <div class="upload-modal__row">
            <label>Version
                <input type="text" name="version" value="1.0" required>
            </label>
            <label>Publication Date
                <input type="date" name="publicationDate" required>
            </label>
        </div>

        <div class="upload-modal__row">
            <label>Category
                <select name="categoryID" id="upload-category" required>
                    <option value="">Loading...</option>
                </select>
            </label>
            <label>Language
                <select name="languageCode" id="upload-language" required>
                    <option value="">Loading...</option>
                </select>
            </label>
        </div>

        <label>Visibility
            <select name="visibilityLevel" required>
                <option value="public">Public</option>
                <option value="restricted">Restricted</option>
            </select>
        </label>

        <label>File
            <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
        </label>

        <div class="upload-modal__actions">
            <button type="button" onclick="document.getElementById('upload-modal').close()">Cancel</button>
            <button type="submit" class="upload-modal__submit">Upload</button>
        </div>
    </form>
</dialog>

<style>
.documents-filters__native-select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d8dde3;
    border-radius: 8px;
    background-color: #fff;
    font-family: inherit;
    font-size: 0.9rem;
    color: #1f2937;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none'%3E%3Cpath d='M6 9l6 6 6-6' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
    cursor: pointer;
    transition: border-color 0.15s ease;
}
.documents-filters__native-select:hover {
    border-color: #b6bec7;
}
.documents-filters__native-select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Delete button — matches the existing icon-button sizing used for
   Download/Approve/Reject elsewhere in the admin (32-36px square,
   rounded, neutral by default, red on hover/focus). */
.documents-table__delete-form {
    display: inline-block;
}
.documents-table__delete-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    padding: 0;
    border: 1px solid #d8dde3;
    border-radius: 8px;
    background-color: #fff;
    color: #4b5563;
    cursor: pointer;
    transition: background-color 0.15s ease, border-color 0.15s ease, color 0.15s ease;
}
.documents-table__delete-btn svg {
    width: 16px;
    height: 16px;
}
.documents-table__delete-btn:hover,
.documents-table__delete-btn:focus-visible {
    background-color: #FEF2F2;
    border-color: #FCA5A5;
    color: #DC2626;
    outline: none;
}
.documents-table__delete-btn:active {
    background-color: #FEE2E2;
    border-color: #EF4444;
}

.documents-page__alert {
    margin-bottom: 16px;
    padding: 12px 16px;
    border-radius: 8px;
    background-color: #E6F4EA;
    color: #1E7E34;
    font-family: var(--font-body);
    font-size: 14px;
}
</style>

<script>
document.getElementById('upload-modal').addEventListener('show', function() {}, false);
fetch('{{ route("admin.documents.create-options") }}')
    .then(r => r.json())
    .then(data => {
        const catSelect = document.getElementById('upload-category');
        const langSelect = document.getElementById('upload-language');
        catSelect.innerHTML = data.categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        langSelect.innerHTML = data.languages.map(l => `<option value="${l.languageCode}">${l.label}</option>`).join('');
    });
@if ($errors->any())
document.getElementById('upload-modal').showModal();
@endif

// Debounced live search: submits the filter form 500ms after typing stops
(function () {
    const searchInput = document.getElementById('documents-search');
    const filterForm = document.getElementById('documents-filter-form');
    let debounceTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            filterForm.submit();
        }, 500);
    });
})();
</script>
</div>
@endsection