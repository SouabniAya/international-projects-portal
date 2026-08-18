<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logoEsi.png') }}">
    <title>@yield('title', 'Admin') — International Projects Web Portal</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="admin-layout">

        <x-admin-header />

        <div class="admin-layout__body">

            <x-admin-sidebar :active="$active ?? 'dashboard'" />

            <main class="admin-layout__content">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Shared Preview modal --}}
    <dialog id="previewModal" class="modal">
        <div class="modal__header">
            <h3 data-preview-title>Preview</h3>
            <button type="button" class="modal__close" data-modal-close aria-label="Close">&times;</button>
        </div>
        <div class="modal__body" data-preview-body></div>
        <div class="modal__footer">
            <button type="button" class="btn btn--outline btn--sm" data-modal-close>Close</button>
        </div>
    </dialog>

    {{-- Shared Confirm modal — replaces browser confirm() for delete/archive actions --}}
    <dialog id="confirmModal" class="modal">
        <div class="modal__header">
            <h3 data-confirm-title>Confirm</h3>
            <button type="button" class="modal__close" data-modal-close aria-label="Close">&times;</button>
        </div>
        <div class="modal__body" data-confirm-body></div>
        <div class="modal__footer">
            <button type="button" class="btn btn--outline btn--sm" data-modal-close>Cancel</button>
            <button type="button" class="btn btn--primary btn--sm" id="confirmModalAccept">Confirm</button>
        </div>
    </dialog>

    @yield('modals')

</body>
</html>