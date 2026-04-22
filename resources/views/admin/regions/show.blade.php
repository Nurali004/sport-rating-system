@extends('layouts.backend')
@section('title', 'Show Region')
@section('admin')

    <style>
        .page-wrap { padding: 1.5rem 0; }
        .top-bar {
            display: flex; align-items: center;
            justify-content: space-between; margin-bottom: 1.5rem;
        }
        .back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border: 0.5px solid #d0cfc8; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: #666;
            background: transparent; text-decoration: none;
        }
        .back-btn:hover { background: #f5f4f0; color: #444; }
        .action-row { display: flex; gap: 8px; }
        .edit-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; background: #EEEDFE; border: 0.5px solid #AFA9EC;
            border-radius: 8px; font-size: 13px; font-weight: 500;
            color: #3C3489; text-decoration: none;
        }
        .del-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; background: #FCEBEB; border: 0.5px solid #F09595;
            border-radius: 8px; font-size: 13px; font-weight: 500;
            color: #791F1F; cursor: pointer;
        }

        .card-outer {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }

        /* Hero */
        .hero {
            display: flex; align-items: center; gap: 18px;
            padding: 1.5rem; border-bottom: 0.5px solid #e5e4e0;
        }
        .hero-icon {
            width: 60px; height: 60px; border-radius: 14px;
            background: #E1F5EE; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
        }
        .hero-name  { font-size: 20px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .hero-code  {
            display: inline-block; margin-top: 8px;
            padding: 3px 12px; border-radius: 6px;
            font-size: 13px; font-weight: 600; letter-spacing: 0.06em;
            background: #EEEDFE; color: #3C3489; font-family: monospace;
        }

        /* Names grid */
        .names-grid {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .name-cell {
            padding: 1.1rem 1.25rem;
            border-right: 0.5px solid #e5e4e0;
        }
        .name-cell:last-child { border-right: none; }
        .name-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px;
        }
        .name-val { font-size: 14px; font-weight: 500; color: #1a1a1a; }

        /* Meta row */
        .meta-row {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
        }
        .meta-cell {
            padding: 1rem 1.25rem;
            border-right: 0.5px solid #e5e4e0;
        }
        .meta-cell:last-child { border-right: none; }
        .meta-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px;
        }
        .meta-val { font-size: 13px; font-weight: 500; color: #1a1a1a; }

        @media (max-width: 600px) {
            .names-grid { grid-template-columns: 1fr; }
            .name-cell  { border-right: none; border-bottom: 0.5px solid #e5e4e0; }
            .name-cell:last-child { border-bottom: none; }
            .meta-row   { grid-template-columns: 1fr 1fr; }
            .top-bar    { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>

    <div class="container" style="max-width: 740px;">
        <div class="page-wrap">

            <div class="top-bar">
                <a href="{{ route('admin.regions.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
                <div class="action-row">
                    <a href="{{ route('admin.regions.edit', $region->id) }}" class="edit-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                        Tahrirlash
                    </a>
                    <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="del-btn">
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
                <div class="hero">
                    <div class="hero-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#0F6E56" stroke-width="1.6">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="hero-name">{{ $region->name_uz }}</h2>
                        @if($region->code)
                            <span class="hero-code">{{ $region->code }}</span>
                        @endif
                    </div>
                </div>

                {{-- Nomlar --}}
                <div class="names-grid">
                    <div class="name-cell">
                        <div class="name-label">Nomi (UZ)</div>
                        <div class="name-val">{{ $region->name_uz }}</div>
                    </div>
                    <div class="name-cell">
                        <div class="name-label">Nomi (EN)</div>
                        <div class="name-val">{{ $region->name_en ?? '—' }}</div>
                    </div>
                    <div class="name-cell">
                        <div class="name-label">Nomi (RU)</div>
                        <div class="name-val">{{ $region->name_ru ?? '—' }}</div>
                    </div>
                </div>

                {{-- Meta --}}
                <div class="meta-row">
                    <div class="meta-cell">
                        <div class="meta-label">Kod</div>
                        <div class="meta-val" style="font-family:monospace;font-size:14px;color:#534AB7;font-weight:600;">
                            {{ $region->code ?? '—' }}
                        </div>
                    </div>
                    <div class="meta-cell">
                        <div class="meta-label">Yaratilgan</div>
                        <div class="meta-val">{{ $region->created_at->format('Y-m-d  H:i') }}</div>
                    </div>
                    <div class="meta-cell">
                        <div class="meta-label">Yangilangan</div>
                        <div class="meta-val">{{ $region->updated_at->format('Y-m-d  H:i') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
