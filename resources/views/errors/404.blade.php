<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Veritas CMS</title>
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
            overflow: hidden;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            animation: fadeIn 0.8s ease-out;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            color: #114629;
            line-height: 1;
            margin-bottom: 0;
            position: relative;
        }
        .error-code::after {
            content: '404';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            color: rgba(17, 70, 41, 0.1);
            z-index: -1;
            transform: translate(10px, 10px);
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
            background-color: #114629;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 70, 41, 0.3);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">Page Not Found</h2>
        <p class="error-desc">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="{{ url('/') }}" class="btn-home">Go Back Home</a>
    </div>
</body>
</html>
