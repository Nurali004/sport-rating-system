@extends('layouts.backend')
@section('title', 'Competitions List')
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

        .search-wrap { display: flex; gap: 10px; margin-bottom: 1.25rem; }
        .search-box {
            flex: 1; display: flex; align-items: center; gap: 8px;
            padding: 8px 12px; border: 0.5px solid #d0cfc8;
            border-radius: 8px; background: #fff; transition: border-color 0.15s;
        }
        .search-box:focus-within { border-color: #7F77DD; }
        .search-box input {
            border: none; outline: none; background: transparent;
            font-size: 13px; width: 100%; color: #1a1a1a;
        }
        .btn-search {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 8px;
            border: 0.5px solid #d0cfc8; background: transparent;
            color: #555; font-size: 13px; font-weight: 500;
            cursor: pointer; transition: background 0.15s; white-space: nowrap;
        }
        .btn-search:hover { background: #f5f4f0; }

        .table-card {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            overflow-x: auto;
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

        .id-cell   { color: #aaa; font-size: 12px; }
        .date-cell { color: #999; font-size: 12px; }
        .title-main { font-weight: 500; font-size: 13px; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
        }
        .badge-sport   { background: #EEEDFE; color: #3C3489; }
        .badge-season  { background: #E1F5EE; color: #0F6E56; }
        .badge-level   { background: #FAEEDA; color: #633806; }
        .badge-loc     { background: #F1EFE8; color: #5F5E5A; }

        .organizer-cell {
            display: flex; align-items: center; gap: 7px;
        }
        .org-icon {
            width: 28px; height: 28px; border-radius: 6px;
            background: #E6F1FB; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
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
            padding: 10px 16px; border-top: 0.5px solid #e5e4e0;
            font-size: 12px; color: #aaa;
        }
        .empty-state { text-align: center; padding: 3rem; color: #aaa; font-size: 14px; }
    </style>

    <div class="container" style="max-width: 1300px;">
        <div class="page-wrap">

            <div class="top-bar">
                <div>
                    <p class="page-title">Musobaqalar ro'yxati</p>
                    <p class="page-sub">Barcha ro'yxatga olingan musobaqalar</p>
                </div>
                <a href="{{ route('admin.competitions.create') }}" class="btn-add">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Musobaqa qo'shish
                </a>
            </div>

            <div class="search-wrap">
                <form method="GET" action="{{ route('admin.competitions.index') }}"
                      style="flex:1; display:flex; gap:10px;">
                    <div class="search-box">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Nomi, sport turi yoki joy bo'yicha qidirish...">
                    </div>
                    <button type="submit" class="btn-search">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Qidirish
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.competitions.index') }}" class="btn-search"
                           style="color:#E24B4A; border-color:#F09595;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Tozalash
                        </a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div style="padding:10px 16px;background:#EAF3DE;border:0.5px solid #97C459;border-radius:8px;color:#27500A;font-size:13px;margin-bottom:1rem;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomi</th>
                        <th>Sport turi</th>
                        <th>Mavsum</th>
                        <th>Daraja</th>
                        <th>Tashkilotchi</th>
                        <th>Joylashuv</th>
                        <th>Yaratilgan</th>
                        <th>Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($competitions as $competition)
                        <tr>
                            <td class="id-cell">#{{ $competition->id }}</td>
                            <td>
                                <span class="title-main">{{ $competition->title_uz }}</span>
                            </td>
                            <td>
                                <span class="badge badge-sport">
                                    {{ $competition->sport->name_uz ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-season">
                                    {{ $competition->season->name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @if($competition->level)
                                    <span class="badge badge-level">{{ $competition->level }}</span>
                                @else
                                    <span style="color:#ccc;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($competition->organizer)
                                    <div class="organizer-cell">
                                        <div class="org-icon">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#185FA5" stroke-width="2">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                                <polyline points="9 22 9 12 15 12 15 22"/>
                                            </svg>
                                        </div>
                                        <span style="font-size:12px;">{{ $competition->organizer }}</span>
                                    </div>
                                @else
                                    <span style="color:#ccc;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($competition->location_uz)
                                    <span class="badge badge-loc">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:3px">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                            <circle cx="12" cy="10" r="3"/>
                                        </svg>
                                        {{ $competition->location_uz }}
                                    </span>
                                @else
                                    <span style="color:#ccc;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td class="date-cell">
                                {{ $competition->created_at->format('Y-m-d') }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.competitions.show', $competition->id) }}" class="act-btn act-show">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        Ko'rish
                                    </a>
                                    <a href="{{ route('admin.competitions.edit', $competition->id) }}" class="act-btn act-edit">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                                        </svg>
                                        Tahrir
                                    </a>
                                    <form action="{{ route('admin.competitions.destroy', $competition->id) }}" method="POST"
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
                            <td colspan="9" class="empty-state">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.5" style="display:block;margin:0 auto 10px">
                                    <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                </svg>
                                Hech qanday musobaqa topilmadi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="footer-bar">
                <span>
                    Jami: {{ $competitions->total() }} ta musobaqa
                    @if(request('search'))
                        — <span style="color:#534AB7">"{{ request('search') }}"</span> bo'yicha natijalar
                    @endif
                </span>
                    {{ $competitions->links() }}
                </div>
            </div>

        </div>
    </div>

@endsection
