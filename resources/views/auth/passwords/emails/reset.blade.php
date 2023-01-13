@component('mail::message')
# ¡Hola, {{ $name }}!

Estás recibiendo este correo porque hemos recibido una petición para reestablecer tu contraseña.

@component('mail::button', ['url' => $url])
Reestablecer
@endcomponent

Si no fuiste tú el que hizo esta petición, solo ignora este mensaje.

¡Gracias!

<i>Sistema de Justificaciones, {{ date('Y') }}.</i>
@endcomponent
