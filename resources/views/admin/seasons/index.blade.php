@extends('layouts.backend')
@section('title', 'Seasons List')
@section('admin')

    <style>
        .page-wrap { padding: 1.5rem 0; }
        .top-bar {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 1.5rem;
        }
        .page-title { font-size: 20px; font-weight: 600; color: #1a1a1a; margin: 0; }
        .page-sub   { font-size: 13px; color: #888; margin: 3px 0 0; }
        .btn-add {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; border-radius: 8px; background: #534AB7;
            color: #fff; font-size: 13px; font-weight: 500;
            border: none; cursor: pointer; text-decoration: none; transition: background 0.15s;
        }
        .btn-add:hover { background: #3C3489; color: #fff; }

        .search-bar { margin-bottom: 1.25rem; }
        .search-bar input {
            width: 280px; padding: 8px 12px;
            border: 0.5px solid #d0cfc8; border-radius: 8px;
            font-size: 13px; outline: none; color: #1a1a1a; background: #fff;
            transition: border-color 0.15s;
        }
        .search-bar input:focus { border-color: #7F77DD; }

        .table-card {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: #f8f7f4; border-bottom: 0.5px solid #e5e4e0; }
        thead th {
            padding: 11px 14px; text-align: left;
            font-size: 11px; font-weight: 600; color: #aaa;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        tbody tr { border-bottom: 0.5px solid #f0efeb; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #faf9f7; }
        tbody td { padding: 11px 14px; color: #1a1a1a; vertical-align: middle; }

        .id-cell { color: #aaa; font-size: 12px; }

        .season-cell { display: flex; align-items: center; gap: 10px; }
        .season-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
        }
        .season-name { font-weight: 500; font-size: 13px; }

        .year-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
            background: #E1F5EE; color: #0F6E56; font-family: monospace;
        }
        .year-arrow { color: #5DCAA5; font-size: 11px; }

        .date-range {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: #888;
        }
        .date-sep { color: #ccc; }

        .badge-sport {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
            background: #EEEDFE; color: #3C3489;
        }

        .actions { display: flex; gap: 6px; align-items: center; }
        .act-btn {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 5px 12px; border-radius: 7px; font-size: 12px;
            font-weight: 500; cursor: pointer; text-decoration: none;
            transition: opacity 0.15s; border: 0.5px solid;
        }
        .act-btn:hover { opacity: 0.8; }
        .act-show { background: #E1F5EE; border-color: #5DCAA5; color: #085041; }
        .act-edit { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }
        .act-del  { background: #FCEBEB; border-color: #F09595; color: #791F1F; border: none; }

        .footer-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 10px 14px; border-top: 0.5px solid #e5e4e0;
            font-size: 12px; color: #aaa;
        }
        .empty-state { text-align: center; padding: 3rem; color: #aaa; font-size: 14px; }
    </style>

    <div class="container" style="max-width: 1050px;">
        <div class="page-wrap">

            <div class="top-bar">
                <div>
                    <p class="page-title">Mavsumlar ro'yxati</p>
                    <p class="page-sub">Barcha sport mavsumlari</p>
                </div>
                <a href="{{ route('admin.seasons.create') }}" class="btn-add">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Mavsum qo'shish
                </a>
            </div>

            <div class="search-bar">
                <input type="text" id="searchInput"
                       placeholder="Mavsum nomi yoki sport turi bo'yicha qidirish..."
                       onkeyup="filterTable()">
            </div>

            @if(session('success'))
                <div style="padding:10px 16px;background:#EAF3DE;border:0.5px solid #97C459;border-radius:8px;color:#27500A;font-size:13px;margin-bottom:1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-card">
                <table id="seasonsTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mavsum nomi</th>
                        <th>Yillar</th>
                        <th>Sana oralig'i</th>
                        <th>Sport turi</th>
                        <th>Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($seasons as $season)
                        <tr>
                            <td class="id-cell">#{{ $season->id }}</td>
                            <td>
                                <div class="season-cell">
                                    <div class="season-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.8">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                    </div>
                                    <span class="season-name">{{ $season->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="year-badge">
                                    {{ $season->year_start }}
                                    <span class="year-arrow">→</span>
                                    {{ $season->year_end }}
                                </span>
                            </td>
                            <td>
                                <div class="date-range">
                                    <span>{{ \Carbon\Carbon::parse($season->start_date)->format('d.m.Y') }}</span>
                                    <span class="date-sep">—</span>
                                    <span>{{ \Carbon\Carbon::parse($season->end_date)->format('d.m.Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-sport">
                                    {{ $season->sport->name_uz ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.seasons.show', $season->id) }}" class="act-btn act-show">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Ko'rish
                                    </a>
                                    <a href="{{ route('admin.seasons.edit', $season->id) }}" class="act-btn act-edit">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Tahrir
                                    </a>
                                    <form action="{{ route('admin.seasons.destroy', $season->id) }}" method="POST"
                                          style="display:inline"
                                          onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="act-btn act-del">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14H6L5 6"/>
                                                <path d="M10 11v6M14 11v6"/>
                                            </svg>
                                            O'chirish
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.5" style="display:block;margin:0 auto 10px">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                Hech qanday mavsum topilmadi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="footer-bar">
                    <span>Jami: {{ count($seasons) }} ta mavsum</span>
                    @if(method_exists($seasons, 'links'))
                        {{ $seasons->links() }}
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#seasonsTable tbody tr').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    </script>

@endsection
