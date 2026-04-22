@extends('layouts.backend')
@section('title', 'Edit Achievements')
@section('admin')

    <style>
        .form-card {
            background: #fff;
            border: 0.5px solid #e5e4e0;
            border-radius: 12px;
            padding: 2rem;
            margin: 1.5rem 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .form-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .header-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #EEEDFE;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .header-icon svg {
            width: 20px;
            height: 20px;
            color: #534AB7;
        }
        .form-header h2 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #1a1a1a;
        }
        .form-header p {
            font-size: 13px;
            color: #888;
            margin: 2px 0 0;
        }
        .section-title {
            font-size: 11px;
            font-weight: 600;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin: 1.75rem 0 1rem;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .field label {
            font-size: 13px;
            font-weight: 500;
            color: #555;
        }
        .field .form-control {
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 14px;
            color: #1a1a1a;
            background: #fff;
            transition: border-color 0.15s;
            outline: none;
        }
        .field .form-control:focus {
            border-color: #7F77DD;
            box-shadow: 0 0 0 3px rgba(127,119,221,0.12);
        }
        .field textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }
        /* Place buttons */
        .badge-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .place-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            transition: all 0.15s;
        }
        .place-btn:hover {
            background: #f5f4f0;
        }
        .place-btn.active {
            background: #EEEDFE;
            border-color: #AFA9EC;
            color: #3C3489;
        }
        /* Medal buttons */
        .medal-btn {
            padding: 8px 18px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            transition: all 0.15s;
        }
        .medal-btn:hover {
            background: #f5f4f0;
        }
        .medal-btn.gold.active  { background: #FAEEDA; border-color: #FAC775; color: #633806; }
        .medal-btn.silver.active{ background: #F1EFE8; border-color: #B4B2A9; color: #2C2C2A; }
        .medal-btn.bronze.active{ background: #FAECE7; border-color: #F0997B; color: #4A1B0C; }
        /* Hidden inputs for form submission */
        .submit-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 0.5px solid #e5e4e0;
        }
        .btn-cancel {
            padding: 9px 22px;
            border-radius: 8px;
            border: 0.5px solid #d0cfc8;
            background: transparent;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
            text-decoration: none;
        }
        .btn-cancel:hover { background: #f5f4f0; color: #444; }
        .btn-submit {
            padding: 9px 26px;
            border-radius: 8px;
            border: none;
            background: #534AB7;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            transition: background 0.15s;
        }
        .btn-submit:hover { background: #3C3489; }
        @media (max-width: 640px) {
            .grid-2 { grid-template-columns: 1fr; }
            .form-card { padding: 1.25rem; }
        }
    </style>

    <div class="container" style="max-width: 820px;">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">

            {{-- Header --}}
            <div class="form-header">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 21h8M12 17v4M7 4H4a1 1 0 0 0-1 1v2c0 3.3 2.3 6 5.4 6.8M17 4h3a1 1 0 0 1 1 1v2c0 3.3-2.3 6-5.4 6.8M12 13c-2.8 0-5-2.2-5-5V4h10v4c0 2.8-2.2 5-5 5z"/>
                    </svg>
                </div>
                <div>
                    <h2>Yutuqni Tahrirlash</h2>
                    <p>Sportchi natijasini o'zgartirish</p>
                </div>
            </div>

            <form action="{{ route('admin.achievements.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                {{-- Hidden inputs for toggle buttons --}}
                <input type="hidden" name="place" id="place_input" value="">
                <input type="hidden" name="medal" id="medal_input" value="">

                {{-- Section: Basic info --}}
                <p class="section-title">Asosiy ma'lumot</p>

                <div class="grid-2">
                    <div class="field">
                        <label for="athlete_id">Sportchi</label>
                        <select name="athlete_id" id="athlete_id" class="form-control">
                            <option value="">Sportchini tanlang</option>
                            @foreach ($athletes as $athlete)
                                <option @if($achievement->athlete_id == $athlete->id) selected @endif value="{{ $athlete->id }}">{{ $athlete->first_name . ' ' . $athlete->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="competition_id">Musobaqa</label>
                        <select name="competition_id" id="competition_id" class="form-control">
                            <option value="">Musobaqani tanlang</option>
                            @foreach ($competitions as $competition)
                                <option @if($achievement->competition_id == $competition->id) selected @endif value="{{ $competition->id }}">{{ $competition->title_uz }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="season_id">Mavsum</label>
                        <select name="season_id" id="season_id" class="form-control">
                            <option value="">Mavsumni tanlang</option>
                            @foreach ($seasons as $season)
                                <option @if($achievement->season_id == $season->id) selected @endif value="{{ $season->id }}">{{ $season->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="weight_category">Og'irlik kategoriyasi</label>
                        <input type="text" name="weight_category" id="weight_category" value="{{$achievement->weight_category}}" class="form-control" placeholder="Masalan: 73 kg">
                    </div>
                </div>

                {{-- Section: Result --}}
                <p class="section-title">Natija</p>

                {{-- Hidden inputs --}}
                <input type="hidden" name="place" id="place_input" value="{{ $achievement->place }}">
                <input type="hidden" name="medal" id="medal_input" value="{{ $achievement->medal }}">

                {{-- O'rin --}}
                <div class="field" style="margin-bottom: 1.25rem;">
                    <label>O'rin</label>
                    <div class="badge-row">
                        <button type="button" class="place-btn {{ $achievement->place == 1 ? 'active' : '' }}"
                                data-value="1" onclick="selectPlace(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                            1-O'rin
                        </button>
                        <button type="button" class="place-btn {{ $achievement->place == 2 ? 'active' : '' }}"
                                data-value="2" onclick="selectPlace(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                            2-O'rin
                        </button>
                        <button type="button" class="place-btn {{ $achievement->place == 3 ? 'active' : '' }}"
                                data-value="3" onclick="selectPlace(this)">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2l3.1 6.3L22 9.3l-5 4.9 1.2 6.9L12 18l-6.2 3.1L7 14.2 2 9.3l6.9-1z"/>
                            </svg>
                            3-O'rin
                        </button>
                    </div>
                </div>

                {{-- Medal --}}
                <div class="field" style="margin-bottom: 1.25rem;">
                    <label>Medal</label>
                    <div class="badge-row">
                        @foreach ($medals as $key => $medal)
                            <button type="button"
                                    class="medal-btn {{ $achievement->medal == $key ? 'active' : '' }} {{ $key === 'gold' ? 'gold' : ($key === 'silver' ? 'silver' : 'bronze') }}"
                                    data-value="{{ $key }}"
                                    onclick="selectMedal(this)">
                                {{ $medal }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label for="points">Ball (points)</label>
                        <input type="number" name="points" id="points" value="{{$achievement->points}}" class="form-control" placeholder="0">
                    </div>
                </div>

                {{-- Section: Notes --}}
                <p class="section-title">Izoh</p>
                <div class="field">
                    <label for="notes">Qo'shimcha eslatma</label>
                    <textarea name="notes" id="notes" class="form-control tinymce-editor" rows="4"
                              placeholder="Ixtiyoriy izoh...">
                        {{$achievement->notes}}
                    </textarea>
                </div>

                <div class="submit-row">
                    <a href="{{ route('admin.achievements.index') }}" class="btn-cancel">Bekor qilish</a>
                    <button type="submit"  class="btn-submit">Saqlash</button>
                </div>

            </form>
        </div>
    </div>

    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/rbkz9i8rqsas1gz13z0ng7u11p63iuep3dggf71qz0pgdpbd/tinymce/6/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-editor',
            height: 160,
            menubar: false,
            plugins: 'lists link',
            toolbar: 'bold italic underline | bullist numlist | link',
            content_style: 'body { font-family: system-ui, sans-serif; font-size: 14px; }'
        });

        function selectPlace(el) {
            document.querySelectorAll('.place-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('place_input').value = el.dataset.value;
        }

        function selectMedal(el) {
            document.querySelectorAll('.medal-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('medal_input').value = el.dataset.value;
        }
    </script>

@endsection
