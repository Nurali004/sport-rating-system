@extends('layouts.backend')
@section('title', 'Show Season')
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
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
        }
        .hero-name { font-size: 20px; font-weight: 600; margin: 0 0 8px; color: #1a1a1a; }
        .hero-badges { display: flex; gap: 8px; flex-wrap: wrap; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
        }
        .badge-sport   { background: #EEEDFE; color: #3C3489; }
        .badge-active  { background: #EAF3DE; color: #27500A; }
        .badge-inactive{ background: #F1EFE8; color: #5F5E5A; }

        /* Date bar */
        .date-bar {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .date-cell {
            padding: 1.1rem 1.25rem; text-align: center;
            border-right: 0.5px solid #e5e4e0;
        }
        .date-cell:last-child { border-right: none; }
        .date-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px;
        }
        .date-val   { font-size: 15px; font-weight: 600; color: #1a1a1a; }
        .year-val   { font-size: 22px; font-weight: 700; color: #534AB7; font-family: monospace; }

        /* Info grid */
        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .info-cell {
            padding: 1rem 1.25rem;
            border-right: 0.5px solid #e5e4e0;
        }
        .info-cell:last-child { border-right: none; }
        .info-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 5px;
        }
        .info-val { font-size: 13px; font-weight: 500; color: #1a1a1a; }

        /* Duration bar */
        .duration-section { padding: 1.25rem; }
        .duration-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
        }
        .duration-track { height: 6px; background: #f0efeb; border-radius: 10px; overflow: hidden; margin-bottom: 6px; }
        .duration-fill  { height: 100%; background: #534AB7; border-radius: 10px; }
        .duration-meta  { display: flex; justify-content: space-between; font-size: 12px; color: #aaa; }

        @media (max-width: 600px) {
            .date-bar, .info-grid { grid-template-columns: 1fr; }
            .date-cell, .info-cell { border-right: none; border-bottom: 0.5px solid #e5e4e0; }
            .date-cell:last-child, .info-cell:last-child { border-bottom: none; }
            .top-bar { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>

    <div class="container" style="max-width: 760px;">
        <div class="page-wrap">

            <div class="top-bar">
                <a href="{{ route('admin.seasons.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
                <div class="action-row">
                    <a href="{{ route('admin.seasons.edit', $season->id) }}" class="edit-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                        Tahrirlash
                    </a>
                    <form action="{{ route('admin.seasons.destroy', $season->id) }}" method="POST"
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
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.6">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="hero-name">{{ $season->name }}</h2>
                        <div class="hero-badges">
                        <span class="badge badge-sport">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                            {{ $season->sport->name_uz ?? '—' }}
                        </span>
                            <span class="badge {{ $season->is_active == 'active' ? 'badge-active' : 'badge-inactive' }}">
                            @if($season->is_active == 1)
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                    Faol
                                @else
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                                    Nofaol
                                @endif
                        </span>
                        </div>
                    </div>
                </div>

                {{-- Yillar va sana oralig'i --}}
                <div class="date-bar">
                    <div class="date-cell">
                        <div class="date-label">Yillar</div>
                        <div class="year-val">{{ $season->year_start }} – {{ $season->year_end }}</div>
                    </div>
                    <div class="date-cell">
                        <div class="date-label">Boshlanish sanasi</div>
                        <div class="date-val">{{ \Carbon\Carbon::parse($season->start_date)->format('d.m.Y') }}</div>
                    </div>
                    <div class="date-cell">
                        <div class="date-label">Tugash sanasi</div>
                        <div class="date-val">{{ \Carbon\Carbon::parse($season->end_date)->format('d.m.Y') }}</div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-label">Sport turi</div>
                        <div class="info-val">{{ $season->sport->name_uz ?? '—' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Yaratilgan</div>
                        <div class="info-val">{{ $season->created_at->format('Y-m-d  H:i') }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Yangilangan</div>
                        <div class="info-val">{{ $season->updated_at->format('Y-m-d  H:i') }}</div>
                    </div>
                </div>

                {{-- Davomiylik progress --}}
                @php
                    $start    = \Carbon\Carbon::parse($season->start_date);
                    $end      = \Carbon\Carbon::parse($season->end_date);
                    $today    = \Carbon\Carbon::now();
                    $total    = $start->diffInDays($end) ?: 1;
                    $elapsed  = min($total, max(0, $start->diffInDays($today)));
                    $percent  = round(($elapsed / $total) * 100);
                @endphp
                <div class="duration-section">
                    <div class="duration-label">Davomiylik — {{ $total }} kun</div>
                    <div class="duration-track">
                        <div class="duration-fill" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="duration-meta">
                        <span>{{ $start->format('d.m.Y') }}</span>
                        <span style="color:#534AB7; font-weight:500;">{{ $percent }}% o'tdi</span>
                        <span>{{ $end->format('d.m.Y') }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
