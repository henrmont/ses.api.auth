<x-mail::message>
{{-- Header Customizado com Logo e Nome do Eco Saúde --}}
<x-slot:header>
    <x-mail::header :url="config('app.frontend_url')">
        {{-- Você pode trocar o caminho abaixo pela URL da sua logo ou imagem hospedada --}}
        <img src="{{ asset('images/logo_ses.png') }}" alt="Eco Saúde" style="max-height: 50px; margin-bottom: 8px;" onError="this.style.display='none';">
    </x-mail::header>
    <span style="font-size: 20px; font-weight: bold; color: #003366; text-decoration: none;">
        Eco Saúde
    </span>
</x-slot:header>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Olá!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button Customizado (Azul Escuro) --}}
@isset($actionText)
<div style="text-align: center; margin: 30px 0;">
    <a href="{{ $actionUrl }}" target="_blank" style="background-color: #003366; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block; font-size: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        {{ $actionText }}
    </a>
</div>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Atenciosamente,<br>
<strong>Equipe CODEMSI</strong>
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
Se estiver com problemas para clicar no botão "{{ $actionText }}", copie e cole a URL abaixo em seu navegador de internet:

<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>