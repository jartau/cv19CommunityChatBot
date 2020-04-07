<html>
<head></head>
<body>
    <h1>{{ __('chatbot.mail_title') }}</h1>
    <p>{{ __('chatbot.mail_into') }}</p>
    <p>{{ __('chatbot.name') }}:<br>{{ $name }}</p>
    <p>{{ __('chatbot.location') }}:<br>{{ $location }}</p>
    <p>{{ __('chatbot.cp') }}:<br>{{ $cp }}</p>
    <p>{{ __('chatbot.address') }}:<br>{{ $address }}</p>
    <p>{{ __('chatbot.mail') }}:<br><a href="mailto:{{ $mail }}">{{ $mail }}</a></p>
    <p>{{ __('chatbot.phone') }}:<br><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
    <p>{{ __('chatbot.entity') }}:<br>{{ $entity }}</p>
    <p>{{ __('chatbot.description') }}:<br>{{ $description }}</p>
    </p>
</body>
</html>