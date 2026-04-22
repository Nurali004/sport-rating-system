@extends('layouts.front')
@section('title', 'Ratings List')

@section('front')
    <style>
        .container {
            margin-top: 100px;
        }
        .card-custom {
            margin-top: 10px;
        }
        .rating-filter-tabs {
            display: flex;
            gap: 6px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
        }
        .rating-filter-tabs a {
            padding: 7px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: all .15s;
        }
        .rating-filter-tabs a.active,
        .rating-filter-tabs a:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Big ranking table */
        .rating-table { width:100%; border-collapse:collapse; }
        .rating-table thead th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
            background: #f8f9fc;
            white-space: nowrap;
        }
        .rating-table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f2f5;
            font-size: 13px;
            vertical-align: middle;
        }
        .rating-table tbody tr:hover td { background: #f4f8ff; }
        .rating-table tbody tr.top3 td { background: #fffcf0; }
        .rating-table tbody tr.top3:hover td { background: #fff8e1; }

        .rank-circle {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
        }
        .rank-circle.r1 { background:#fff3cd;color:#856404;border:2px solid #f39c12;box-shadow:0 0 0 3px rgba(243,156,18,.15); }
        .rank-circle.r2 { background:#f5f5f5;color:#555;border:2px solid #aaa; }
        .rank-circle.r3 { background:#fdebd0;color:#784212;border:2px solid #cd6133; }
        .rank-circle.rn { background:#f0f2f5;color:#6b7280;border:1px solid #ddd;font-size:12px; }

        .athlete-row-info { display:flex; align-items:center; gap:10px; }
        .athlete-row-avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: var(--primary-mid); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; flex-shrink: 0;
            border: 2px solid var(--border); overflow: hidden;
        }
        .athlete-row-avatar img { width:100%; height:100%; object-fit:cover; }
        .athlete-row-name { font-weight: 700; color: var(--text-main); font-size: 14px; }
        .athlete-row-sub  { font-size: 11px; color: var(--text-muted); }

        .score-pill {
            background: linear-gradient(90deg, #e8f1fb, #d0e8f5);
            color: var(--primary);
            font-weight: 800;
            font-size: 14px;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
        }
        .wins-pill { background:#d1fae5; color:#0d9e6e; font-weight:700; font-size:13px; padding:3px 10px; border-radius:20px; }
        .trend-badge {
            display:inline-flex; align-items:center; gap:2px;
            font-size:11px; font-weight:700; padding:2px 8px; border-radius:12px;
        }
        .trend-up2   { background:#d1fae5; color:#0d9e6e; }
        .trend-down2 { background:#fee2e2; color:#dc3545; }
        .trend-same2 { background:#f0f2f5; color:#6b7280; }

        /* Medal mini display */
        .medals-mini { display:flex; gap:4px; align-items:center; }
        .medals-mini span { font-size:13px; }
        .medals-mini .mcount { font-size:11px; font-weight:700; }

        /* Top 3 podium widget */
        .podium-wrap {
            background: linear-gradient(180deg, #e8f1fb 0%, #fff 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px 20px 16px;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .podium-col { text-align:center; }
        .podium-col .pod-avatar {
            width: 52px; height: 52px; border-radius: 50%;
            background: var(--primary-mid); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; font-weight: 700; margin: 0 auto 6px;
            border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.12);
        }
        .podium-col .pod-name { font-size: 12px; font-weight: 700; color: var(--text-main); }
        .podium-col .pod-score { font-size: 11px; color: var(--text-muted); }
        .podium-block {
            display: flex; align-items: center; justify-content: center;
            margin-top: 8px; color: #fff; font-family: 'Oswald', sans-serif;
            font-size: 20px; border-radius: 6px 6px 0 0;
        }
        .pod-1 .podium-block { height: 72px; background: linear-gradient(180deg,#f39c12,#c77c00); min-width: 80px; }
        .pod-2 .podium-block { height: 52px; background: linear-gradient(180deg,#aaa,#777); min-width: 70px; }
        .pod-3 .podium-block { height: 40px; background: linear-gradient(180deg,#cd6133,#8d3e15); min-width: 70px; }
    </style>
    <script>
        function filterRegion(val) {
            const url = new URL(window.location.href);
            if (val) url.searchParams.set('region', val);
            else url.searchParams.delete('region');
            window.location.href = url.toString();
        }
        function filterGender(val) {
            const url = new URL(window.location.href);
            if (val) url.searchParams.set('gender', val);
            else url.searchParams.delete('gender');
            window.location.href = url.toString();
        }
    </script>
    <div class="container py-4">

        {{-- Top 3 podium --}}

        {{-- Sport filter tabs --}}
        <div class="rating-filter-tabs">
            <a href="{{ route('frontend.ratings.list') }}" class="{{ !request('sport') ? 'active' : '' }}">
                <i class="bi bi-grid me-1"></i>Barcha sportlar
            </a>
            @foreach($sports as $sport)
                <a href="{{ route('frontend.ratings.list', ['sport' => $sport->slug]) }}"
                   class="{{ request('sport') == $sport->slug ? 'active' : '' }}">
                    {{ $sport->name_uz }}
                </a>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="card-custom mt-4">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom flex-wrap gap-2">
                <div style="font-family:'Oswald',sans-serif;font-size:16px;color:var(--primary)">
                    <i class="bi bi-list-ol me-2" style="color:var(--accent)"></i>
                    Reyting jadvali
                    @if(request('sport'))
                        — {{ $sports->where('slug', request('sport'))->first()?->name }}
                    @endif
                </div>
                <div class="d-flex align-items-center gap-2">
                    <select name="region" class="form-select form-select-sm" style="font-size:12px;width:auto" onchange="filterRegion(this.value)">
                        <option value="">Barcha viloyatlar</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected':'' }}>{{ $region->name_uz }}</option>
                        @endforeach
                    </select>
                    <select name="gender" class="form-select form-select-sm" style="font-size:12px;width:auto" onchange="filterGender(this.value)">
                        <option value="">Barcha</option>
                        <option value="male"   {{ request('gender')=='male'   ? 'selected':'' }}>Erkaklar</option>
                        <option value="female" {{ request('gender')=='female' ? 'selected':'' }}>Ayollar</option>
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="rating-table">
                    <thead>
                    <tr>
                        <th style="width:60px">O'rin</th>
                        <th>Sportchi</th>
                        <th>Sport turi</th>
                        <th>Viloyat</th>
                        <th>Reyting</th>
                        <th>G'alaba</th>
                        <th>Medallar</th>
                        <th>O'zgarish</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($ratings as $rating)
                        <tr class="{{ $rating->rank <= 3 ? 'top3' : '' }}">
                            <td>
                                @php $r = $rating->rank_position; @endphp
                                <span class="rank-circle {{ $r==1?'r1':($r==2?'r2':($r==3?'r3':'rn')) }}">{{ $r }}</span>
                            </td>
                            <td>
                                <div class="athlete-row-info">
                                    <div class="athlete-row-avatar">
                                        @if($rating->athlete->photo)
                                            <img src="{{ asset('images/athletes/'.$rating->athlete->photo) }}"  alt="">
                                        @else
                                            {{ strtoupper(substr($rating->athlete->first_name,0,1).substr($rating->athlete->last_name,0,1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="athlete-row-name">{{ $rating->athlete->last_name }} {{ $rating->athlete->first_name }}</div>
                                        <div class="athlete-row-sub">{{ \Carbon\Carbon::parse($rating->athlete->birth_date)->age }} yosh · {{ $rating->athlete->gender === 'male' ? 'Erkak' : 'Ayol' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-sport">{{ $rating->athlete->sport->name_uz }}</span></td>
                            <td style="color:var(--text-muted)">{{ $rating->athlete->region->name_uz }}</td>
                            <td><span class="score-pill">{{ number_format($rating->total_points,1) }}</span></td>
                            <td><span class="wins-pill">{{ $rating->competitions_count }}</span></td>
                            <td>
                                <div class="medals-mini">
                                    <span>🥇</span><span class="mcount">{{ $rating->gold_count }}</span>
                                    <span class="ms-1">🥈</span><span class="mcount">{{ $rating->silver_count }}</span>
                                    <span class="ms-1">🥉</span><span class="mcount">{{ $rating->bronze_count }}</span>
                                </div>
                            </td>
                            <td>
                                @php $chg = rand(-3,5); @endphp
                                @if($chg > 0)
                                    <span class="trend-badge trend-up2"><i class="bi bi-arrow-up-short"></i>+{{ $chg }}</span>
                                @elseif($chg < 0)
                                    <span class="trend-badge trend-down2"><i class="bi bi-arrow-down-short"></i>{{ $chg }}</span>
                                @else
                                    <span class="trend-badge trend-same2">—</span>
                                @endif
                            </td>
                            <td>
{{--                                <a href="{{ route('athletes.show', $rating->athlete->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size:11px">--}}
{{--                                    Profil <i class="bi bi-arrow-right ms-1"></i>--}}
{{--                                </a>--}}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-5 text-muted">Ma'lumot topilmadi</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
