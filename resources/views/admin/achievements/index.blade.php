@extends('layouts.backend')
@section('title', 'Achievements List')
@section('admin')

    <style>
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .page-header h2 { font-size: 20px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .page-header p  { font-size: 13px; color: #888; margin: 3px 0 0; }
        .add-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; background: #534AB7; color: #fff;
            border: none; border-radius: 8px; font-size: 13px; font-weight: 500;
            cursor: pointer; text-decoration: none; transition: background 0.15s;
        }
        .add-btn:hover { background: #3C3489; color: #fff; }

        .search-bar { margin-bottom: 1.25rem; }
        .search-bar input {
            width: 280px; padding: 8px 12px;
            border: 0.5px solid #d0cfc8; border-radius: 8px;
            font-size: 13px; outline: none; transition: border-color 0.15s;
        }
        .search-bar input:focus { border-color: #7F77DD; }

        .tbl-wrap {
            border: 0.5px solid #e5e4e0; border-radius: 10px;
            overflow: hidden; background: #fff;
        }
        .tbl-wrap table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .tbl-wrap thead tr { background: #f8f7f4; }
        .tbl-wrap thead th {
            padding: 11px 14px; text-align: left;
            font-size: 11px; font-weight: 600; color: #999;
            text-transform: uppercase; letter-spacing: 0.06em;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .tbl-wrap tbody tr { border-bottom: 0.5px solid #f0efeb; transition: background 0.1s; }
        .tbl-wrap tbody tr:last-child { border-bottom: none; }
        .tbl-wrap tbody tr:hover { background: #faf9f7; }
        .tbl-wrap tbody td { padding: 11px 14px; color: #1a1a1a; vertical-align: middle; }

        .id-cell   { color: #aaa; font-size: 12px; }
        .date-cell { color: #999; font-size: 12px; }

        .athlete-cell { display: flex; align-items: center; gap: 9px; }
        .avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; font-size: 11px; font-weight: 600;
            color: #3C3489; flex-shrink: 0;
        }
        .athlete-name { font-weight: 500; font-size: 13px; }

        .medal-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
        }
        .medal-gold   { background: #FAEEDA; color: #633806; border: 0.5px solid #FAC775; }
        .medal-silver { background: #F1EFE8; color: #2C2C2A; border: 0.5px solid #B4B2A9; }
        .medal-bronze { background: #FAECE7; color: #4A1B0C; border: 0.5px solid #F0997B; }

        .weight-badge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
            background: #E1F5EE; color: #085041;
        }

        .actions { display: flex; gap: 6px; align-items: center; }
        .act-btn {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 5px 12px; border-radius: 7px; font-size: 12px;
            font-weight: 500; cursor: pointer; border: 0.5px solid; text-decoration: none;
            transition: opacity 0.15s;
        }
        .act-btn:hover { opacity: 0.8; }
        .act-show { background: #E1F5EE; border-color: #5DCAA5; color: #085041; }
        .act-edit { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }
        .act-del  { background: #FCEBEB; border-color: #F09595; color: #791F1F; border: none; }

        .empty-state { text-align: center; padding: 3rem 1rem; color: #aaa; font-size: 14px; }
    </style>

    <div class="container" style="max-width: 1100px; padding-top: 1.5rem;">

        <div class="page-header">
            <div>
                <h2>Yutuqlar ro'yxati</h2>
                <p>Barcha sportchilar yutuqlari</p>
            </div>
            <a href="{{ route('admin.achievements.create') }}" class="add-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Yutuq qo'shish
            </a>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Sportchi yoki musobaqa bo'yicha qidirish..."
                   onkeyup="filterTable()">
        </div>

        @if(session('success'))
            <div style="padding:10px 16px;background:#EAF3DE;border:0.5px solid #97C459;border-radius:8px;color:#27500A;font-size:13px;margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="tbl-wrap">
            <table id="achievementsTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Sportchi</th>
                    <th>Musobaqa</th>
                    <th>Medal</th>
                    <th>Og'irlik</th>
                    <th>Yaratilgan</th>
                    <th>Amal</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($achievements as $achievement)
                    @php
                        $initials = strtoupper(
                            substr($achievement->athlete->first_name ?? 'A', 0, 1) .
                            substr($achievement->athlete->last_name  ?? 'A', 0, 1)
                        );
                    @endphp
                    <tr>
                        <td class="id-cell">#{{ $achievement->id }}</td>
                        <td>
                            <div class="athlete-cell">
                                <div class="avatar">{{ $initials }}</div>
                                <span class="athlete-name">
                                    {{ ($achievement->athlete->first_name ?? '') . ' ' . ($achievement->athlete->last_name ?? '') }}
                                </span>
                            </div>
                        </td>
                        <td>{{ $achievement->competition->title_uz ?? '—' }}</td>
                        <td>
                            @if($achievement->place == 1)
                                <span class="medal-badge medal-gold">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/></svg>
                                    Gold
                                </span>
                            @elseif($achievement->place == 2)
                                <span class="medal-badge medal-silver">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/></svg>
                                    Silver
                                </span>
                            @else
                                <span class="medal-badge medal-bronze">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/></svg>
                                    Bronze
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($achievement->weight_category)
                                <span class="weight-badge">{{ $achievement->weight_category }}</span>
                            @else
                                <span style="color:#ccc;font-size:12px;">—</span>
                            @endif
                        </td>
                        <td class="date-cell">{{ $achievement->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.achievements.show', $achievement->id) }}" class="act-btn act-show">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Ko'rish
                                </a>
                                <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="act-btn act-edit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                    </svg>
                                    Tahrir
                                </a>
                                <form action="{{ route('admin.achievements.destroy', $achievement->id) }}" method="POST"
                                      style="display:inline-block"
                                      onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                                    @csrf
                                    @method('DELETE')
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
                        <td colspan="7" class="empty-state">Hech qanday yutuq topilmadi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($achievements, 'links'))
            <div style="margin-top: 1.25rem;">
                {{ $achievements->links() }}
            </div>
        @endif

    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#achievementsTable tbody tr').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(q) ? '' : 'none';
            });
        }
    </script>

@endsection
