@extends('layouts.backend')
@section('title', 'Competition Show')
@section('admin')

    <style>
        .wrap { padding: 1.5rem 0; max-width: 860px; margin: 0 auto; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #888; text-decoration: none; margin-bottom: 1.25rem; }
        .back-link:hover { color: #1a1a1a; }
        .detail-card { background: #fff; border: 0.5px solid #e5e4e0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
        .card-top { padding: 1.5rem; border-bottom: 0.5px solid #e5e4e0; display: flex; align-items: center; gap: 14px; }
        .header-icon { width: 42px; height: 42px; border-radius: 10px; background: #EEEDFE; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .card-top h2 { font-size: 17px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .card-top p { font-size: 13px; color: #888; margin: 2px 0 0; }
        .card-actions { margin-left: auto; display: flex; gap: 8px; }
        .btn-edit { padding: 7px 16px; border-radius: 8px; border: 0.5px solid #FAC775; background: #FAEEDA; color: #633806; font-size: 13px; font-weight: 500; text-decoration: none; }
        .btn-del  { padding: 7px 16px; border-radius: 8px; border: 0.5px solid #F0997B; background: #FAECE7; color: #4A1B0C; font-size: 13px; font-weight: 500; cursor: pointer; border: none; }
        .body { display: grid; grid-template-columns: 1fr 1fr; }
        .left-col { padding: 1.5rem; border-right: 0.5px solid #e5e4e0; }
        .right-col { padding: 1.5rem; }
        .section-label { font-size: 11px; font-weight: 600; color: #aaa; text-transform: uppercase; letter-spacing: 0.07em; margin: 0 0 1rem; }
        .info-row { display: flex; align-items: flex-start; gap: 10px; padding: 0.65rem 0; border-bottom: 0.5px solid #e5e4e0; }
        .info-row:last-child { border-bottom: none; }
        .info-icon { width: 30px; height: 30px; border-radius: 7px; background: #f5f4f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .info-label { font-size: 11px; color: #aaa; }
        .info-value { font-size: 13px; font-weight: 500; color: #1a1a1a; margin-top: 1px; }
        .badge { display: inline-flex; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .badge-international { background: #FAEEDA; color: #633806; }
        .badge-national      { background: #EEEDFE; color: #3C3489; }
        .badge-regional      { background: #E1F5EE; color: #0F6E56; }
        .badge-upcoming      { background: #E6F1FB; color: #185FA5; }
        .badge-ongoing       { background: #EAF3DE; color: #3B6D11; }
        .badge-completed     { background: #F1EFE8; color: #5F5E5A; }
        .badge-cancelled     { background: #FCEBEB; color: #A32D2D; }
        .img-wrap { border-radius: 10px; overflow: hidden; border: 0.5px solid #e5e4e0; aspect-ratio: 16/9; background: #f5f4f0; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
        .img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .desc-box { background: #fafaf8; border-radius: 8px; padding: 12px 14px; font-size: 13px; color: #555; line-height: 1.6; border: 0.5px solid #e5e4e0; }
        .stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 1rem; }
        .stat-card { background: #fafaf8; border-radius: 8px; padding: 10px 12px; border: 0.5px solid #e5e4e0; }
        .stat-num { font-size: 22px; font-weight: 600; color: #1a1a1a; }
        .stat-lbl { font-size: 11px; color: #aaa; margin-top: 1px; }
        .date-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 1rem; }
        .date-box-label { font-size: 11px; color: #aaa; margin-bottom: 4px; }
        .date-box-val { font-size: 13px; font-weight: 500; color: #1a1a1a; background: #f5f4f0; padding: 7px 10px; border-radius: 7px; }
        @media(max-width:600px){ .body{grid-template-columns:1fr} .left-col{border-right:none;border-bottom:0.5px solid #e5e4e0} }
    </style>

    <div class="wrap">
        <a class="back-link" href="{{ route('admin.competitions.index') }}">
            ← Musobaqalar ro'yxatiga qaytish
        </a>

        <div class="detail-card">
            {{-- Header --}}
            <div class="card-top">
                <div class="header-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.8">
                        <circle cx="12" cy="8" r="6"/>
                        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                    </svg>
                </div>
                <div>
                    <h2>{{ $competition->title_uz }}</h2>
                    <p>Musobaqa tafsilotlari · #{{ $competition->id }}</p>
                </div>
                <div class="card-actions">
                    <a href="{{ route('admin.competitions.edit', $competition->id) }}" class="btn-edit">Tahrirlash</a>
                    <form action="{{ route('admin.competitions.destroy', $competition->id) }}" method="POST" style="display:inline" onsubmit="return confirm('O\'chirilsinmi?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-del">O'chirish</button>
                    </form>
                </div>
            </div>

            <div class="body">
                {{-- LEFT --}}
                <div class="left-col">
                    <p class="section-label">Asosiy ma'lumot</p>

                    <div class="info-row">
                        <div class="info-icon">🏅</div>
                        <div>
                            <div class="info-label">Sport turi</div>
                            <div class="info-value">{{ $competition->sport->name_uz }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📅</div>
                        <div>
                            <div class="info-label">Mavsum</div>
                            <div class="info-value">{{ $competition->season->name }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">⭐</div>
                        <div>
                            <div class="info-label">Daraja</div>
                            <div class="info-value">
              <span class="badge badge-{{ $competition->level }}">
                {{ match($competition->level) {
                  'international' => 'Xalqaro',
                  'national'      => 'Respublika',
                  'regional'      => 'Viloyat',
                  default         => $competition->level
                } }}
              </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🔵</div>
                        <div>
                            <div class="info-label">Holat</div>
                            <div class="info-value">
              <span class="badge badge-{{ $competition->status }}">
                {{ match($competition->status) {
                  'upcoming'  => 'Kutilmoqda',
                  'ongoing'   => 'Davom etmoqda',
                  'completed' => 'Yakunlangan',
                  'cancelled' => 'Bekor qilingan',
                  default     => $competition->status
                } }}
              </span>
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">👤</div>
                        <div>
                            <div class="info-label">Tashkilotchi</div>
                            <div class="info-value">{{ $competition->organizer ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📍</div>
                        <div>
                            <div class="info-label">Manzil</div>
                            <div class="info-value">{{ $competition->location_uz }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🌍</div>
                        <div>
                            <div class="info-label">Mamlakat</div>
                            <div class="info-value">{{ $competition->location_country ?? '—' }}</div>
                        </div>
                    </div>

                    <div class="date-row">
                        <div>
                            <div class="date-box-label">Boshlanish</div>
                            <div class="date-box-val">{{ $competition->start_date }}</div>
                        </div>
                        <div>
                            <div class="date-box-label">Tugash</div>
                            <div class="date-box-val">{{ $competition->end_date }}</div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="right-col">
                    <div class="img-wrap">
                        @if($competition->image)
                            <img src="{{ asset('images/competitions/' . $competition->image) }}" width="100" alt="">
                        @else
                            <span style="font-size:13px;color:#aaa">Rasm yo'q</span>
                        @endif
                    </div>

                    <div class="stat-row">
                        <div class="stat-card">
                            <div class="stat-num">{{ $competition->participants_count }}</div>
                            <div class="stat-lbl">Ishtirokchilar</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-num">{{ $competition->rating }}</div>
                            <div class="stat-lbl">Reyting koeff.</div>
                        </div>
                    </div>

                    <p class="section-label">Tavsif</p>
                    <div class="desc-box">
                        {{ strip_tags($competition->description_uz ?? '—') }}
                    </div>

                    <div style="margin-top:1rem;padding-top:1rem;border-top:0.5px solid #e5e4e0">
                        <div style="font-size:11px;color:#aaa;margin-bottom:4px">Yaratilgan vaqt</div>
                        <div style="font-size:12px;color:#888">{{ $competition->created_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
