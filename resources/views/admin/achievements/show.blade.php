@extends('layouts.backend')
@section('title', 'Show Achievement')
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
        .achievement-hero {
            display: flex; align-items: center; gap: 20px;
            padding: 1.5rem; border-bottom: 0.5px solid #e5e4e0;
        }
        .medal-icon {
            width: 64px; height: 64px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .medal-gold   { background: #FAEEDA; }
        .medal-silver { background: #F1EFE8; }
        .medal-bronze { background: #FAECE7; }
        .hero-title { font-size: 20px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .hero-sub   { font-size: 13px; color: #888; margin: 4px 0 10px; }
        .medal-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 500;
        }
        .badge-gold   { background: #FAEEDA; border: 0.5px solid #FAC775; color: #633806; }
        .badge-silver { background: #F1EFE8; border: 0.5px solid #B4B2A9; color: #2C2C2A; }
        .badge-bronze { background: #FAECE7; border: 0.5px solid #F0997B; color: #4A1B0C; }

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
        .info-val { font-size: 14px; font-weight: 500; color: #1a1a1a; }

        .points-val {
            font-size: 22px; font-weight: 700; color: #534AB7;
        }
        .weight-pill {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
            background: #E1F5EE; color: #085041;
        }

        /* Notes */
        .notes-section { padding: 1.25rem; }
        .section-label {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px;
        }
        .notes-body {
            font-size: 14px; color: #444; line-height: 1.75;
            padding: 1rem; background: #faf9f7;
            border: 0.5px solid #e5e4e0; border-radius: 8px;
            min-height: 60px;
        }

        @media (max-width: 640px) {
            .info-grid { grid-template-columns: 1fr 1fr; }
            .top-bar { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>

    <div class="container" style="max-width: 820px;">
        <div class="page-wrap">

            <div class="top-bar">
                <a href="{{ route('admin.achievements.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
                <div class="action-row">
                    <a href="{{ route('admin.achievements.edit', $achievement->id) }}" class="edit-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                        Tahrirlash
                    </a>
                    <form action="{{ route('admin.achievements.destroy', $achievement->id) }}" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Haqiqatan ham o\'chirmoqchimisiz?')">
                        @csrf
                        @method('DELETE')
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
                <div class="achievement-hero">
                    @php $place = $achievement->place; @endphp

                    {{-- Sportchi rasmi --}}
                    <div style="flex-shrink:0;">
                        @if($achievement->athlete->photo ?? null)
                            <img src="{{ asset('images/athletes/' . $achievement->athlete->photo) }}"
                                 alt="{{ $achievement->athlete->first_name }}"
                                 style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:2px solid #e5e4e0;">
                        @else
                            @php
                                $initials = strtoupper(
                                    substr($achievement->athlete->first_name ?? 'A', 0, 1) .
                                    substr($achievement->athlete->last_name  ?? 'A', 0, 1)
                                );
                            @endphp
                            <div style="width:72px;height:72px;border-radius:50%;background:#EEEDFE;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:600;color:#3C3489;">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>

                    {{-- Medal ikonka --}}
                    <div class="medal-icon {{ $place == 1 ? 'medal-gold' : ($place == 2 ? 'medal-silver' : 'medal-bronze') }}">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                             stroke="{{ $place == 1 ? '#BA7517' : ($place == 2 ? '#888780' : '#D85A30') }}"
                             stroke-width="1.5">
                            <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="hero-title">
                            {{ ($achievement->athlete->first_name ?? '') . ' ' . ($achievement->athlete->last_name ?? '') }}
                        </h2>
                        <p class="hero-sub">{{ $achievement->competition->title_uz ?? '—' }}</p>
                        <span class="medal-badge {{ $place == 1 ? 'badge-gold' : ($place == 2 ? 'badge-silver' : 'badge-bronze') }}">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                        </svg>
                        {{ $place == 1 ? 'Oltin' : ($place == 2 ? 'Kumush' : 'Bronza') }}
                        — {{ $place }}-o'rin
                    </span>
                    </div>
                </div>

                {{-- Info row 1 --}}
                <div class="info-grid">
                    <div class="info-cell">
                        <div class="info-label">Mavsum</div>
                        <div class="info-val">{{ $achievement->season->name ?? '—' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Og'irlik kategoriyasi</div>
                        <div class="info-val">
                            @if($achievement->weight_category)
                                <span class="weight-pill">{{ $achievement->weight_category }}</span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Medal turi</div>
                        <div class="info-val">{{ $achievement->medal ?? '—' }}</div>
                    </div>
                </div>

                {{-- Info row 2 --}}
                <div class="info-grid" style="border-bottom: 0.5px solid #e5e4e0;">
                    <div class="info-cell">
                        <div class="info-label">Ball</div>
                        <div class="points-val">{{ $achievement->points ?? '0' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">ID</div>
                        <div class="info-val" style="color:#aaa;">#{{ $achievement->id }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Yaratilgan</div>
                        <div class="info-val" style="font-size:13px;">
                            {{ $achievement->created_at->format('Y-m-d  H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="notes-section">
                    <div class="section-label">Izoh</div>
                    <div class="notes-body">
                        @if($achievement->notes)
                            {!! $achievement->notes !!}
                        @else
                            <span style="color:#ccc;">Izoh yo'q</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
