<p><strong>Nuova richiesta dal sito RingAnnouncer</strong></p>

<p><strong>Nome:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
@if(filled($data['phone'] ?? null))
<p><strong>Telefono:</strong> {{ $data['phone'] }}</p>
@endif
@if(filled($data['event_type'] ?? null))
<p><strong>Tipo evento:</strong> {{ $data['event_type'] }}</p>
@endif

<p><strong>Messaggio:</strong></p>
<p>{!! nl2br(e($data['message'])) !!}</p>