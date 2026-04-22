@extends('layouts.backend')
@section('title', 'Edit Sport')
@section('admin')

    <script src="https://cdn.tiny.cloud/1/rbkz9i8rqsas1gz13z0ng7u11p63iuep3dggf71qz0pgdpbd/tinymce/6/tinymce.min.js"></script>

    <style>
        .form-card {
            background: #fff;
            border: 0.5px solid #e5e4e0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .form-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 0.5px solid #e5e4e0;
        }
        .form-header-left { display: flex; align-items: center; gap: 12px; }
        .header-icon {
            width: 40px; height: 40px; border-radius: 10px;
            background: #EEEDFE; display: flex; align-items: center;
            justify-content: center; flex-shrink: 0;
        }
        .form-header h2 { font-size: 18px; font-weight: 600; margin: 0; color: #1a1a1a; }
        .form-header p  { font-size: 12px; color: #888; margin: 2px 0 0; }
        .back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; border: 0.5px solid #d0cfc8; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: #666;
            background: transparent; text-decoration: none;
        }
        .back-btn:hover { background: #f5f4f0; color: #444; }

        .form-body { padding: 1.5rem; }

        .section-title {
            font-size: 11px; font-weight: 600; color: #bbb;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin: 1.75rem 0 0.85rem;
        }
        .section-title:first-child { margin-top: 0; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }

        .field { display: flex; flex-direction: column; gap: 5px; }
        .field label { font-size: 12px; font-weight: 500; color: #555; }
        .field .form-control {
            padding: 8px 11px;
            border: 0.5px solid #d0cfc8;
            border-radius: 8px;
            font-size: 13px; color: #1a1a1a; background: #fff;
            outline: none; transition: border-color 0.15s;
        }
        .field .form-control:focus {
            border-color: #7F77DD;
            box-shadow: 0 0 0 3px rgba(127,119,221,0.1);
        }

        .current-img-wrap {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 11px;
            border: 0.5px solid #d0cfc8; border-radius: 8px;
            background: #f8f7f4; margin-bottom: 8px;
        }
        .current-img-wrap img { width: 36px; height: 36px; border-radius: 6px; object-fit: cover; }
        .current-img-wrap span { font-size: 12px; color: #888; }

        /* Status toggle */
        .status-row { display: flex; gap: 8px; }
        .status-opt {
            padding: 7px 18px; border-radius: 8px;
            border: 0.5px solid #d0cfc8; background: transparent;
            cursor: pointer; font-size: 12px; font-weight: 500; color: #666;
            transition: all 0.15s;
        }
        .status-opt.is-active   { background: #EAF3DE; border-color: #97C459; color: #27500A; }
        .status-opt.is-inactive { background: #F1EFE8; border-color: #B4B2A9; color: #5F5E5A; }

        /* Olympic toggle */
        .olympic-opt {
            padding: 7px 18px; border-radius: 8px;
            border: 0.5px solid #d0cfc8; background: transparent;
            cursor: pointer; font-size: 12px; font-weight: 500; color: #666;
            transition: all 0.15s;
        }
        .olympic-opt.is-olympic-yes { background: #EEEDFE; border-color: #AFA9EC; color: #3C3489; }
        .olympic-opt.is-olympic-no  { background: #F1EFE8; border-color: #B4B2A9; color: #5F5E5A; }

        /* Description tabs */
        .desc-tabs-wrap {
            border: 0.5px solid #e5e4e0; border-radius: 10px;
            overflow: hidden; margin-bottom: 1.25rem;
        }
        .desc-tabs { display: flex; border-bottom: 0.5px solid #e5e4e0; background: #f8f7f4; }
        .desc-tab {
            padding: 9px 22px; font-size: 12px; font-weight: 500; color: #888;
            cursor: pointer; border-bottom: 2px solid transparent;
            margin-bottom: -0.5px; transition: color 0.15s;
        }
        .desc-tab.active { color: #534AB7; border-bottom-color: #534AB7; background: #fff; }
        .desc-tab:hover  { color: #534AB7; }
        .desc-area { padding: 1rem; }

        /* Submit */
        .submit-row {
            display: flex; justify-content: flex-end; gap: 10px;
            padding-top: 1.25rem; border-top: 0.5px solid #e5e4e0; margin-top: 0.5rem;
        }
        .btn-cancel {
            padding: 8px 22px; border-radius: 8px;
            border: 0.5px solid #d0cfc8; background: transparent;
            cursor: pointer; font-size: 13px; font-weight: 500; color: #666; text-decoration: none;
        }
        .btn-cancel:hover { background: #f5f4f0; }
        .btn-submit {
            padding: 8px 26px; border-radius: 8px; border: none;
            background: #534AB7; cursor: pointer;
            font-size: 13px; font-weight: 500; color: #fff; transition: background 0.15s;
        }
        .btn-submit:hover { background: #3C3489; }

        @media (max-width: 640px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .form-body { padding: 1.25rem; }
            .form-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>

    <div class="container" style="max-width: 860px; padding-top: 1.5rem;">
        <div class="form-card">

            <div class="form-header">
                <div class="form-header-left">
                    <div class="header-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#534AB7" stroke-width="1.8">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
                        </svg>
                    </div>
                    <div>
                        <h2>Sport tahrirlash</h2>
                        <p>{{ $sport->name_uz }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.sports.index') }}" class="back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Orqaga
                </a>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.sports.update', $sport->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="status"     id="status_val" value="{{ $sport->status }}">
                    <input type="hidden" name="is_olympic" id="olympic_val" value="{{ $sport->is_olympic }}">

                    {{-- Nomlar --}}
                    <p class="section-title">Nomlar</p>
                    <div class="grid-3">
                        <div class="field">
                            <label for="name_uz">Nomi (UZ)</label>
                            <input type="text" class="form-control" id="name_uz" name="name_uz"
                                   value="{{ old('name_uz', $sport->name_uz) }}">
                        </div>
                        <div class="field">
                            <label for="name_en">Nomi (EN)</label>
                            <input type="text" class="form-control" id="name_en" name="name_en"
                                   value="{{ old('name_en', $sport->name_en) }}">
                        </div>
                        <div class="field">
                            <label for="name_ru">Nomi (RU)</label>
                            <input type="text" class="form-control" id="name_ru" name="name_ru"
                                   value="{{ old('name_ru', $sport->name_ru) }}">
                        </div>
                    </div>

                    {{-- Parametrlar --}}
                    <p class="section-title">Parametrlar</p>
                    <div class="grid-2">
                        <div class="field">
                            <label for="order">Tartib raqami</label>
                            <input type="number" class="form-control" id="order" name="order"
                                   value="{{ old('order', $sport->order) }}" placeholder="1">
                        </div>
                        <div class="field">
                            <label for="icon">Ikon</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                   value="{{ old('icon', $sport->icon) }}" placeholder="🏆 yoki matn">
                        </div>
                    </div>
                    <div class="grid-2" style="margin-bottom:1.5rem;">
                        <div class="field">
                            <label for="image">Rasm</label>
                            @if($sport->image)
                                <div class="current-img-wrap">
                                    <img src="{{ asset('images/sports/' . $sport->image) }}" alt="">
                                    <span>Joriy rasm — yangi yuklasangiz almashadi</span>
                                </div>
                            @endif
                            <input type="file" class="form-control" id="image" name="image"
                                   style="padding:6px 11px; background:#f8f7f4; cursor:pointer;">
                        </div>
                    </div>

                    {{-- Status + Olympic --}}
                    <div class="grid-2" style="margin-bottom:1.5rem;">
                        <div>
                            <label style="font-size:12px;font-weight:500;color:#555;display:block;margin-bottom:8px;">Status</label>
                            <div class="status-row">
                                <button type="button" id="btn-active"
                                        class="status-opt {{ $sport->status ? 'is-active' : '' }}"
                                        onclick="setStatus(1)">Aktiv</button>
                                <button type="button" id="btn-inactive"
                                        class="status-opt {{ !$sport->status ? 'is-inactive' : '' }}"
                                        onclick="setStatus(0)">Nofaol</button>
                            </div>
                        </div>
                        <div>
                            <label style="font-size:12px;font-weight:500;color:#555;display:block;margin-bottom:8px;">Olimpik sport</label>
                            <div class="status-row">
                                <button type="button" id="btn-olympic-yes"
                                        class="olympic-opt {{ $sport->is_olympic ? 'is-olympic-yes' : '' }}"
                                        onclick="setOlympic(1)">Ha</button>
                                <button type="button" id="btn-olympic-no"
                                        class="olympic-opt {{ !$sport->is_olympic ? 'is-olympic-no' : '' }}"
                                        onclick="setOlympic(0)">Yo'q</button>
                            </div>
                        </div>
                    </div>

                    {{-- Tavsiflar --}}
                    <p class="section-title">Tavsif</p>
                    <div class="desc-tabs-wrap">
                        <div class="desc-tabs">
                            <div class="desc-tab active" onclick="switchDesc('uz', this)">O'zbek</div>
                            <div class="desc-tab" onclick="switchDesc('en', this)">English</div>
                            <div class="desc-tab" onclick="switchDesc('ru', this)">Русский</div>
                        </div>
                        <div class="desc-area" id="desc-uz">
                            <textarea class="tinymce-editor" id="editor_uz" name="description_uz" rows="5">{{ old('description_uz', $sport->description_uz) }}</textarea>
                        </div>
                        <div class="desc-area" id="desc-en" style="display:none">
                            <textarea class="tinymce-editor" id="editor_en" name="description_en" rows="5">{{ old('description_en', $sport->description_en) }}</textarea>
                        </div>
                        <div class="desc-area" id="desc-ru" style="display:none">
                            <textarea class="tinymce-editor" id="editor_ru" name="description_ru" rows="5">{{ old('description_ru', $sport->description_ru) }}</textarea>
                        </div>
                    </div>

                    <div class="submit-row">
                        <a href="{{ route('admin.sports.index') }}" class="btn-cancel">Bekor qilish</a>
                        <button type="submit" class="btn-submit">Saqlash</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '.tinymce-editor',
            height: 220,
            menubar: false,
            plugins: 'lists link',
            toolbar: 'bold italic underline | bullist numlist | link',
            content_style: 'body { font-family: system-ui, sans-serif; font-size: 14px; }'
        });

        function switchDesc(lang, el) {
            ['uz', 'en', 'ru'].forEach(l => {
                document.getElementById('desc-' + l).style.display = l === lang ? '' : 'none';
            });
            document.querySelectorAll('.desc-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        }

        function setStatus(val) {
            document.getElementById('status_val').value = val;
            document.getElementById('btn-active').className   = 'status-opt' + (val === 1 ? ' is-active' : '');
            document.getElementById('btn-inactive').className = 'status-opt' + (val === 0 ? ' is-inactive' : '');
        }

        function setOlympic(val) {
            document.getElementById('olympic_val').value = val;
            document.getElementById('btn-olympic-yes').className = 'olympic-opt' + (val === 1 ? ' is-olympic-yes' : '');
            document.getElementById('btn-olympic-no').className  = 'olympic-opt' + (val === 0 ? ' is-olympic-no' : '');
        }
    </script>

@endsection
