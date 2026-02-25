<!DOCTYPE html>
<html>
<head>
    <title>AI Website Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <h2>AI Website Generator</h2>

    <!-- User Prompt -->
    <textarea id="user_prompt" placeholder="Describe your website idea..."></textarea>

    <!-- Category -->
    <select id="category">
        <option value="">Select Category</option>
        <option value="Handicraft">Handicraft</option>
        <option value="IT Services">IT Services</option>
        <option value="E-commerce">E-commerce</option>
        <option value="Education">Education</option>
        <option value="Restaurant">Restaurant</option>
    </select>

    <!-- Design -->
    <select id="design">
        <option value="">Select Design Style</option>
        <option value="Modern">Modern</option>
        <option value="Elegant">Elegant</option>
        <option value="Minimal">Minimal</option>
        <option value="Dark">Dark</option>
        <option value="Vintage">Vintage</option>
    </select>

    <button onclick="generateWebsite()">Generate Website</button>
</div>

<div id="result"></div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>