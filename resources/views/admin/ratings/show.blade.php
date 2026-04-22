@extends('layouts.backend')
@section('title', 'Show Rating')
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
            display: flex; align-items: center; gap: 20px;
            padding: 1.5rem; border-bottom: 0.5px solid #e5e4e0;
        }
        .athlete-avatar {
            width: 80px; height: 80px; border-radius: 50%;
            object-fit: cover; border: 2px solid #e5e4e0; flex-shrink: 0;
        }
        .athlete-avatar-placeholder {
            width: 80px; height: 80px; border-radius: 50%;
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; font-size: 24px; font-weight: 600;
            color: #3C3489; flex-shrink: 0;
        }
        .hero-info { flex: 1; }
        .hero-name { font-size: 20px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .hero-meta { font-size: 13px; color: #888; margin: 4px 0 10px; display: flex; gap: 12px; }
        .hero-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
        }
        .badge-sport  { background: #EEEDFE; color: #3C3489; }
        .badge-season { background: #E1F5EE; color: #0F6E56; }

        /* Rank banner */
        .rank-banner {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            padding: 1rem 1.5rem; background: #EEEDFE;
            border-bottom: 0.5px solid #d5d2f5;
        }
        .rank-num { font-size: 32px; font-weight: 700; color: #534AB7; line-height: 1; }
        .rank-label { font-size: 12px; color: #7F77DD; font-weight: 500; }

        /* Stats grid */
        .stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            border-bottom: 0.5px solid #e5e4e0;
        }
        .stat-cell {
            padding: 1.25rem; text-align: center;
            border-right: 0.5px solid #e5e4e0;
        }
        .stat-cell:last-child { border-right: none; }
        .stat-val { font-size: 26px; font-weight: 700; color: #1a1a1a; line-height: 1; }
        .stat-label { font-size: 11px; font-weight: 500; color: #aaa; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 5px; }
        .stat-val.points-val { color: #534AB7; }

        /* Medals row */
        .medals-row {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .medal-cell {
            padding: 1.25rem; display: flex; align-items: center; gap: 14px;
            border-right: 0.5px solid #e5e4e0;
        }
        .medal-cell:last-child { border-right: none; }
        .medal-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .icon-gold   { background: #FAEEDA; }
        .icon-silver { background: #F1EFE8; }
        .icon-bronze { background: #FAECE7; }
        .medal-count { font-size: 22px; font-weight: 700; color: #1a1a1a; line-height: 1; }
        .medal-name  { font-size: 11px; font-weight: 500; color: #aaa; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 3px; }

        /* Meta row */
        .meta-row {
            display: grid; grid-template-columns: 1fr 1fr 1fr;
        }
        .meta-cell {
            padding: 1rem 1.25rem;
            border-right: 0.5px solid #e5e4e0;
        }
        .meta-cell:last-child { border-right: none; }
        .meta-label { font-size: 11px; font-weight: 600; color: #bbb; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .meta-val   { font-size: 13px; font-weight: 500; color: #1a1a1a; }

        @media (max-width: 640px) {
            .stats-grid  { grid-template-columns: 1fr 1fr; }
            .medals-row  { grid-template-columns: 1fr; }
            .meta-row    { grid-template-columns: 1fr 1fr; }
            .top-bar     { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>

    <div class="container" style="max-width: 820px;">
        <div class="page-wrap">

            <div class="top-bar">
                <a href="{{ route('admin.ratings.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
                <div class="action-row">
                    <a href="{{ route('admin.ratings.edit', $rating->id) }}" class="edit-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                        Tahrirlash
                    </a>
                    <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST"
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
                    @if($rating->athlete->photo ?? null)
                        <img src="{{ asset('images/athletes/' . $rating->athlete->photo) }}"
                             alt="{{ $rating->athlete->first_name }}"
                             class="athlete-avatar">
                    @else
                        @php
                            $initials = strtoupper(
                                substr($rating->athlete->first_name ?? 'A', 0, 1) .
                                substr($rating->athlete->last_name  ?? 'A', 0, 1)
                            );
                        @endphp
                        <div class="athlete-avatar-placeholder">{{ $initials }}</div>
                    @endif
                    <div class="hero-info">
                        <h2 class="hero-name">
                            {{ $rating->athlete->first_name }} {{ $rating->athlete->last_name }}
                        </h2>
                        <div class="hero-meta">
                            <span>#{{ $rating->id }}</span>
                            <span>{{ $rating->created_at->format('Y-m-d') }}</span>
                        </div>
                        <div class="hero-badges">
                        <span class="badge badge-sport">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                            </svg>
                            {{ $rating->sport->name_uz }}
                        </span>
                            <span class="badge badge-season">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                            </svg>
                            {{ $rating->season->name }}
                        </span>
                        </div>
                    </div>
                </div>

                {{-- Rank banner --}}
                <div class="rank-banner">
                    <div style="text-align:center;">
                        <div class="rank-num">#{{ $rating->rank_position }}</div>
                        <div class="rank-label">Reyting o'rni</div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="stats-grid">
                    <div class="stat-cell">
                        <div class="stat-val points-val">{{ number_format($rating->total_points) }}</div>
                        <div class="stat-label">Jami ball</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-val">{{ $rating->competition_count }}</div>
                        <div class="stat-label">Musobaqalar</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-val">{{ $rating->gold_count + $rating->silver_count + $rating->bronze_count }}</div>
                        <div class="stat-label">Jami medallar</div>
                    </div>
                    <div class="stat-cell">
                        <div class="stat-val" style="color:#1D9E75;">
                            {{ $rating->competition_count > 0 ? number_format($rating->total_points / $rating->competition_count, 1) : '0' }}
                        </div>
                        <div class="stat-label">O'rtacha ball</div>
                    </div>
                </div>

                {{-- Medals --}}
                <div class="medals-row">
                    <div class="medal-cell">
                        <div class="medal-icon icon-gold">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#BA7517" stroke-width="1.8">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="medal-count">{{ $rating->gold_count }}</div>
                            <div class="medal-name">Oltin</div>
                        </div>
                    </div>
                    <div class="medal-cell">
                        <div class="medal-icon icon-silver">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#888780" stroke-width="1.8">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="medal-count">{{ $rating->silver_count }}</div>
                            <div class="medal-name">Kumush</div>
                        </div>
                    </div>
                    <div class="medal-cell">
                        <div class="medal-icon icon-bronze">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#D85A30" stroke-width="1.8">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="medal-count">{{ $rating->bronze_count }}</div>
                            <div class="medal-name">Bronza</div>
                        </div>
                    </div>
                </div>

                {{-- Meta --}}
                <div class="meta-row">
                    <div class="meta-cell">
                        <div class="meta-label">Sport turi</div>
                        <div class="meta-val">{{ $rating->sport->name_uz }}</div>
                    </div>
                    <div class="meta-cell">
                        <div class="meta-label">Mavsum</div>
                        <div class="meta-val">{{ $rating->season->name }}</div>
                    </div>
                    <div class="meta-cell">
                        <div class="meta-label">Yaratilgan</div>
                        <div class="meta-val" style="font-size:12px;">{{ $rating->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
