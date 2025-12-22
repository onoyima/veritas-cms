<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error | Veritas CMS</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            animation: shake 0.5s ease-in-out;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 0;
        }
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .error-desc {
            color: #666;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-home {
            display: inline-block;
            background-color: #333;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }
        .btn-home:hover {
            opacity: 0.9;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">500</h1>
        <h2 class="error-title">Internal Server Error</h2>
        <p class="error-desc">Something went wrong on our end. We're working on fixing it. Please try again later.</p>
        <a href="{{ url('/') }}" class="btn-home">Go Back Home</a>
    </div>
</body>
</html>
