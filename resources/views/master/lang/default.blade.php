@if (\Illuminate\Support\Facades\App::getLocale() === 'en')
    <span class="lang-text">English</span>
    <img src="https://flagcdn.com/20x15/gb.png" width="20" height="15" alt="United Kingdom">
@elseif (\Illuminate\Support\Facades\App::getLocale() === 'id')
    <span class="lang-text">Bahasa Indonesia</span>
    <img src="https://flagcdn.com/20x15/id.png" width="20" height="15" alt="Indonesia">
@endif
