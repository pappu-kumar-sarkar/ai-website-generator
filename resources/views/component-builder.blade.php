<!DOCTYPE html>
<html>
<head>
    <title>AI Component Builder</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/component.css') }}">
</head>
<body>

<div class="container">
    <h1>🚀 AI Component Website Builder</h1>

    <textarea id="user_prompt" placeholder="Describe your website idea..."></textarea>

    <button onclick="generateProject()">Generate Project</button>
</div>

<div id="result"></div>

<script src="{{ asset('js/component.js') }}"></script>
</body>
</html>