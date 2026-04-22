@extends('layouts.front')
@section('title', $athlete->last_name . ' ' . $athlete->first_name . ' — Profil')
@section('front')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rajdhani:wght@500;600;700&family=DM+Sans:wght@300;400;500&display=swap');

        :root {
            --blue-dark: #0a1628;
            --blue-mid:  #0f3460;
            --blue:      #1565a8;
            --accent:    #f59e0b;
            --green:     #10b981;
            --red:       #ef4444;
            --border:    #e8eaed;
            --text:      #1a1a2e;
            --muted:     #6b7280;
            --card-bg:   #ffffff;
            --page-bg:   #f4f6f9;
        }

        body { background: var(--page-bg); font-family: 'DM Sans', sans-serif; }

        /* COVER */
        .pf-cover {
            height: 470px;
            background: linear-gradient(135deg, #0a1628 0%, #0f3460 45%, #1565a8 100%);
            position: relative;
            overflow: hidden;
        }
        .cover-slider { position: absolute; inset: 0; }
        .cover-slide {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.6s ease;
        }
        .cover-slide.active { opacity: 1; }
        .cover-dots {
            position: absolute; bottom: 16px; left: 50%;
            transform: translateX(-50%);
            display: flex; gap: 6px; z-index: 10;
        }
        .cover-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: rgba(255,255,255,.4); border: none;
            cursor: pointer; transition: all .2s; padding: 0;
        }
        .cover-dot.active { background: #fff; width: 20px; border-radius: 4px; }
        .cover-arrow {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.25);
            color: #fff; font-size: 14px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; backdrop-filter: blur(6px);
            transition: background .2s; z-index: 10;
        }
        .cover-arrow:hover { background: rgba(255,255,255,.28); }
        .cover-prev { left: 14px; }
        .cover-next { right: 14px; }
        .pf-cover-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }
        .pf-cover-glow {
            position: absolute; width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(245,158,11,.18) 0%, transparent 65%);
            top: -150px; right: -100px; pointer-events: none;
        }
        .pf-cover-sport {
            position: absolute; bottom: -20px; right: 48px;
            font-family: 'Bebas Neue', cursive; font-size: 140px;
            color: rgba(255,255,255,.05); letter-spacing: -4px;
            line-height: 1; user-select: none; pointer-events: none;
        }
        .pf-cover-badge {
            position: absolute; top: 20px; right: 24px;
            background: rgba(255,255,255,.12); color: #fff;
            font-family: 'Rajdhani', sans-serif; font-weight: 600; font-size: 12px;
            padding: 5px 14px; border-radius: 20px;
            border: 1px solid rgba(255,255,255,.2);
            backdrop-filter: blur(8px); letter-spacing: .5px; z-index: 5;
        }
        .pf-cover-rank {
            position: absolute; top: 20px; left: 24px;
            display: flex; align-items: center; gap: 6px;
            background: rgba(245,158,11,.15);
            border: 1px solid rgba(245,158,11,.3); color: #f59e0b;
            font-family: 'Rajdhani', sans-serif; font-weight: 700; font-size: 13px;
            padding: 5px 14px; border-radius: 20px;
            backdrop-filter: blur(8px); z-index: 5;
        }

        /* HEAD CARD */
        .pf-head {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-top: none;
            border-radius: 0 0 16px 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,.06);
        }
        .pf-avatar-wrap {
            position: relative; margin-top: -56px;
            margin-left: 32px; display: inline-block;
        }
        .pf-avatar {
            width: 112px; height: 112px; border-radius: 50%;
            border: 4px solid #fff; background: var(--blue-mid); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Bebas Neue', cursive; font-size: 38px;
            box-shadow: 0 8px 24px rgba(0,0,0,.18); overflow: hidden;
        }
        .pf-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .pf-verified {
            position: absolute; bottom: 6px; right: 6px;
            width: 26px; height: 26px; background: var(--green);
            border-radius: 50%; border: 3px solid #fff;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 11px;
        }
        .pf-name {
            font-family: 'Rajdhani', sans-serif;
            font-size: 26px; font-weight: 700; color: var(--text); margin: 0; line-height: 1.1;
        }
        .pf-meta { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
        .pf-tag {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 12px; font-weight: 500;
            padding: 4px 10px; border-radius: 20px;
            border: 1px solid var(--border); color: var(--muted);
        }
        .pf-tag.sport  { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .pf-tag.male   { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
        .pf-tag.female { background: #fdf2f8; border-color: #f0abfc; color: #a21caf; }
        .pf-tag.nat    { background: #f0fdf4; border-color: #86efac; color: #15803d; }

        /* STATS STRIP */
        .pf-stats { display: flex; flex-wrap: wrap; border-top: 1px solid var(--border); }
        .pf-stat {
            flex: 1; min-width: 80px; padding: 18px 16px;
            text-align: center; border-right: 1px solid var(--border);
        }
        .pf-stat:last-child { border-right: none; }
        .pf-stat-val { font-family: 'Bebas Neue', cursive; font-size: 28px; line-height: 1; color: var(--blue); }
        .pf-stat-val.gold   { color: #b45309; }
        .pf-stat-val.silver { color: #6b7280; }
        .pf-stat-val.bronze { color: #92400e; }
        .pf-stat-val.green  { color: var(--green); }
        .pf-stat-lbl { font-size: 10px; font-weight: 500; color: var(--muted); margin-top: 3px; text-transform: uppercase; letter-spacing: .5px; }

        /* TABS */
        .pf-tabs { display: flex; overflow-x: auto; border-top: 1px solid var(--border); padding: 0 24px; }
        .ptab {
            padding: 15px 20px; font-family: 'Rajdhani', sans-serif;
            font-size: 13px; font-weight: 600; color: var(--muted);
            cursor: pointer; border-bottom: 2.5px solid transparent;
            white-space: nowrap; transition: all .15s; text-decoration: none;
            letter-spacing: .3px; text-transform: uppercase;
        }
        .ptab:hover { color: var(--blue); }
        .ptab.active { color: var(--blue); border-bottom-color: var(--blue); }
        .tab-pane-custom { display: none; }
        .tab-pane-custom.active { display: block; }

        /* CARDS */
        .pf-card {
            background: var(--card-bg); border: 1px solid var(--border);
            border-radius: 14px; box-shadow: 0 2px 8px rgba(0,0,0,.04); overflow: hidden;
        }
        .pf-card-hdr {
            display: flex; align-items: center; gap: 8px;
            padding: 14px 20px; border-bottom: 1px solid var(--border);
            font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text); text-transform: uppercase; letter-spacing: .5px;
        }
        .pf-card-hdr-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: #eff6ff; display: flex; align-items: center;
            justify-content: center; color: var(--blue); font-size: 14px;
        }

        /* INFO TABLE */
        .info-tbl { width: 100%; }
        .info-tbl tr td { padding: 11px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; vertical-align: middle; }
        .info-tbl tr:last-child td { border-bottom: none; }
        .info-tbl .ik { color: var(--muted); width: 44%; padding-right: 12px; }
        .info-tbl .iv { font-weight: 600; color: var(--text); }

        /* ACHIEVEMENT */
        .ach-item {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 14px 20px; border-bottom: 1px solid var(--border); transition: background .15s;
        }
        .ach-item:last-child { border-bottom: none; }
        .ach-item:hover { background: #fafbfd; }
        .ach-icon { width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .ach-icon.gold   { background: #fef3c7; }
        .ach-icon.silver { background: #f3f4f6; }
        .ach-icon.bronze { background: #fef0e7; }
        .ach-name { font-weight: 600; font-size: 14px; color: var(--text); }
        .ach-meta { font-size: 12px; color: var(--muted); margin-top: 3px; display: flex; flex-wrap: wrap; gap: 8px; }
        .ach-place { margin-left: auto; font-family: 'Bebas Neue', cursive; font-size: 26px; text-align: center; min-width: 40px; }
        .ach-place.p1 { color: #b45309; }
        .ach-place.p2 { color: #6b7280; }
        .ach-place.p3 { color: #92400e; }

        .lvl-badge { display: inline-flex; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
        .lvl-int  { background: #fef3c7; color: #92400e; }
        .lvl-nat  { background: #eff6ff; color: #1d4ed8; }
        .lvl-reg  { background: #f0fdf4; color: #15803d; }

        /* RIGHT SIDEBAR */
        .rank-card {
            background: linear-gradient(135deg, #0f3460 0%, #1565a8 100%);
            border-radius: 14px; padding: 24px; text-align: center;
            color: #fff; position: relative; overflow: hidden; margin-bottom: 16px;
        }
        .rank-card::before {
            content: ''; position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .rank-card-label { font-family: 'Rajdhani', sans-serif; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.6); margin-bottom: 8px; position: relative; }
        .rank-card-num { font-family: 'Bebas Neue', cursive; font-size: 72px; line-height: 1; color: #fff; position: relative; }
        .rank-card-num span { color: var(--accent); }
        .rank-card-sub { font-size: 12px; color: rgba(255,255,255,.6); margin-top: 4px; position: relative; }
        .rank-change { display: inline-flex; align-items: center; gap: 5px; font-family: 'Rajdhani', sans-serif; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-top: 12px; position: relative; }
        .rank-change.up   { background: rgba(16,185,129,.2); color: #6ee7b7; }
        .rank-change.down { background: rgba(239,68,68,.2); color: #fca5a5; }
        .rank-change.same { background: rgba(255,255,255,.1); color: rgba(255,255,255,.6); }

        .score-row { display: flex; align-items: center; justify-content: space-between; padding: 11px 0; border-bottom: 1px solid var(--border); font-size: 13px; }
        .score-row:last-child { border-bottom: none; }
        .score-row-lbl { color: var(--muted); }
        .score-row-val { font-weight: 700; color: var(--text); }
        .score-row-val.blue  { color: var(--blue); font-size: 16px; }
        .score-row-val.green { color: var(--green); }
        .score-row-val.red   { color: var(--red); }

        .medal-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        .medal-box { border-radius: 12px; padding: 14px 8px; text-align: center; }
        .medal-box.gold   { background: #fef3c7; }
        .medal-box.silver { background: #f3f4f6; }
        .medal-box.bronze { background: #fef0e7; }
        .medal-box-ico { font-size: 26px; }
        .medal-box-num { font-family: 'Bebas Neue', cursive; font-size: 26px; line-height: 1; margin: 4px 0 2px; }
        .medal-box.gold   .medal-box-num { color: #b45309; }
        .medal-box.silver .medal-box-num { color: #6b7280; }
        .medal-box.bronze .medal-box-num { color: #92400e; }
        .medal-box-lbl { font-size: 10px; color: var(--muted); font-weight: 500; text-transform: uppercase; letter-spacing: .4px; }

        .share-btn { flex: 1; padding: 9px 12px; border-radius: 8px; border: none; cursor: pointer; font-family: 'Rajdhani', sans-serif; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity .15s; }
        .share-btn:hover { opacity: .85; }
        .share-tg { background: #0088cc; color: #fff; }
        .share-fb { background: #1877f2; color: #fff; }
        .share-cp { background: var(--border); color: var(--text); }

        .hist-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .hist-table thead th { padding: 10px 16px; text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--muted); background: #f9fafb; border-bottom: 1px solid var(--border); }
        .hist-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
        .hist-table tbody tr:last-child { border-bottom: none; }
        .hist-table tbody tr:hover { background: #fafbfd; }
        .hist-table tbody td { padding: 11px 16px; vertical-align: middle; }

        .win-bar { height: 6px; border-radius: 3px; background: #e5e7eb; overflow: hidden; margin-top: 5px; width: 80px; }
        .win-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, var(--blue), #60a5fa); }
        .chart-wrap { position: relative; height: 260px; padding: 20px; }

        @media(max-width:768px) {
            .pf-cover { height: 160px; }
            .pf-avatar { width: 88px; height: 88px; font-size: 28px; }
            .pf-avatar-wrap { margin-left: 16px; margin-top: -44px; }
            .pf-stat { padding: 12px 8px; }
            .pf-stat-val { font-size: 22px; }
            .pf-name { font-size: 20px; }
        }
    </style>

    {{-- Breadcrumb --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
        <nav>
            <ol class="breadcrumb mb-0" style="font-size:13px">
                <li class="breadcrumb-item"><a href="/">Bosh sahifa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.athletes.list') }}">Sportchilar</a></li>
                <li class="breadcrumb-item active">{{ $athlete->last_name }} {{ $athlete->first_name }}</li>
            </ol>
        </nav>
    </div>

    <div class="row g-4">

        {{-- ===== LEFT ===== --}}
        <div class="col-lg-8">

            {{-- Cover + Head --}}
            <div class="mb-4" style="border-radius:16px;overflow:visible">

                {{-- COVER --}}
                <div class="pf-cover" style="border-radius:16px 16px 0 0">

                    <div class="cover-slider" id="coverSlider">
                        @if(!empty($photos) && count($photos) > 0)
                            @foreach($photos as $i => $photo)
                                <div class="cover-slide {{ $i === 0 ? 'active' : '' }}"
                                     style="background-image:url('{{ asset('images/athletes/' . $photo) }}')"></div>
                            @endforeach
                        @else
                            <div class="cover-slide active"
                                 style="background:linear-gradient(135deg,#0a1628 0%,#0f3460 45%,#1565a8 100%)"></div>
                        @endif
                    </div>

                    {{-- Overlay --}}
                    <div style="position:absolute;inset:0;background:linear-gradient(to bottom,rgba(0,0,0,.2) 0%,rgba(0,0,0,.5) 100%);z-index:2"></div>

                    <div class="pf-cover-grid" style="z-index:3"></div>
                    <div class="pf-cover-glow" style="z-index:3"></div>
                    <div class="pf-cover-sport" style="z-index:3">{{ strtoupper(substr($athlete->last_name,0,3)) }}</div>

                    <div class="pf-cover-rank" style="z-index:4">
                        <i class="bi bi-trophy-fill"></i>
                        #{{ $athlete->rank_position }} O'zbek reytingi
                    </div>
                    <div class="pf-cover-badge" style="z-index:4">
                        <i class="bi bi-patch-check-fill me-1"></i>{{ $athlete->sport->name_uz }}
                    </div>

                    @if(!empty($photos) && count($photos) > 1)
                        <div class="cover-dots" style="z-index:5">
                            @foreach($photos as $i => $photo)
                                <button class="cover-dot {{ $i === 0 ? 'active' : '' }}"
                                        onclick="goToSlide({{ $i }})" type="button"></button>
                            @endforeach
                        </div>
                        <button class="cover-arrow cover-prev" onclick="changeSlide(-1)" type="button">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="cover-arrow cover-next" onclick="changeSlide(1)" type="button">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    @endif
                </div>

                {{-- HEAD --}}
                <div class="pf-head">
                    <div class="d-flex align-items-end justify-content-between px-4 pb-4 flex-wrap gap-3">
                        <div class="d-flex align-items-end gap-3">
                            <div class="pf-avatar-wrap">
                                <div class="pf-avatar">
                                    @if($athlete->photo)
                                        <img src="{{ asset('images/athletes/'.$athlete->photo) }}" alt="{{ $athlete->first_name }}">
                                    @else
                                        {{ strtoupper(substr($athlete->first_name,0,1).substr($athlete->last_name,0,1)) }}
                                    @endif
                                </div>
                                <div class="pf-verified"><i class="bi bi-check-lg"></i></div>
                            </div>
                            <div class="pb-1">
                                <h2 class="pf-name">{{ $athlete->last_name }} {{ $athlete->first_name }}</h2>
                                <div class="pf-meta">
                                    <span class="pf-tag sport"><i class="bi bi-trophy"></i> {{ $athlete->sport->name_uz }}</span>
                                    <span class="pf-tag"><i class="bi bi-geo-alt"></i> {{ $athlete->region->name_uz }}</span>
                                    <span class="pf-tag"><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($athlete->birth_date)->age }} yosh</span>
                                    @if($athlete->gender === 'male')
                                        <span class="pf-tag male"><i class="bi bi-gender-male"></i> Erkak</span>
                                    @else
                                        <span class="pf-tag female"><i class="bi bi-gender-female"></i> Ayol</span>
                                    @endif
                                    @if($athlete->is_national_team)
                                        <span class="pf-tag nat">🇺🇿 Milliy terma</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @can('update', $athlete)
                            <div class="pb-1">
                                <a href="{{ route('athletes.edit', $athlete->id) }}"
                                   style="display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:8px;border:1px solid var(--border);background:#fff;color:var(--blue);font-family:'Rajdhani',sans-serif;font-size:13px;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:.3px">
                                    <i class="bi bi-pencil"></i> Tahrirlash
                                </a>
                            </div>
                        @endcan
                    </div>

                    {{-- Stats strip --}}
                    <div class="pf-stats">
                        <div class="pf-stat">
                            <div class="pf-stat-val">#{{ $athlete->rank_position }}</div>
                            <div class="pf-stat-lbl">Reyting o'rni</div>
                        </div>
                        <div class="pf-stat">
                            <div class="pf-stat-val">{{ number_format($athlete->rating_score) }}</div>
                            <div class="pf-stat-lbl">Reyting bali</div>
                        </div>

                        @foreach($ratings as $rating)
                            <div class="pf-stat">
                                <div class="pf-stat-val">{{ $rating->competitions_count?? 0 }}</div>
                                <div class="pf-stat-lbl">Musobaqa</div>
                            </div>
                            <div class="pf-stat">
                                <div class="pf-stat-val green">{{ $rating->competitions_count ?? 0 }}</div>
                                <div class="pf-stat-lbl">G'alaba</div>
                            </div>
                            <div class="pf-stat">
                                <div class="pf-stat-val gold">{{ $athlete->gold_medals }}</div>
                                <div class="pf-stat-lbl">🥇 Oltin</div>
                            </div>
                        @endforeach

                        <div class="pf-stat">
                            <div class="pf-stat-val silver">{{ $athlete->silver_medals }}</div>
                            <div class="pf-stat-lbl">🥈 Kumush</div>
                        </div>
                        <div class="pf-stat">
                            <div class="pf-stat-val bronze">{{ $athlete->bronze_medals }}</div>
                            <div class="pf-stat-lbl">🥉 Bronza</div>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="pf-tabs">
                        <a class="ptab active" onclick="switchTab('info',this)" href="#">
                            <i class="bi bi-person-lines-fill me-1"></i>Ma'lumotlar
                        </a>
                        <a class="ptab" onclick="switchTab('achievements',this)" href="#">
                            <i class="bi bi-trophy me-1"></i>Yutuqlar
                        </a>
                        <a class="ptab" onclick="switchTab('history',this)" href="#">
                            <i class="bi bi-graph-up me-1"></i>Reyting tarixi
                        </a>
                        <a class="ptab" onclick="switchTab('competitions',this)" href="#">
                            <i class="bi bi-calendar-check me-1"></i>Musobaqalar
                        </a>
                    </div>
                </div>
            </div>

            {{-- TAB: MA'LUMOTLAR --}}
            <div id="tab-info" class="tab-pane-custom active">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="pf-card">
                            <div class="pf-card-hdr">
                                <div class="pf-card-hdr-icon"><i class="bi bi-person-vcard"></i></div>
                                Shaxsiy ma'lumotlar
                            </div>
                            <div class="p-4">
                                <table class="info-tbl">
                                    <tr><td class="ik">To'liq ism</td><td class="iv">{{ $athlete->last_name }} {{ $athlete->first_name }}</td></tr>
                                    <tr><td class="ik">Tug'ilgan sana</td><td class="iv">{{ \Carbon\Carbon::parse($athlete->birth_date)->format('d.m.Y') }}</td></tr>
                                    <tr><td class="ik">Yoshi</td><td class="iv">{{ \Carbon\Carbon::parse($athlete->birth_date)->age }} yosh</td></tr>
                                    <tr><td class="ik">Jinsi</td><td class="iv">{{ $athlete->gender === 'male' ? 'Erkak' : 'Ayol' }}</td></tr>
                                    <tr><td class="ik">Viloyat</td><td class="iv">{{ $athlete->region->name_uz }}</td></tr>
                                    <tr>
                                        <td class="ik">Sport turi</td>
                                        <td class="iv">
                                        <span style="background:#eff6ff;color:#1d4ed8;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600">
                                            {{ $athlete->sport->name_uz }}
                                        </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pf-card">
                            <div class="pf-card-hdr">
                                <div class="pf-card-hdr-icon"><i class="bi bi-award"></i></div>
                                Razryad va murabbiy
                            </div>
                            <div class="p-4">
                                <table class="info-tbl">
                                    <tr>
                                        <td class="ik">Razryad</td>
                                        <td class="iv">
                                        <span style="background:#eff6ff;color:var(--blue);font-size:12px;border-radius:6px;padding:4px 10px;font-weight:600">
                                            {{ $athlete->rank_title ?? 'Sport ustasi' }}
                                        </span>
                                        </td>
                                    </tr>
                                    <tr><td class="ik">Murabbiy</td><td class="iv">{{ $athlete->coach_name ?? '—' }}</td></tr>
                                    <tr><td class="ik">Klub / Jamoa</td><td class="iv">{{ $athlete->club_name ?? '—' }}</td></tr>
                                    <tr>
                                        <td class="ik">Milliy terma</td>
                                        <td class="iv">
                                            @if($athlete->is_national_team)
                                                <span style="background:#f0fdf4;color:#15803d;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600">✓ Ha</span>
                                            @else
                                                <span style="background:#f3f4f6;color:#6b7280;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600">Yo'q</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr><td class="ik">Tajriba</td><td class="iv">{{ $athlete->experience_years ? $athlete->experience_years.' yil' : '—' }}</td></tr>
                                    <tr><td class="ik">Vazn kategoriyasi</td><td class="iv">{{ $athlete->weight_category ?? '—' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($athlete->bio_uz)
                        <div class="col-12">
                            <div class="pf-card">
                                <div class="pf-card-hdr">
                                    <div class="pf-card-hdr-icon"><i class="bi bi-file-text"></i></div>
                                    Biografiya
                                </div>
                                <div class="p-4" style="font-size:14px;line-height:1.75;color:var(--text)">{!! $athlete->bio_uz !!}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TAB: YUTUQLAR --}}
            <div id="tab-achievements" class="tab-pane-custom">
                <div class="pf-card">
                    <div class="pf-card-hdr">
                        <div class="pf-card-hdr-icon"><i class="bi bi-trophy-fill"></i></div>
                        Barcha yutuqlar
                        <span style="margin-left:auto;font-family:'Bebas Neue';font-size:20px;color:var(--blue)">
                        {{ $athlete->gold_medals + $athlete->silver_medals + $athlete->bronze_medals }}
                    </span>
                    </div>
                    @forelse($achievements as $ach)
                        <div class="ach-item">
                            <div class="ach-icon {{ $ach->medal }}">
                                {{ $ach->medal === 'gold' ? '🥇' : ($ach->medal === 'silver' ? '🥈' : '🥉') }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="ach-name">{{ $ach->competition->title_uz }}</div>
                                <div class="ach-meta">
                                    <span><i class="bi bi-geo-alt me-1"></i>{{ $ach->competition->location_uz ?? 'O\'zbekiston' }}</span>
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ach->competition->start_date)->year }}</span>
                                    <span class="lvl-badge {{ $ach->competition->level === 'international' ? 'lvl-int' : ($ach->competition->level === 'national' ? 'lvl-nat' : 'lvl-reg') }}">
                                    {{ $ach->competition->level === 'international' ? 'Xalqaro' : ($ach->competition->level === 'national' ? 'Respublika' : 'Viloyat') }}
                                </span>
                                </div>
                            </div>
                            <div class="ach-place p{{ $ach->place }}">
                                {{ $ach->place }}<sup style="font-size:12px;font-family:'DM Sans'">-o'rin</sup>
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:3rem;color:var(--muted)">
                            <i class="bi bi-trophy fs-2 d-block mb-2"></i>
                            Yutuqlar hali kiritilmagan
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB: REYTING TARIXI --}}
            <div id="tab-history" class="tab-pane-custom">
                <div class="pf-card mb-3">
                    <div class="pf-card-hdr">
                        <div class="pf-card-hdr-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        Reyting dinamikasi
                    </div>
                    <div class="chart-wrap">
                        <canvas id="ratingChart"></canvas>
                    </div>
                </div>
                <div class="pf-card">
                    <div class="pf-card-hdr">
                        <div class="pf-card-hdr-icon"><i class="bi bi-table"></i></div>
                        Mavsum natijalari
                    </div>
                    <div class="table-responsive">
                        <table class="hist-table">
                            <thead>
                            <tr>
                                <th>Mavsum</th>
                                <th>O'rin</th>
                                <th>Ball</th>
                                <th>Musobaqa</th>
                                <th>G'alaba %</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ratings as $r)
                                <tr>
                                    <td style="font-weight:600">{{ $r->season->name }}</td>
                                    <td>
                                        <span style="font-family:'Bebas Neue';font-size:18px;color:{{ $r->rank_position == 1 ? '#b45309' : ($r->rank_position == 2 ? '#6b7280' : 'var(--blue)') }}">
                                            #{{ $r->rank_position }}
                                        </span>
                                    </td>
                                    <td style="font-weight:700;color:var(--blue)">{{ number_format($r->total_points) }}</td>
                                    <td>{{ $r->competitions_count }}</td>
                                    <td>
                                        @php $pct = $r->competitions_count > 0 ? round($r->gold_count / $r->competitions_count * 100) : 0; @endphp
                                        <div style="font-size:12px;font-weight:600;color:var(--green)">{{ $pct }}%</div>
                                        <div class="win-bar"><div class="win-bar-fill" style="width:{{ $pct }}%"></div></div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TAB: MUSOBAQALAR --}}
            <div id="tab-competitions" class="tab-pane-custom">
                <div class="pf-card">
                    <div class="pf-card-hdr">
                        <div class="pf-card-hdr-icon"><i class="bi bi-calendar-check"></i></div>
                        Ishtirok etgan musobaqalar
                    </div>
                    @forelse($achievements as $ach)
                        <div class="ach-item">
                            <div style="font-size:24px;flex-shrink:0">
                                {{ $ach->medal === 'gold' ? '🥇' : ($ach->medal === 'silver' ? '🥈' : '🥉') }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="ach-name">{{ $ach->competition->title_uz }}</div>
                                <div class="ach-meta">
                                    <span>{{ \Carbon\Carbon::parse($ach->competition->start_date)->format('d.m.Y') }}</span>
                                    <span>{{ $ach->competition->location_uz ?? '—' }}</span>
                                </div>
                            </div>
                            <span class="lvl-badge {{ $ach->competition->level === 'international' ? 'lvl-int' : ($ach->competition->level === 'national' ? 'lvl-nat' : 'lvl-reg') }}">
                            {{ $ach->competition->level === 'international' ? 'Xalqaro' : ($ach->competition->level === 'national' ? 'Respublika' : 'Viloyat') }}
                        </span>
                        </div>
                    @empty
                        <div style="text-align:center;padding:3rem;color:var(--muted)">Ma'lumot yo'q</div>
                    @endforelse
                </div>
            </div>

        </div>{{-- /col-lg-8 --}}

        {{-- ===== RIGHT SIDEBAR ===== --}}
        <div class="col-lg-4">

            <div class="rank-card">
                <div class="rank-card-label">Joriy reyting o'rni</div>
                <div class="rank-card-num"><span>#</span>{{ $athlete->rank_position }}</div>
                <div class="rank-card-sub">O'zbekiston milliy reytingi · {{ $currentSeason->name ?? '2025' }}</div>
                @if(isset($rankChange))
                    <div>
                    <span class="rank-change {{ $rankChange > 0 ? 'up' : ($rankChange < 0 ? 'down' : 'same') }}">
                        @if($rankChange > 0) <i class="bi bi-arrow-up"></i>+{{ $rankChange }} o'rin
                        @elseif($rankChange < 0) <i class="bi bi-arrow-down"></i>{{ $rankChange }} o'rin
                        @else <i class="bi bi-dash"></i>O'zgarmagan
                        @endif
                    </span>
                    </div>
                @endif
            </div>

            <div class="pf-card mb-3">
                <div class="pf-card-hdr">
                    <div class="pf-card-hdr-icon"><i class="bi bi-speedometer2"></i></div>
                    Joriy ko'rsatkichlar
                </div>
                <div class="p-4">
                    <div class="score-row"><span class="score-row-lbl">Reyting bali</span><span class="score-row-val blue">{{ number_format($athlete->rating_score) }}</span></div>
                    <div class="score-row"><span class="score-row-lbl">Musobaqalar</span><span class="score-row-val">{{ $currentRating?->matches_played ?? 0 }}</span></div>
                    <div class="score-row"><span class="score-row-lbl">G'alabalar</span><span class="score-row-val green">{{ $currentRating?->wins ?? 0 }}</span></div>
                    <div class="score-row"><span class="score-row-lbl">Mag'lubiyatlar</span><span class="score-row-val red">{{ $currentRating?->losses ?? 0 }}</span></div>
                </div>
            </div>

            <div class="pf-card mb-3">
                <div class="pf-card-hdr">
                    <div class="pf-card-hdr-icon"><i class="bi bi-star-fill"></i></div>
                    Medal xisoboti
                </div>
                <div class="p-3">
                    <div class="medal-grid">
                        <div class="medal-box gold">
                            <div class="medal-box-ico">🥇</div>
                            <div class="medal-box-num">{{ $athlete->gold_medals }}</div>
                            <div class="medal-box-lbl">Oltin</div>
                        </div>
                        <div class="medal-box silver">
                            <div class="medal-box-ico">🥈</div>
                            <div class="medal-box-num">{{ $athlete->silver_medals }}</div>
                            <div class="medal-box-lbl">Kumush</div>
                        </div>
                        <div class="medal-box bronze">
                            <div class="medal-box-ico">🥉</div>
                            <div class="medal-box-num">{{ $athlete->bronze_medals }}</div>
                            <div class="medal-box-lbl">Bronza</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pf-card">
                <div class="pf-card-hdr">
                    <div class="pf-card-hdr-icon"><i class="bi bi-share"></i></div>
                    Ulashish
                </div>
                <div class="p-3 d-flex gap-2">
                    <button class="share-btn share-tg" onclick="share('telegram')"><i class="bi bi-telegram"></i> Telegram</button>
                    <button class="share-btn share-fb" onclick="share('facebook')"><i class="bi bi-facebook"></i> Facebook</button>
                    <button class="share-btn share-cp" id="copy-btn" onclick="copyLink()">🔗 Nusxa</button>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Cover Slider ──
            let currentSlide = 0;
            const slides = document.querySelectorAll('.cover-slide');
            const dots   = document.querySelectorAll('.cover-dot');

            function goToSlide(n) {
                slides[currentSlide].classList.remove('active');
                dots[currentSlide]?.classList.remove('active');
                currentSlide = (n + slides.length) % slides.length;
                slides[currentSlide].classList.add('active');
                dots[currentSlide]?.classList.add('active');
            }

            window.goToSlide   = goToSlide;
            window.changeSlide = dir => goToSlide(currentSlide + dir);

            if (slides.length > 1) {
                setInterval(() => window.changeSlide(1), 5000);
            }

            // ── Tabs ──
            window.switchTab = function(id, el) {
                event.preventDefault();
                document.querySelectorAll('.tab-pane-custom').forEach(p => p.classList.remove('active'));
                document.querySelectorAll('.ptab').forEach(t => t.classList.remove('active'));
                document.getElementById('tab-' + id).classList.add('active');
                el.classList.add('active');
                if (id === 'history') initChart();
            };

            // ── Chart ──
            let chartInited = false;
            function initChart() {
                if (chartInited) return;
                chartInited = true;
                const ratings = @json($ratings->map(fn($r) => ['season' => $r->season->name, 'score' => $r->total_points]));
                const ctx = document.getElementById('ratingChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ratings.map(r => r.season),
                        datasets: [{
                            label: 'Reyting bali',
                            data: ratings.map(r => r.score),
                            borderColor: '#1565a8',
                            backgroundColor: 'rgba(21,101,168,.07)',
                            tension: 0.45, fill: true,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#1565a8',
                            pointBorderWidth: 2,
                            pointRadius: 5, pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { grid: { color: 'rgba(0,0,0,.05)' }, ticks: { font: { size: 11 } } },
                            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                        }
                    }
                });
            }

            // ── Share ──
            window.share = function(p) {
                const url = encodeURIComponent(location.href);
                const txt = encodeURIComponent('{{ $athlete->last_name }} {{ $athlete->first_name }} — SportReyting.uz');
                if (p === 'telegram') window.open('https://t.me/share/url?url='+url+'&text='+txt);
                if (p === 'facebook') window.open('https://www.facebook.com/sharer/sharer.php?u='+url);
            };

            window.copyLink = function() {
                navigator.clipboard.writeText(location.href);
                const btn = document.getElementById('copy-btn');
                btn.textContent = '✓ Nusxalandi';
                setTimeout(() => btn.textContent = '🔗 Nusxa', 2000);
            };

        });
    </script>

@endsection
