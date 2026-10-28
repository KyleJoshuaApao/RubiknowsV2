{{-- Error pages stay self-contained: no database, no build assets. --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title') | RUBIKNOWS</title>
    <link rel="icon" type="image/webp" href="/RK4.webp">
    <style>
        :root { --ink: #111111; --muted: #5a5a5a; --line: #e5e5e5; --paper: #f5f5f5; --gold: #e0a92a; --gold-dark: #b8860b; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; flex-direction: column; background: var(--paper); color: var(--ink); font: 400 1.0625rem/1.6 system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif; }
        header { padding: 1.25rem clamp(1rem, 5vw, 3rem); border-bottom: 1px solid var(--line); background: #fff; }
        header a { display: inline-flex; align-items: center; gap: .6rem; color: var(--ink); text-decoration: none; font-weight: 700; letter-spacing: .02em; }
        .wordmark { display: inline-flex; align-items: baseline; font-family: Inter, ui-sans-serif, system-ui, 'Segoe UI', Arial, sans-serif; font-size: 1.6rem; letter-spacing: -.05em; }
        .wordmark__rubi { font-weight: 400; color: #000; }
        .wordmark__knows { font-weight: 900; color: var(--gold); margin-left: 2px; letter-spacing: .05em; }
        header img { width: 2.25rem; height: 2.25rem; object-fit: contain; }
        main { flex: 1; display: flex; align-items: center; padding: 3rem clamp(1rem, 5vw, 3rem); }
        .box { max-width: 36rem; }
        .code { margin: 0 0 .75rem; color: var(--gold-dark); font-weight: 700; font-size: .875rem; letter-spacing: .08em; text-transform: uppercase; }
        h1 { margin: 0 0 1rem; font-size: clamp(1.75rem, 4vw, 2.5rem); line-height: 1.15; }
        p { margin: 0 0 1.5rem; color: var(--muted); }
        .actions { display: flex; flex-wrap: wrap; gap: .75rem; }
        .btn { display: inline-flex; align-items: center; padding: .75rem 1.15rem; border-radius: 4px; border: 1px solid var(--ink); color: var(--ink); text-decoration: none; font-weight: 600; }
        .btn--primary { background: var(--gold); border-color: var(--gold); }
        .btn:focus-visible { outline: 3px solid var(--gold); outline-offset: 2px; }
        footer { padding: 1.25rem clamp(1rem, 5vw, 3rem); color: var(--muted); font-size: .875rem; }
    </style>
</head>
<body>
    <header>
        <a href="/" aria-label="RUBIKNOWS home"><img src="/RK4.webp" alt=""><span class="wordmark"><span class="wordmark__rubi">RUBI</span><span class="wordmark__knows">KNOWS</span></span></a>
    </header>
    <main>
        <div class="box">
            <p class="code">Error @yield('code')</p>
            <h1>@yield('heading')</h1>
            <p>@yield('message')</p>
            <div class="actions">
                <a class="btn btn--primary" href="/">Go to the home page</a>
                <a class="btn" href="/contact">Contact us</a>
            </div>
        </div>
    </main>
    <footer>RUBIKNOWS Engineering and Construction, Tagum City, Davao del Norte</footer>
</body>
</html>
