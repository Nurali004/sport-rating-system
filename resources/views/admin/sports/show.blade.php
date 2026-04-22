@extends('layouts.backend')
@section('title', 'Sports Show')
@section('admin')

    <style>
        .page-wrap { padding: 1.5rem 0; }
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            background: transparent;
            text-decoration: none;
            transition: background 0.15s;
        }
        .back-btn:hover { background: #f5f4f0; color: #444; }
        .action-row { display: flex; gap: 8px; }
        .edit-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; background: #EEEDFE; border: 0.5px solid #AFA9EC;
            border-radius: 8px; font-size: 13px; font-weight: 500; color: #3C3489; text-decoration: none;
        }
        .del-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; background: #FCEBEB; border: 0.5px solid #F09595;
            border-radius: 8px; font-size: 13px; font-weight: 500; color: #791F1F; text-decoration: none;
        }
        .card-outer {
            background: #fff;
            border: 0.5px solid #e5e4e0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .sport-hero {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 1.5rem;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .sport-hero img {
            width: 90px; height: 90px;
            object-fit: cover; border-radius: 10px;
            border: 0.5px solid #e5e4e0;
        }
        .hero-img-placeholder {
            width: 90px; height: 90px; border-radius: 10px;
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
        }
        .hero-name { font-size: 22px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .hero-slug { font-size: 13px; color: #aaa; margin: 4px 0 10px; font-family: monospace; }
        .status-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .status-active   { background: #EAF3DE; color: #27500A; }
        .status-inactive { background: #F1EFE8; color: #5F5E5A; }
        .olympic-badge {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500; background: #EEEDFE; color: #3C3489; margin-left: 6px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .info-cell {
            padding: 1rem 1.25rem;
            border-right: 0.5px solid #e5e4e0;
        }
        .info-cell:last-child { border-right: none; }
        .info-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px;
        }
        .info-val { font-size: 14px; font-weight: 500; color: #1a1a1a; }
        .section-title {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em;
            padding: 1rem 1.25rem 0.6rem;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .lang-tabs {
            display: flex;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .lang-tab {
            padding: 10px 22px; font-size: 13px; font-weight: 500;
            color: #888; cursor: pointer;
            border-bottom: 2px solid transparent; margin-bottom: -0.5px;
            transition: color 0.15s;
        }
        .lang-tab.active { color: #534AB7; border-bottom-color: #534AB7; }
        .lang-tab:hover { color: #534AB7; }
        .desc-block {
            padding: 1.25rem;
            font-size: 14px;
            color: #1a1a1a;
            line-height: 1.75;
            min-height: 80px;
        }
        @media (max-width: 640px) {
            .info-grid { grid-template-columns: 1fr 1fr; }
            .info-grid .info-cell:nth-child(3) { grid-column: span 2; border-right: none; }
            .top-bar { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>

    <div class="container" style="max-width: 860px;">
        <div class="page-wrap">

            <div class="top-bar">
                <a href="{{ route('admin.sports.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
                <div class="action-row">
                    <a href="{{ route('admin.sports.edit', $sport->id) }}" class="edit-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                        Tahrirlash
                    </a>
                    <form action="{{ route('admin.sports.destroy', $sport->id) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="del-btn" style="border:0.5px solid #F09595;cursor:pointer;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14H6L5 6"/>
                                <path d="M10 11v6M14 11v6"/>
                            </svg>
                            O'chirish
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-outer">

                {{-- Hero --}}
                <div class="sport-hero">
                    @if($sport->image)
                        <img src="{{ asset('images/sports/' . $sport->image) }}"
                             alt="{{ $sport->name_uz }}"
                             onerror="this.parentElement.innerHTML='<div class=\'hero-img-placeholder\'><svg width=\'36\' height=\'36\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#534AB7\' stroke-width=\'1.5\'><circle cx=\'12\' cy=\'8\' r=\'4\'/><path d=\'M4 20c0-4 3.6-7 8-7s8 3 8 7\'/></svg></div>'">
                    @else
                        <div class="hero-img-placeholder">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.5">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="hero-name">{{ $sport->name_uz }}</h2>
                        <p class="hero-slug">{{ $sport->slug }}</p>
                        <span class="status-badge {{ $sport->status ? 'status-active' : 'status-inactive' }}">
                        {{ $sport->status ? 'Aktiv' : 'Nofaol' }}
                    </span>
                        @if($sport->icon)
                            <span class="olympic-badge">{{ $sport->icon }}</span>
                        @endif
                    </div>
                </div>

                {{-- Names row --}}
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-label">Nomi (UZ)</div>
                        <div class="info-val">{{ $sport->name_uz }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Nomi (EN)</div>
                        <div class="info-val">{{ $sport->name_en }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Nomi (RU)</div>
                        <div class="info-val">{{ $sport->name_ru }}</div>
                    </div>
                </div>

                {{-- Meta row --}}
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-label">Tartib raqami</div>
                        <div class="info-val">{{ $sport->order ?? '—' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Ikon</div>
                        <div class="info-val">{{ $sport->icon ?? '—' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Yaratilgan</div>
                        <div class="info-val" style="font-size:13px">{{ $sport->created_at->format('Y-m-d  H:i') }}</div>
                    </div>
                </div>

                {{-- Descriptions --}}
                <div class="section-title">Tavsif</div>
                <div class="lang-tabs">
                    <div class="lang-tab active" onclick="switchLang('uz', this)">O'zbek</div>
                    <div class="lang-tab" onclick="switchLang('en', this)">English</div>
                    <div class="lang-tab" onclick="switchLang('ru', this)">Русский</div>
                </div>
                <div class="desc-block" id="desc-uz">{!! $sport->description_uz !!}</div>
                <div class="desc-block" id="desc-en" style="display:none">{!! $sport->description_en !!}</div>
                <div class="desc-block" id="desc-ru" style="display:none">{!! $sport->description_ru !!}</div>

            </div>
        </div>
    </div>

    <script>
        function switchLang(lang, el) {
            ['uz', 'en', 'ru'].forEach(l => {
                document.getElementById('desc-' + l).style.display = l === lang ? '' : 'none';
            });
            document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }
    </script>

@endsection
