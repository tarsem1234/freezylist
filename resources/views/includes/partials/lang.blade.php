<ul class="dropdown-menu" role="menu">
        @foreach (array_keys(config('locale.languages')) as $lang)
                @if ($lang != App::getLocale())
                        <li>{{ html()->a(url('lang/' . $lang), trans('menus.language-picker.langs.' . $lang)) }}</li>
                @endif
        @endforeach
</ul>