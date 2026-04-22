@extends('layouts.backend')
@section('title', 'Sports List')
@section('admin')

    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .page-header h2 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }
        .page-header p {
            font-size: 13px;
            color: #888;
            margin: 3px 0 0;
        }
        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: #534AB7;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
        }
        .add-btn:hover { background: #3C3489; color: #fff; }

        .search-bar {
            margin-bottom: 1.25rem;
        }
        .search-bar input {
            width: 280px;
            padding: 8px 12px;
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.15s;
        }
        .search-bar input:focus { border-color: #7F77DD; }

        .tbl-wrap {
            border: 0.5px solid #e5e4e0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        .tbl-wrap table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .tbl-wrap thead tr {
            background: #f8f7f4;
        }
        .tbl-wrap thead th {
            padding: 11px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .tbl-wrap tbody tr {
            border-bottom: 0.5px solid #f0efeb;
            transition: background 0.1s;
        }
        .tbl-wrap tbody tr:last-child { border-bottom: none; }
        .tbl-wrap tbody tr:hover { background: #faf9f7; }
        .tbl-wrap tbody td {
            padding: 11px 14px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        .sport-img {
            width: 120px;
            border-radius: 8px;
            object-fit: cover;
            border: 0.5px solid #e5e4e0;
        }
        .id-cell { color: #aaa; font-size: 12px; }
        .sport-name { font-weight: 500; }
        .date-cell { color: #999; font-size: 12px; }

        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }
        .status-1 { background: #EAF3DE; color: #27500A; }
        .status-0 { background: #F1EFE8; color: #5F5E5A; }

        .olympic-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            background: #EEEDFE;
            color: #3C3489;
        }

        .actions { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .act-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            border: 0.5px solid;
            text-decoration: none;
            transition: opacity 0.15s;
        }
        .act-btn:hover { opacity: 0.8; }
        .act-show  { background: #E1F5EE; border-color: #5DCAA5; color: #085041; }
        .act-edit  { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }
        .act-del   { background: #FCEBEB; border-color: #F09595; color: #791F1F; border: none; }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #aaa;
            font-size: 14px;
        }
    </style>

    <div class="container" style="max-width: 1100px; padding-top: 1.5rem;">

        <div class="page-header">
            <div>
                <h2>Sports list</h2>
                <p>Barcha sport turlari ro'yxati</p>
            </div>
            <a href="{{ route('admin.sports.create') }}" class="add-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Sport qo'shish
            </a>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Sport nomi bo'yicha qidirish..." onkeyup="filterTable()">
        </div>

        @if(session('success'))
            <div style="padding: 10px 16px; background: #EAF3DE; border: 0.5px solid #97C459; border-radius: 8px; color: #27500A; font-size: 13px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        <div class="tbl-wrap">
            <table id="sportsTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Rasm</th>
                    <th>Olimpik</th>
                    <th>Status</th>
                    <th>Yaratilgan</th>
                    <th>Amal</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($sports as $sport)
                    <tr>
                        <td class="id-cell">#{{ $sport->id }}</td>
                        <td><span class="sport-name">{{ $sport->name_uz }}</span></td>
                        <td>
                            <img src="{{ asset('images/sports/' . $sport->image) }}"
                                 alt="{{ $sport->name_uz }}"
                                 class="sport-img"
                                 onerror="this.style.display='none'">
                        </td>
                        <td>
                            @if($sport->icon)
                                <span class="olympic-badge">{{ $sport->icon }}</span>
                            @else
                                <span style="color:#ccc; font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $sport->status ? 'status-1' : 'status-0' }}">
                                {{ $sport->status ? 'Aktiv' : 'Nofaol' }}
                            </span>
                        </td>
                        <td class="date-cell">{{ $sport->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.sports.show', $sport->id) }}" class="act-btn act-show">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Ko'rish
                                </a>
                                <a href="{{ route('admin.sports.edit', $sport->id) }}" class="act-btn act-edit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                    </svg>
                                    Tahrir
                                </a>
                                <form action="{{ route('admin.sports.destroy', $sport->id) }}" method="POST"
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
                        <td colspan="7" class="empty-state">Hech qanday sport topilmadi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($sports, 'links'))
            <div style="margin-top: 1.25rem;">
                {{ $sports->links() }}
            </div>
        @endif

    </div>

    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            document.querySelectorAll('#sportsTable tbody tr').forEach(row => {
                const name = row.querySelector('.sport-name');
                row.style.display = (name && name.textContent.toLowerCase().includes(q)) ? '' : 'none';
            });
        }
    </script>

@endsection
