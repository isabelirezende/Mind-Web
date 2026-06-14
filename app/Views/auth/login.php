<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIND — Entrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mind-primary: #009cb9;
            --mind-light:   #8fd1d4;
            --mind-bg:      #f0f7f8;
            --mind-border:  #d6eef0;
            --mind-text:    #1a2e35;
            --mind-muted:   #6c8a90;
        }

        body {
            background: var(--mind-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
            padding: 16px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .login-logo h1 {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--mind-primary);
            letter-spacing: -1px;
            margin: 0;
        }

        .login-logo p {
            color: var(--mind-muted);
            font-size: 0.88rem;
            margin-top: 4px;
        }

        .login-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--mind-border);
            padding: 32px;
        }

        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--mind-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1.5px solid var(--mind-border);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.9rem;
            color: var(--mind-text);
        }

        .form-control:focus {
            border-color: var(--mind-primary);
            box-shadow: 0 0 0 3px rgba(0,156,185,0.1);
        }

        .btn-entrar {
            background: var(--mind-primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 0.95rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 8px;
        }

        .btn-entrar:hover { background: #007fa0; }

        .alert {
            border-radius: 10px;
            font-size: 0.88rem;
        }

        .login-hint {
            background: var(--mind-bg);
            border-radius: 10px;
            padding: 12px;
            font-size: 0.78rem;
            color: var(--mind-muted);
            margin-top: 20px;
            border: 1px solid var(--mind-border);
        }

        .login-hint strong { color: var(--mind-text); }
    </style>
</head>
<body>

<div class="login-wrap">
    <div class="login-logo">
        <h1>MIND</h1>
        <p>Acompanhamento psicológico e psiquiátrico</p>
    </div>

    <div class="login-card">
        <h2 style="font-size:1.1rem; font-weight:600; margin-bottom:20px; color:var(--mind-text);">
            Entrar na sua conta
        </h2>

        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-danger py-2 mb-3">
                <i class="bi bi-exclamation-circle me-1"></i>
                <?= session()->getFlashdata('erro') ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control"
                    placeholder="seu@email.com"
                    value="<?= old('email') ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <div class="position-relative">
                    <input type="password" name="senha" id="senhaInput"
                        class="form-control" placeholder="••••••••" required>
                    <button type="button" onclick="toggleSenha()"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--mind-muted);cursor:pointer;padding:0;">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-entrar">
                <i class="bi bi-arrow-right-circle me-1"></i> Entrar
            </button>
        </form>

        <!-- Dicas de teste para apresentação -->
        <div class="login-hint">
            <strong>Contas de demonstração:</strong><br>
            👩‍⚕️ jennifer@mind.com &nbsp;·&nbsp; 🧑 vinicius@mind.com<br>
            Senha: <strong>password</strong>
        </div>
    </div>
</div>

<script>
function toggleSenha() {
    const input = document.getElementById('senhaInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>

</body>
</html>