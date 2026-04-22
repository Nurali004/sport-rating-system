@extends('layouts.backend')
@section('title', 'Ratings List')
@section('admin')

    <style>
        .page-wrap { padding: 1.5rem 0; }
        .top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .page-title { font-size: 18px; font-weight: 600; color: #1a1a1a; margin: 0; }
        .page-sub { font-size: 13px; color: #888; margin: 2px 0 0; }
        .btn-add { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; background: #534AB7; color: #fff; font-size: 13px; font-weight: 500; text-decoration: none; border: none; }
        .btn-add:hover { background: #3C3489; color: #fff; }

        .search-wrap { display: flex; gap: 10px; margin-bottom: 1rem; }
        .search-box { flex: 1; display: flex; align-items: center; gap: 8px; padding: 8px 12px; border: 0.5px solid #d0cfc8; border-radius: 8px; background: #fff; }
        .search-box input { border: none; outline: none; background: transparent; font-size: 13px; width: 100%; color: #1a1a1a; }

        .table-card { background: #fff; border: 0.5px solid #e5e4e0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { border-bottom: 0.5px solid #e5e4e0; background: #fafaf8; }
        thead th { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.06em; white-space: nowrap; }
        tbody tr { border-bottom: 0.5px solid #e5e4e0; transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fafaf8; }
        tbody td { padding: 10px 14px; color: #1a1a1a; vertical-align: middle; }

        /* Rank badge */
        .rank-cell { display: flex; align-items: center; gap: 8px; }
        .rank-num { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; flex-shrink: 0; }
        .rank-1 { background: #FAEEDA; color: #633806; }
        .rank-2 { background: #F1EFE8; color: #5F5E5A; }
        .rank-3 { background: #FAECE7; color: #4A1B0C; }
        .rank-other { background: #f5f4f0; color: #888; }

        /* Athlete cell */
        .athlete-cell { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 32px; height: 32px; border-radius: 50%; background: #EEEDFE; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; color: #534AB7; flex-shrink: 0; }
        .athlete-name { font-weight: 500; color: #1a1a1a; font-size: 13px; }
        .athlete-sub { font-size: 11px; color: #aaa; }

        /* Badges */
        .badge { display: inline-flex; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .badge-sport  { background: #EEEDFE; color: #3C3489; }
        .badge-season { background: #E1F5EE; color: #0F6E56; }

        /* Points */
        .points-cell { display: flex; align-items: center; gap: 8px; }
        .points-val { font-size: 14px; font-weight: 600; color: #1a1a1a; min-width: 40px; }
        .points-bar { flex: 1; height: 4px; border-radius: 2px; background: #f0efe8; overflow: hidden; min-width: 60px; }
        .points-fill { height: 100%; border-radius: 2px; background: linear-gradient(90deg, #534AB7, #7F77DD); }

        /* Medal count */
        .medal-cell { display: flex; align-items: center; gap: 5px; font-size: 13px; font-weight: 600; }
        .medal-dot { width: 8px; height: 8px; border-radius: 50%; background: #FAC775; }

        /* Actions */
        .actions { display: flex; gap: 6px; }
        .btn-show { padding: 5px 12px; border-radius: 6px; border: 0.5px solid #AFA9EC; background: #EEEDFE; color: #3C3489; font-size: 12px; font-weight: 500; text-decoration: none; }
        .btn-edit { padding: 5px 12px; border-radius: 6px; border: 0.5px solid #FAC775; background: #FAEEDA; color: #633806; font-size: 12px; font-weight: 500; text-decoration: none; }
        .btn-del  { padding: 5px 12px; border-radius: 6px; border: 0.5px solid #F0997B; background: #FAECE7; color: #4A1B0C; font-size: 12px; font-weight: 500; cursor: pointer; background: #FAECE7; border: 0.5px solid #F0997B; }

        .footer-bar { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-top: 0.5px solid #e5e4e0; font-size: 12px; color: #aaa; }
    </style>

    <div class="page-wrap">
        <div class="top-bar">
            <div>
                <p class="page-title">Reytinglar ro'yxati</p>
                <p class="page-sub">Jami {{ $ratings->total() }} ta yozuv</p>
            </div>
            <a href="{{ route('admin.ratings.create') }}" class="btn-add">
                + Reyting qo'shish
            </a>
        </div>

        <div class="search-wrap">
            <div class="search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" placeholder="Sportchi, sport turi yoki mavsum bo'yicha qidirish...">
            </div>
        </div>

        @php $maxPoints = $ratings->max('total_points') ?: 1; @endphp

        <div class="table-card">
            <table>
                <thead>
                <tr>
                    <th>O'rin</th>
                    <th>Sportchi</th>
                    <th>Sport</th>
                    <th>Mavsum</th>
                    <th>Jami ball</th>
                    <th>Oltin</th>
                    <th>Amallar</th>
                </tr>
                </thead>
                <tbody>
                @forelse($ratings as $rating)
                    @php
                        $rank = $rating->rank_position;
                        $rankClass = $rank == 1 ? 'rank-1' : ($rank == 2 ? 'rank-2' : ($rank == 3 ? 'rank-3' : 'rank-other'));
                        $initials = strtoupper(substr($rating->athlete->first_name,0,1) . substr($rating->athlete->last_name,0,1));
                        $pct = $maxPoints > 0 ? round($rating->total_points / $maxPoints * 100) : 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="rank-cell">
                                <div class="rank-num {{ $rankClass }}">
                                    @if($rank == 1) 🥇
                                    @elseif($rank == 2) 🥈
                                    @elseif($rank == 3) 🥉
                                    @else {{ $rank }}
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="athlete-cell">
                                <div class="avatar">{{ $initials }}</div>
                                <div>
                                    <div class="athlete-name">{{ $rating->athlete->first_name }} {{ $rating->athlete->last_name }}</div>
                                    <div class="athlete-sub">#{{ $rating->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-sport">{{ $rating->sport->name_uz }}</span></td>
                        <td><span class="badge badge-season">{{ $rating->season->name }}</span></td>
                        <td>
                            <div class="points-cell">
                                <div class="points-val">{{ number_format($rating->total_points) }}</div>
                                <div class="points-bar">
                                    <div class="points-fill" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="medal-cell">
                                <div class="medal-dot"></div>
                                {{ $rating->gold_count }}
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.ratings.show', $rating->id) }}" class="btn-show">Ko'rish</a>
                                <a href="{{ route('admin.ratings.edit', $rating->id) }}" class="btn-edit">Tahrirlash</a>
                                <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" style="display:inline" onsubmit="return confirm('O\'chirilsinmi?')">
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
                <span>{{ $ratings->firstItem() }}–{{ $ratings->lastItem() }} / {{ $ratings->total() }} ta</span>
                {{ $ratings->links() }}
            </div>
        </div>
    </div>

@endsection
