@extends('layouts.front')
@section('title', 'Show Competition')
@section('front')

    <style>
        .comp-wrap { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }

        /* Hero banner */
        .comp-hero {
            border-radius: 14px; overflow: hidden;
            border: 0.5px solid #e5e4e0;
            margin-bottom: 1.5rem;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .comp-hero-img {
            width: 100%; height: 450px; object-fit: cover; display: block;
        }
        .comp-hero-placeholder {
            width: 100%; height: 220px;
            background: linear-gradient(135deg, #EEEDFE 0%, #E1F5EE 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .comp-hero-body { padding: 1.5rem; }
        .comp-title { font-size: 22px; font-weight: 700; color: #1a1a1a; margin: 0 0 10px; }

        .meta-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1rem; }
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .badge-sport   { background: #EEEDFE; color: #3C3489; }
        .badge-season  { background: #E1F5EE; color: #0F6E56; }
        .badge-level   { background: #FAEEDA; color: #633806; }
        .badge-upcoming   { background: #E6F1FB; color: #185FA5; }
        .badge-ongoing    { background: #EAF3DE; color: #27500A; }
        .badge-completed  { background: #F1EFE8; color: #5F5E5A; }
        .badge-cancelled  { background: #FCEBEB; color: #791F1F; }

        /* Info grid */
        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1rem; margin-bottom: 1.5rem;
        }
        .info-card {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; padding: 1.25rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .info-card-title {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin-bottom: 0.85rem; display: flex; align-items: center; gap: 6px;
        }
        .info-card-title svg { flex-shrink: 0; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 0.5px solid #f0efeb; }
        .info-row:last-child { border-bottom: none; padding-bottom: 0; }
        .info-key   { font-size: 12px; color: #888; }
        .info-val   { font-size: 13px; font-weight: 500; color: #1a1a1a; text-align: right; }

        /* Date bar */
        .date-bar {
            display: flex; align-items: center; gap: 0;
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .date-block {
            flex: 1; padding: 1.25rem; text-align: center;
            border-right: 0.5px solid #e5e4e0;
        }
        .date-block:last-child { border-right: none; }
        .date-label { font-size: 11px; font-weight: 600; color: #bbb; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
        .date-val   { font-size: 16px; font-weight: 600; color: #1a1a1a; }
        .date-arrow { padding: 0 1rem; color: #ccc; font-size: 20px; align-self: center; }

        /* Participants */
        .participants-bar {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .participants-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .participants-title { font-size: 11px; font-weight: 600; color: #bbb; text-transform: uppercase; letter-spacing: 0.06em; }
        .participants-count { font-size: 16px; font-weight: 700; color: #534AB7; }
        .progress-track { height: 6px; background: #f0efeb; border-radius: 10px; overflow: hidden; }
        .progress-fill  { height: 100%; background: #534AB7; border-radius: 10px; transition: width 0.4s; }

        /* Rating bar */
        .rating-bar {
            background: #EEEDFE; border: 0.5px solid #AFA9EC;
            border-radius: 12px; padding: 1.25rem;
            display: flex; align-items: center; gap: 16px;
            margin-bottom: 1.5rem;
        }
        .rating-num { font-size: 36px; font-weight: 700; color: #534AB7; line-height: 1; }
        .rating-stars { display: flex; gap: 3px; margin-bottom: 4px; }
        .rating-desc { font-size: 12px; color: #7F77DD; }

        /* Description */
        .desc-card {
            background: #fff; border: 0.5px solid #e5e4e0;
            border-radius: 12px; padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .desc-card-title {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin-bottom: 0.85rem; display: flex; align-items: center; gap: 6px;
        }
        .desc-body { font-size: 14px; color: #444; line-height: 1.75; }

        @media (max-width: 640px) {
            .info-grid { grid-template-columns: 1fr; }
            .date-bar  { flex-direction: column; }
            .date-block { border-right: none; border-bottom: 0.5px solid #e5e4e0; }
            .date-block:last-child { border-bottom: none; }
            .comp-hero-img { height: 180px; }
        }
    </style>

    <div class="comp-wrap">

        {{-- Hero --}}
        <div class="comp-hero">
            @if($competition->image)
                <img src="{{ asset('images/competitions/' . $competition->image) }}"
                     alt="{{ $competition->title_uz }}" class="comp-hero-img">
            @else
                <div class="comp-hero-placeholder">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#AFA9EC" stroke-width="1.2">
                        <path d="M8 21h8M12 17v4M7 4H4a1 1 0 0 0-1 1v2c0 3.3 2.3 6 5.4 6.8M17 4h3a1 1 0 0 1 1 1v2c0 3.3-2.3 6-5.4 6.8M12 13c-2.8 0-5-2.2-5-5V4h10v4c0 2.8-2.2 5-5 5z"/>
                    </svg>
                </div>
            @endif
            <div class="comp-hero-body">
                <h1 class="comp-title">{{ $competition->title_uz }}</h1>
                <div class="meta-badges">
                <span class="badge badge-sport">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    {{ $competition->sport->name_uz ?? '—' }}
                </span>
                    <span class="badge badge-season">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                    {{ $competition->season->name ?? '—' }}
                </span>
                    @if($competition->level)
                        <span class="badge badge-level">{{ ucfirst($competition->level) }}</span>
                    @endif
                    @php
                        $statusClass = match($competition->status) {
                            'upcoming'  => 'badge-upcoming',
                            'ongoing'   => 'badge-ongoing',
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            default     => 'badge-upcoming',
                        };
                        $statusLabel = match($competition->status) {
                            'upcoming'  => 'Kutilmoqda',
                            'ongoing'   => 'Davom etmoqda',
                            'completed' => 'Yakunlangan',
                            'cancelled' => 'Bekor qilindi',
                            default     => $competition->status,
                        };
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>

        {{-- Date bar --}}
        <div class="date-bar">
            <div class="date-block">
                <div class="date-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" style="display:inline;margin-right:4px"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                    Boshlanish
                </div>
                <div class="date-val">{{ \Carbon\Carbon::parse($competition->start_date)->format('d.m.Y') }}</div>
            </div>
            <div class="date-block">
                <div class="date-label">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" style="display:inline;margin-right:4px"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/></svg>
                    Tugash
                </div>
                <div class="date-val">{{ \Carbon\Carbon::parse($competition->end_date)->format('d.m.Y') }}</div>
            </div>
            <div class="date-block">
                <div class="date-label">Davomiylik</div>
                <div class="date-val">
                    {{ \Carbon\Carbon::parse($competition->start_date)->diffInDays($competition->end_date) + 1 }} kun
                </div>
            </div>
        </div>

        {{-- Info grid --}}
        <div class="info-grid">
            <div class="info-card">
                <div class="info-card-title">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Joylashuv
                </div>
                <div class="info-row">
                    <span class="info-key">Manzil</span>
                    <span class="info-val">{{ $competition->location_uz }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Mamlakat</span>
                    <span class="info-val">{{ $competition->location_country }}</span>
                </div>
            </div>
            <div class="info-card">
                <div class="info-card-title">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Tashkilot
                </div>
                <div class="info-row">
                    <span class="info-key">Tashkilotchi</span>
                    <span class="info-val">{{ $competition->organizer }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Daraja</span>
                    <span class="info-val">{{ ucfirst($competition->level) }}</span>
                </div>
            </div>
        </div>

        {{-- Participants --}}
        <div class="participants-bar">
            <div class="participants-header">
                <div class="participants-title">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2" style="display:inline;margin-right:5px"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Qatnashuvchilar
                </div>
                <div class="participants-count">{{ $competition->participants_count }} ta o'rin</div>
            </div>
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ min(100, ($competition->participants_count / 200) * 100) }}%"></div>
            </div>
        </div>

        {{-- Rating --}}
        @php
            $ratingLabel = match(true) {
                $competition->rating >= 3.0 => 'Xalqaro daraja',
                $competition->rating >= 2.0 => 'Respublika darajasi',
                $competition->rating >= 1.0 => 'Viloyat darajasi',
                default                     => 'Mahalliy daraja',
            };
            $stars = round($competition->rating * 2);
        @endphp
        <div class="rating-bar">
            <div class="rating-num">{{ number_format($competition->rating, 1) }}</div>
            <div>
                <div class="rating-stars">
                    @for($i = 1; $i <= 6; $i++)
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="{{ $i <= $stars ? '#7F77DD' : 'none' }}" stroke="#7F77DD" stroke-width="2">
                            <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                        </svg>
                    @endfor
                </div>
                <div class="rating-desc">{{ $ratingLabel }}</div>
            </div>
        </div>

        {{-- Description --}}
        @if($competition->description_uz)
            <div class="desc-card">
                <div class="desc-card-title">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Tavsif
                </div>
                <div class="desc-body">{!! $competition->description_uz !!}</div>
            </div>
        @endif

    </div>

@endsection
