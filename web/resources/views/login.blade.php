<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg:            #07101f;
            --bg-card:       #0c1828;
            --bg-input:      #081422;
            --border:        rgba(32, 160, 210, 0.45);
            --border-focus:  #00cfff;
            --cyan:          #1ab8e8;
            --green:         #00e5a0;
            --green-dark:    #07150e;
            --green-glow:    rgba(0, 229, 160, 0.30);
            --cyan-glow:     rgba(0, 207, 255, 0.15);
            --text:          #cce8f5;
            --text-muted:    #3d7a9a;
            --error:         #ff6b6b;
            --error-bg:      rgba(255, 80, 80, 0.08);
            --radius:        12px;
            --transition:    0.22s ease;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg);
            background-image:
                radial-gradient(ellipse 70% 50% at 50% -10%, rgba(0, 140, 210, 0.13) 0%, transparent 65%),
                radial-gradient(ellipse 45% 35% at 90% 90%,  rgba(0, 229, 160, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse 30% 20% at 10% 80%,  rgba(0, 100, 200, 0.06) 0%, transparent 60%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1.5rem;
        }

        /* ── Card ── */
        .card {
            width: 100%;
            max-width: 440px;
            background: var(--bg-card);
            border: 1px solid rgba(32, 160, 210, 0.18);
            border-radius: 20px;
            padding: clamp(2rem, 6vw, 3rem) clamp(1.5rem, 6vw, 2.8rem);
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.5),
                0 8px 32px rgba(0, 0, 0, 0.55),
                0 0 64px rgba(0, 120, 200, 0.08);
            animation: rise 0.45s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }

        /* ── Header ── */
        .card-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-ring {
            width: 56px;
            height: 56px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            border: 2px solid var(--cyan);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px var(--cyan-glow), inset 0 0 12px rgba(0,207,255,0.05);
            animation: pulse-ring 3s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0%, 100% { box-shadow: 0 0 20px var(--cyan-glow); }
            50%       { box-shadow: 0 0 36px rgba(0,207,255,0.30); }
        }

        .logo-ring svg {
            width: 24px;
            height: 24px;
        }

        .card-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: clamp(1.3rem, 4vw, 1.6rem);
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text);
            line-height: 1.2;
        }

        .card-subtitle {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 0.3rem;
            letter-spacing: 0.02em;
        }

        /* ── Divider ── */
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(32,160,210,0.22), transparent);
            margin-bottom: 1.8rem;
        }

        /* ── Alerts ── */
        .alert {
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.83rem;
            line-height: 1.55;
        }

        .alert-error {
            background: var(--error-bg);
            border: 1px solid rgba(255, 80, 80, 0.28);
            color: var(--error);
        }

        .alert ul { padding-left: 1.2rem; }

        /* ── Form groups ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.73rem;
            font-weight: 500;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.45rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            display: flex;
            align-items: center;
            color: var(--cyan);
            transition: color var(--transition);
        }

        .input-icon svg {
            width: 17px;
            height: 17px;
        }

        .form-group:focus-within .input-icon {
            color: var(--border-focus);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            background: var(--bg-input);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.92rem;
            font-weight: 300;
            padding: 0.82rem 1rem 0.82rem 2.8rem;
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
            caret-color: var(--border-focus);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        input::placeholder {
            color: var(--text-muted);
            opacity: 1;
        }

        input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px var(--cyan-glow);
        }

        input.is-invalid {
            border-color: rgba(255, 80, 80, 0.55);
        }

        .field-error {
            color: var(--error);
            font-size: 0.77rem;
            margin-top: 0.4rem;
        }

        /* ── Options ── */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1.5rem;
            margin-bottom: 1.75rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 0.85rem;
            user-select: none;
        }

        .remember input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 17px;
            height: 17px;
            border: 1.5px solid var(--border);
            border-radius: 50%;
            background: transparent;
            cursor: pointer;
            flex-shrink: 0;
            position: relative;
            transition: background var(--transition), border-color var(--transition);
        }

        .remember input[type="checkbox"]:checked {
            background: var(--green);
            border-color: var(--green);
        }

        .remember input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 4px;
            height: 8px;
            border: 2px solid var(--green-dark);
            border-top: none;
            border-left: none;
            transform: rotate(45deg) translateY(-1px);
        }

        .forgot {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-style: italic;
            text-decoration: none;
            transition: color var(--transition);
        }

        .forgot:hover { color: var(--border-focus); }

        /* ── Button ── */
        .btn-login {
            width: 100%;
            padding: 0.9rem 1rem;
            background: var(--green);
            border: none;
            border-radius: var(--radius);
            color: var(--green-dark);
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 4px 24px var(--green-glow);
            transition: background var(--transition), box-shadow var(--transition), transform 0.12s;
        }

        .btn-login:hover {
            background: #00ffb8;
            box-shadow: 0 4px 40px rgba(0, 229, 160, 0.5);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 12px var(--green-glow);
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            body { padding: 1rem; align-items: flex-start; padding-top: 3rem; }
            .card { border-radius: 16px; }
            .options-row { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<div class="card">

    <div class="card-header">
        <div class="logo-ring">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1ab8e8" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L3 7v5c0 5.25 3.75 10.15 9 11.25C17.25 22.15 21 17.25 21 12V7L12 2z"/>
            </svg>
        </div>
        <h1 class="card-title">Acesso ao Sistema</h1>
        <p class="card-subtitle">Faça login para continuar</p>
    </div>

    <div class="divider"></div>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('auth') }}">
        @csrf

        {{-- E-mail --}}
        <div class="form-group">
            <label class="form-label" for="email">Usuário</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <input
                    type="text"
                    id="email"
                    name="email"
                    class="@error('email') is-invalid @enderror"
                    placeholder="seu@email.com"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    autofocus
                    required
                >
            </div>
            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Senha --}}
        <div class="form-group">
            <label class="form-label" for="password">Senha</label>
            <div class="input-wrap">
                <span class="input-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="@error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
            </div>
            @error('password')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Opções --}}
        <div class="options-row">
            <label class="remember">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Lembrar-me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot">Esqueci a senha</a>
            @endif
        </div>

        <button type="submit" class="btn-login">Entrar</button>

    </form>

</div>

</body>
</html>