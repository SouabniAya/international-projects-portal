/**
 * Admin interactivity — client-side behavior for tables, filters, modals,
 * and row actions across the admin pages. This is intentionally framework-
 * free so it works the same whether the data ends up server-rendered or
 * fetched via API once the backend exists.
 *
 * INTEGRATION NOTE for backend work:
 * - Every destructive action (delete/archive) currently only removes the
 *   row from the DOM after a confirm dialog. Each button already carries
 *   the real target via data-action + data-row-id — wire those into a
 *   fetch() call to the corresponding route (see routes-additions.php)
 *   and remove the row on a successful response instead of immediately.
 * - Filters run entirely client-side against the rows currently in the
 *   DOM. Once pagination/search hits the backend, swap initTableFilter's
 *   matching logic for a debounced fetch() that reloads the table body.
 */

function initModals() {
  document.querySelectorAll('[data-modal-open]').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const id = trigger.getAttribute('data-modal-open');
      const dialog = document.getElementById(id);
      if (dialog && typeof dialog.showModal === 'function') dialog.showModal();
    });
  });
  document.querySelectorAll('[data-modal-close]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const dialog = btn.closest('dialog');
      if (dialog) dialog.close();
    });
  });
}

function initDropdowns() {
  document.querySelectorAll('[data-dropdown-toggle]').forEach((trigger) => {
    const menuId = trigger.getAttribute('data-dropdown-toggle');
    const menu = document.getElementById(menuId);
    if (!menu) return;

    trigger.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = menu.classList.contains('is-open');
      document.querySelectorAll('.dropdown-menu.is-open').forEach((m) => m.classList.remove('is-open'));
      if (!isOpen) {
        menu.classList.add('is-open');
        trigger.setAttribute('aria-expanded', 'true');
      } else {
        trigger.setAttribute('aria-expanded', 'false');
      }
    });

    // Prevent clicks inside the menu from closing it via the document listener below
    menu.addEventListener('click', (e) => e.stopPropagation());
  });

  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu.is-open').forEach((m) => m.classList.remove('is-open'));
    document.querySelectorAll('[data-dropdown-toggle][aria-expanded="true"]').forEach((t) => t.setAttribute('aria-expanded', 'false'));
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('.dropdown-menu.is-open').forEach((m) => m.classList.remove('is-open'));
    }
  });
}

function initTableFilters() {
  document.querySelectorAll('[data-filter-scope]').forEach((scope) => {
    const container = document.querySelector(scope.getAttribute('data-filter-scope'));
    if (!container) return;
    const isTable = !!container.querySelector('table');
    const items = () =>
      isTable
        ? container.querySelectorAll('tbody tr')
        : container.querySelectorAll('[data-filter-item]');

    const searchInput = scope.querySelector('[data-filter-search]');
    const selects = scope.querySelectorAll('[data-filter-select]');

    function applyFilters() {
      const term = (searchInput?.value || '').trim().toLowerCase();
      const selectValues = Array.from(selects).map((s) => ({
        column: s.getAttribute('data-filter-select'),
        value: s.value,
      }));

      let visibleCount = 0;
      items().forEach((item) => {
        const text = item.textContent.toLowerCase();
        let matches = !term || text.includes(term);

        selectValues.forEach(({ column, value }) => {
          if (!value || value === 'all') return;
          const itemValue = item.getAttribute('data-' + column);
          if (itemValue && itemValue !== value) matches = false;
        });

        item.style.display = matches ? '' : 'none';
        if (matches) visibleCount++;
      });

      const emptyState = container.parentElement.querySelector('[data-empty-state]');
      if (emptyState) emptyState.style.display = visibleCount === 0 ? '' : 'none';
    }

    searchInput?.addEventListener('input', applyFilters);
    selects.forEach((s) => s.addEventListener('change', applyFilters));
  });
}

function initRowActions() {
  document.body.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;
    const action = btn.getAttribute('data-action');
    const row = btn.closest('tr');
    const title = row?.querySelector('[data-row-title]')?.textContent?.trim() || 'this item';

    if (action === 'delete') {
      askConfirm({
        title: 'Delete content',
        body: `Delete "${title}"? This cannot be undone once the backend is connected.`,
        acceptLabel: 'Delete',
        danger: true,
      }, () => {
        row?.remove();
        showToast(`"${title}" deleted (demo only — connect the DELETE route to persist).`);
      });
    }

    if (action === 'archive') {
      askConfirm({
        title: 'Archive content',
        body: `Archive "${title}"? It will be hidden from the public site but kept in the system.`,
        acceptLabel: 'Archive',
      }, () => {
        const badge = row?.querySelector('.badge');
        if (badge) {
          badge.textContent = 'Archived';
          badge.className = 'badge badge--rejected';
        }
        showToast(`"${title}" archived (demo only — connect the PATCH route to persist).`);
      });
    }

    if (action === 'preview') {
      const dialog = document.getElementById('previewModal');
      if (dialog) {
        dialog.querySelector('[data-preview-title]').textContent = title;
        dialog.querySelector('[data-preview-body]').textContent =
          'This is a client-side preview placeholder. Once the backend exists, load the real content here via fetch() using the row id.';
        dialog.showModal();
      }
    }

    if (action === 'edit') {
      showToast(`Edit "${title}" — wire this button to the edit route/form once available.`);
    }
  });
}

