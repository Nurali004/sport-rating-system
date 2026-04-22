@extends('layouts.front')
@section('title', 'Sportchilar ro\'yxati')
<style>
    .filter-panel {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
    }
    .filter-panel .form-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--text-muted);
        margin-bottom: 6px;
    }
    .filter-panel .form-select,
    .filter-panel .form-control {
        font-size: 13px;
        border-color: var(--border);
        border-radius: var(--radius-sm);
        color: var(--text-main);
    }
    .filter-panel .form-select:focus,
    .filter-panel .form-control:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 3px rgba(21,101,168,.12);
    }
    .btn-filter-apply {
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        padding: 8px 20px;
        transition: background .2s;
    }
    .btn-filter-apply:hover { background: var(--primary-light); color:#fff; }
    .btn-filter-reset {
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13px;
        padding: 8px 16px;
        transition: all .2s;
    }
    .btn-filter-reset:hover { border-color: var(--danger); color:var(--danger); }

    /* Athlete card */
    .athlete-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all .22s;
        text-decoration: none;
        color: var(--text-main);
        display: block;
        height: 100%;
    }
    .athlete-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(10,61,98,.12);
        border-color: var(--primary-light);
        color: var(--text-main);
    }
    .athlete-card-cover {
        height: 70px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        position: relative;
    }
    .athlete-card-cover .rank-badge-abs {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,.2);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,.3);
    }
    .athlete-card-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        border: 3px solid #fff;
        background: var(--primary-mid);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 600;
        position: absolute;
        bottom: -32px;
        left: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,.15);
        overflow: hidden;
    }
    .athlete-card-avatar img { width:100%; height:100%; object-fit:cover; }
    .athlete-card-body {
        padding: 40px 18px 18px;
    }
    .athlete-card-body .athlete-name {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .athlete-card-body .athlete-meta {
        font-size: 12px;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .athlete-card-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-top: 1px solid var(--border);
        margin-top: 14px;
        padding-top: 12px;
        text-align: center;
        gap: 0;
    }
    .athlete-card-stats .stat {
        border-right: 1px solid var(--border);
        padding: 0 4px;
    }
    .athlete-card-stats .stat:last-child { border-right: none; }
    .athlete-card-stats .stat-val {
        font-size: 16px;
        font-weight: 700;
        font-family: 'Oswald', sans-serif;
        color: var(--primary);
        line-height: 1.2;
    }
    .athlete-card-stats .stat-lbl {
        font-size: 10px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* View toggle */
    .view-toggle .btn {
        background: #fff;
        border: 1px solid var(--border);
        color: var(--text-muted);
        padding: 6px 12px;
        font-size: 15px;
    }
    .view-toggle .btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    /* Sort bar */
    .sort-bar {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 10px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }
    .sort-bar .sort-links a {
        font-size: 12px;
        color: var(--text-muted);
        text-decoration: none;
        padding: 4px 10px;
        border-radius: 20px;
        transition: all .15s;
    }
    .sort-bar .sort-links a.active,
    .sort-bar .sort-links a:hover {
        background: #e8f1fb;
        color: var(--primary);
        font-weight: 600;
    }
</style>
<script>
    function setView(type) {
        const grid = document.getElementById('athletesGrid');
        const cols = document.querySelectorAll('.athlete-col');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        if (type === 'list') {
            cols.forEach(c => {
                c.className = 'col-12 athlete-col';
                const card = c.querySelector('.athlete-card');
                card.style.display = 'flex';
                card.style.flexDirection = 'row';
            });
            gridBtn.classList.remove('active');
            listBtn.classList.add('active');
        } else {
            cols.forEach(c => {
                c.className = 'col-sm-6 col-md-4 col-lg-3 athlete-col';
                const card = c.querySelector('.athlete-card');
                card.style.display = '';
                card.style.flexDirection = '';
            });
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        }
    }
</script>
@section('front')
        <div class="container py-4">
            <div class="row g-4">

                {{-- ===== FILTER PANEL ===== --}}
                <div class="col-12 mt-4">
                    <div class="filter-panel">
                        <form action="{{ route('frontend.athletes.list') }}" method="GET" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label class="form-label">Qidirish</label>
                                    <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0" style="border-color:var(--border)">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                        <input type="text" name="q" class="form-control border-start-0" placeholder="Ism..." value="{{ request('q') }}" style="border-color:var(--border)">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sport turi</label>
                                    <select name="sport" class="form-select form-select-sm">
                                        <option value="">Barchasi</option>
                                        @foreach($sports as $sport)
                                            <option value="{{ $sport->slug }}" {{ request('sport') == $sport->slug ? 'selected' : '' }}>{{ $sport->name_uz }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Viloyat</label>
                                    <select name="region" class="form-select form-select-sm">
                                        <option value="">Barchasi</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}" {{ request('region') == $region->id ? 'selected' : '' }}>{{ $region->name_uz }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Jinsi</label>
                                    <select name="gender" class="form-select form-select-sm">
                                        <option value="">Barchasi</option>
                                        <option value="male"   {{ request('gender')=='male'   ? 'selected':'' }}>Erkak</option>
                                        <option value="female" {{ request('gender')=='female' ? 'selected':'' }}>Ayol</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Saralash</label>
                                    <select name="sort" class="form-select form-select-sm">
                                        <option value="rating" {{ request('sort','rating')=='rating' ? 'selected':'' }}>Reyting bo'yicha</option>
                                        <option value="name"   {{ request('sort')=='name'   ? 'selected':'' }}>Ism bo'yicha</option>
                                        <option value="wins"   {{ request('sort')=='wins'   ? 'selected':'' }}>G'alaba bo'yicha</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex gap-2">
                                    <button type="submit" class="btn-filter-apply btn w-100"><i class="bi bi-funnel-fill"></i></button>
                                    <a href="{{ route('frontend.athletes.list') }}" class="btn-filter-reset btn"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ===== SORT BAR ===== --}}
                <div class="col-12">
                    <div class="sort-bar">
                        <div class="sort-links d-flex gap-1">
                            <a href="{{ request()->fullUrlWithQuery(['sort'=>'rating']) }}" class="{{ request('sort','rating')=='rating' ? 'active' : '' }}">
                                <i class="bi bi-sort-down me-1"></i>Reyting
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort'=>'name']) }}" class="{{ request('sort')=='name' ? 'active' : '' }}">
                                <i class="bi bi-sort-alpha-down me-1"></i>Ism
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort'=>'wins']) }}" class="{{ request('sort')=='wins' ? 'active' : '' }}">
                                <i class="bi bi-trophy me-1"></i>G'alaba
                            </a>
                        </div>
                        <div class="view-toggle btn-group btn-group-sm">
                            <button class="btn active" id="gridViewBtn" onclick="setView('grid')">
                                <i class="bi bi-grid-3x3-gap-fill"></i>
                            </button>
                            <button class="btn" id="listViewBtn" onclick="setView('list')">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ===== ATHLETES GRID ===== --}}
                <section class="py-5">
                    <div class="container">
                        <div class="text-center mb-4">
                            <div>
                                <div class="section-label">Oyning eng yaxshilari</div>
                                <div class="section-title" style="text-align: center">TOP SPORTCHILAR</div>
                            </div>
                        </div>
                        <div class="row">

                            <!-- Athlete card — Nusxa: har bir sportchi uchun takrorlang -->
                            @foreach($athletes as $athlete)
                                <div class="col-md-4 fade-up fade-up-1">
                                    <div class="athlete-card">
                                        <div class="rank-badge gold">1</div>
                                        <div class="athlete-card-img">
                                            <img src="{{asset('images/athletes/'. $athlete->photo)}}" width="350" alt="">
                                        </div>
                                        <div class="athlete-card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <div class="athlete-name">{{$athlete->first_name}}</div>
                                                    <div class="athlete-sport">{{$athlete->sport->name_uz}} · {{$athlete->region->name_uz}}</div>
                                                </div>
                                                <div class="text-end">
                                                    <div class="athlete-points">{{$athlete->rating_score}}</div>
                                                    <div class="tbl-sub">pts</div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <span class="tag blue">🇺🇿 {{$athlete->club_name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </div>
        </div>

    @endsection



