@extends('layouts.backend')
@section('title', 'Sportchilar ro\'yxati')
@section('admin')
    <style>
        .page-wrap {
            padding: 1.5rem 0;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .page-sub {
            font-size: 13px;
            color: #888;
            margin: 2px 0 0;
        }

        .btn-add {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            background: #534AB7;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-add:hover {
            background: #3C3489;
            color: #fff;
        }

        .search-wrap {
            display: flex;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .search-box {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            background: #fff;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            width: 100%;
        }

        .table-card {
            background: #fff;
            border: 0.5px solid #e5e4e0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        thead tr {
            border-bottom: 0.5px solid #e5e4e0;
        }

        thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        tbody tr {
            border-bottom: 0.5px solid #e5e4e0;
            transition: background 0.1s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #fafaf8;
        }

        tbody td {
            padding: 10px 14px;
            color: #1a1a1a;
            vertical-align: middle;
        }

        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #EEEDFE;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: #534AB7;
            flex-shrink: 0;
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .athlete-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .athlete-name {
            font-weight: 500;
        }

        .athlete-id {
            font-size: 11px;
            color: #aaa;
        }

        .badge {
            display: inline-flex;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-sport {
            background: #EEEDFE;
            color: #3C3489;
        }

        .badge-region {
            background: #E1F5EE;
            color: #0F6E56;
        }

        .badge-weight {
            background: #F1EFE8;
            color: #5F5E5A;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        .btn-view {
            padding: 5px 12px;
            border-radius: 6px;
            border: 0.5px solid #AFA9EC;
            background: #EEEDFE;
            color: #3C3489;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-edit {
            padding: 5px 12px;
            border-radius: 6px;
            border: 0.5px solid #FAC775;
            background: #FAEEDA;
            color: #633806;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-del {
            padding: 5px 12px;
            border-radius: 6px;
            border: 0.5px solid #F0997B;
            background: #FAECE7;
            color: #4A1B0C;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }

        .footer-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-top: 0.5px solid #e5e4e0;
            font-size: 12px;
            color: #aaa;
        }
    </style>

    <div class="page-wrap">
        <div class="top-bar">
            <div>
                <p class="page-title">Sportchilar ro'yxati</p>
            </div>
            <a href="{{ route('admin.athletes.create') }}" class="btn-add">
                + Sportchi qo'shish
            </a>
        </div>

        <div class="search-wrap">
            <form method="GET" action="{{ route('admin.athletes.index') }}" style="flex:1;display:flex;gap:10px">
                <div class="search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Ism, sport turi yoki viloyat bo'yicha qidirish...">
                </div>
                <button type="submit" class="btn-add" style="white-space:nowrap">Qidirish</button>
            </form>
        </div>

        <div class="table-card">
            <table>
                <thead>
                <tr>
                    <th>Sportchi</th>
                    <th>Rasm</th>
                    <th>Sport</th>
                    <th>Viloyat</th>
                    <th>Tug'ilgan sana</th>
                    <th>Vazn kategoriyasi</th>
                    <th>Amallar</th>
                </tr>
                </thead>
                <tbody>
                @forelse($athletes as $athlete)
                    <tr>
                        <td>
                            <div class="athlete-cell">
                                <div class="avatar">
                                    @if($athlete->photo)
                                        <img src="{{ asset('images/athletes/' . $athlete->photo) }}" alt="">
                                    @else
                                        {{ strtoupper(substr($athlete->first_name,0,1) . substr($athlete->last_name,0,1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="athlete-name">{{ $athlete->first_name }} {{ $athlete->last_name }}</div>
                                    <div class="athlete-id">#{{ $athlete->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($athlete->cover_photo)
                                @php
                                    $photos = json_decode($athlete->cover_photo, true)
                                @endphp
                                @foreach($photos as $photo)
                                    <img src="{{ asset('images/athletes/' . $photo) }}"
                                         style="width:50px;border-radius:8px;object-fit:cover" alt="">
                                @endforeach
                            @else
                                <span style="color:#aaa;font-size:12px">—</span>
                            @endif
                        </td>
                        <td><span class="badge badge-sport">{{ $athlete->sport->name_uz }}</span></td>
                        <td><span class="badge badge-region">{{ $athlete->region->name_uz }}</span></td>
                        <td style="color:#888">{{ $athlete->birth_date }}</td>
                        <td><span class="badge badge-weight">{{ $athlete->weight_category ?? '—' }}</span></td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.athletes.show', $athlete->id) }}" class="btn-view">Ko'rish</a>
                                <a href="{{ route('admin.athletes.edit', $athlete->id) }}"
                                   class="btn-edit">Tahrirlash</a>
                                <form action="{{ route('admin.athletes.destroy', $athlete->id) }}" method="POST"
                                      style="display:inline" onsubmit="return confirm('O\'chirilsinmi?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">O'chirish</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:3rem;color:#aaa">Hech narsa topilmadi</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="footer-bar">
                {{ $athletes->links() }}
            </div>
        </div>
    </div>

@endsection