function initExportCSV() {
  document.querySelectorAll('[data-export-csv]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const tableWrap = document.querySelector(btn.getAttribute('data-export-csv'));
      if (!tableWrap) return;
      const table = tableWrap.querySelector('table');
      const rows = Array.from(table.querySelectorAll('tr')).filter((r) => r.style.display !== 'none');

      const csv = rows
        .map((row) =>
          Array.from(row.querySelectorAll('th, td'))
            .filter((cell) => !cell.classList.contains('data-table__actions'))
            .map((cell) => `"${cell.textContent.trim().replace(/"/g, '""')}"`)
            .join(',')
        )
        .join('\n');

      const blob = new Blob([csv], { type: 'text/csv' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = (btn.getAttribute('data-export-filename') || 'export') + '.csv';
      a.click();
      URL.revokeObjectURL(url);
    });
  });
}

function showToast(message) {
  let toast = document.getElementById('admin-toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'admin-toast';
    toast.style.cssText =
      'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#00171F;color:#fff;padding:12px 20px;border-radius:8px;font-family:var(--font-body,sans-serif);font-size:13.5px;z-index:9999;opacity:0;transition:opacity .2s ease;';
    document.body.appendChild(toast);
  }
  toast.textContent = message;
  toast.style.opacity = '1';
  clearTimeout(toast._timeout);
  toast._timeout = setTimeout(() => { toast.style.opacity = '0'; }, 3200);
}

function initConfirmModal() {
  window.__pendingConfirmAction = null;
  const dialog = document.getElementById('confirmModal');
  if (!dialog) return;

  document.getElementById('confirmModalAccept')?.addEventListener('click', () => {
    if (typeof window.__pendingConfirmAction === 'function') {
      window.__pendingConfirmAction();
    }
    dialog.close();
  });
}

function askConfirm({ title, body, acceptLabel = 'Confirm', danger = false }, onAccept) {
  const dialog = document.getElementById('confirmModal');
  if (!dialog) {
    // Fallback if the confirm modal isn't present on this page
    if (window.confirm(body)) onAccept();
    return;
  }
  dialog.querySelector('[data-confirm-title]').textContent = title;
  dialog.querySelector('[data-confirm-body]').textContent = body;
  const acceptBtn = document.getElementById('confirmModalAccept');
  acceptBtn.textContent = acceptLabel;
  acceptBtn.className = 'btn btn--sm ' + (danger ? 'btn--danger' : 'btn--primary');
  window.__pendingConfirmAction = onAccept;
  dialog.showModal();
}
function initSortableTables() {
  document.querySelectorAll('[data-sortable]').forEach((table) => {
    const tbody = table.querySelector('tbody');
    table.querySelectorAll('th[data-sort-key]').forEach((th) => {
      th.addEventListener('click', () => {
        const key = th.getAttribute('data-sort-key');
        const currentDir = th.getAttribute('data-sort-dir') || 'none';
        const nextDir = currentDir === 'asc' ? 'desc' : 'asc';

        table.querySelectorAll('th[data-sort-key]').forEach((h) => {
          h.removeAttribute('data-sort-dir');
          h.querySelector('.sort-arrow')?.remove();
        });
        th.setAttribute('data-sort-dir', nextDir);
        const arrow = document.createElement('span');
        arrow.className = 'sort-arrow';
        arrow.textContent = nextDir === 'asc' ? ' ▲' : ' ▼';
        th.appendChild(arrow);

        const rows = Array.from(tbody.querySelectorAll('tr'));
        rows.sort((a, b) => {
          const aVal = (a.querySelector(`[data-cell="${key}"]`)?.textContent || '').trim().toLowerCase();
          const bVal = (b.querySelector(`[data-cell="${key}"]`)?.textContent || '').trim().toLowerCase();
          return nextDir === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
        });
        rows.forEach((row) => tbody.appendChild(row));
      });
    });
  });
}

function initDynamicContentFields() {
  document.querySelectorAll('[data-content-type-select]').forEach((select) => {
    const form = select.closest('form');
    if (!form) return;
    const groups = form.querySelectorAll('[data-fields-for]');

    function updateVisibility() {
      const type = select.value;
      groups.forEach((g) => {
        const applies = g.getAttribute('data-fields-for').split(',').includes(type);
        g.style.display = applies ? '' : 'none';
        g.querySelectorAll('[required]').forEach((f) => { f.disabled = !applies; });
      });
    }
    select.addEventListener('change', updateVisibility);
    updateVisibility();
  });
}

function initFormFeedback() {
  document.querySelectorAll('[data-demo-submit]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      showToast(form.getAttribute('data-demo-submit') || 'Saved (demo only — no backend yet).');
    });
  });
  document.querySelectorAll('[data-toast]').forEach((btn) => {
    btn.addEventListener('click', () => showToast(btn.getAttribute('data-toast')));
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initModals();
  initDropdowns();
  initTableFilters();
  initRowActions();
  initExportCSV();
  initFormFeedback();
  initConfirmModal();
  initSortableTables();
  initDynamicContentFields();
});
