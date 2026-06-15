<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIND — <?= $titulo ?? 'Painel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mind-primary: #009cb9;
            --mind-light:   #8fd1d4;
            --mind-bg:      #f0f7f8;
            --mind-text:    #1a2e35;
            --mind-muted:   #6c8a90;
            --mind-border:  #d6eef0;
            --mind-danger:  #e53e3e;
        }

        body {
            background: var(--mind-bg);
            color: var(--mind-text);
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }

        .mind-header {
            background: #fff;
            border-bottom: 1px solid var(--mind-border);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .mind-header .logo {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--mind-primary);
            text-decoration: none;
        }

        .nav-link-mind {
            color: var(--mind-muted);
            text-decoration: none;
            font-size: 0.85rem;
            padding: 6px 4px;
            border-bottom: 2px solid transparent;
            transition: all 0.15s;
        }

        .nav-link-mind:hover,
        .nav-link-mind.active {
            color: var(--mind-primary);
            border-bottom-color: var(--mind-primary);
        }

        .mind-header .user-info {
            font-size: 0.85rem;
            color: var(--mind-muted);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mind-header .user-info strong { color: var(--mind-text); }

        .mind-header .user-info a {
            color: var(--mind-danger);
            text-decoration: none;
            font-size: 0.8rem;
        }

        .mind-main {
            max-width: 720px;
            margin: 0 auto;
            padding: 32px 16px;
        }

        /* Cards de ação */
        .action-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--mind-border);
            padding: 20px;
            text-decoration: none;
            color: var(--mind-text);
            display: block;
            transition: all 0.2s;
        }

        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,156,185,0.12);
            border-color: var(--mind-light);
            color: var(--mind-text);
        }

        .action-card .card-icon {
            font-size: 1.8rem;
            margin-bottom: 8px;
        }

        .action-card .card-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .action-card .card-desc {
            font-size: 0.8rem;
            color: var(--mind-muted);
        }

        /* Botão de pânico no painel */
        .panic-card {
            background: #fff5f5;
            border: 1.5px solid #fed7d7;
            border-radius: 14px;
            padding: 20px;
            text-decoration: none;
            display: block;
            transition: all 0.2s;
        }

        .panic-card:hover {
            background: #fee2e2;
            transform: translateY(-2px);
        }

        .panic-card .card-icon { color: var(--mind-danger); font-size: 1.8rem; }
        .panic-card .card-title { color: var(--mind-danger); font-weight: 700; }
        .panic-card .card-desc { color: #c53030; font-size: 0.8rem; }

        /* Botões primários */
        .btn-mind {
            background: var(--mind-primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px 28px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-mind:hover { background: #007fa0; color: #fff; }

        /* Inputs e textareas */
        .mind-input, .mind-textarea {
            border: 1.5px solid var(--mind-border);
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 0.9rem;
            color: var(--mind-text);
            width: 100%;
            transition: border-color 0.15s;
            background: #fff;
        }

        .mind-input:focus, .mind-textarea:focus {
            outline: none;
            border-color: var(--mind-primary);
            box-shadow: 0 0 0 3px rgba(0,156,185,0.1);
        }

        .mind-textarea { resize: vertical; min-height: 100px; }

        /* Cartão de conteúdo */
        .mind-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--mind-border);
            padding: 28px;
        }

        /* Flash messages */
        .flash-msg {
            border-radius: 10px;
            font-size: 0.88rem;
            padding: 12px 16px;
        }

        /* Label de seção */
        .section-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--mind-muted);
            font-weight: 600;
            margin-bottom: 6px;
        }

        /*Bottom nav fixo para mobile: */
        @media (max-width: 767px) {
            body { padding-bottom: 64px; }
            .mobile-tabbar {
                position: fixed; bottom: 0; left: 0; right: 0;
                background: #fff; border-top: 1px solid var(--mind-border);
                display: flex; justify-content: space-around;
                padding: 8px 0; z-index: 200;
            }
            .mobile-tabbar a {
                color: var(--mind-muted); text-decoration: none;
                font-size: 0.68rem; text-align: center;
                display: flex; flex-direction: column; align-items: center; gap: 2px;
            }
            .mobile-tabbar a i { font-size: 1.2rem; }
            .mobile-tabbar a.active { color: var(--mind-primary); }
        }
    </style>
</head>
<body>

<header class="mind-header">
    <a href="/painel" class="logo">MIND</a>

    <nav class="d-none d-md-flex gap-3">
        <a href="/painel" class="nav-link-mind <?= current_url(true)->getPath() === 'painel' ? 'active' : '' ?>">
            <i class="bi bi-house"></i> Painel
        </a>
        <a href="/humor" class="nav-link-mind <?= current_url(true)->getPath() === 'humor' ? 'active' : '' ?>">
            <i class="bi bi-emoji-smile"></i> Humor
        </a>
        <a href="/alimentacao" class="nav-link-mind <?= current_url(true)->getPath() === 'alimentacao' ? 'active' : '' ?>">
            <i class="bi bi-egg-fried"></i> Alimentação
        </a>
        <a href="/diario" class="nav-link-mind <?= current_url(true)->getPath() === 'diario' ? 'active' : '' ?>">
            <i class="bi bi-journal-text"></i> Diário
        </a>
    </nav>

    <div class="user-info">
        <span>Olá, <strong><?= esc(session()->get('usuario_nome')) ?></strong></span>
        <a href="/logout"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>
</header>

<main class="mind-main">

    <?php if (session()->getFlashdata('sucesso')): ?>
        <div class="alert flash-msg alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('sucesso') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erro')): ?>
        <div class="alert flash-msg alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('erro') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('conteudo') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            bootstrap.Alert.getOrCreateInstance(a).close();
        });
    }, 4000);
</script>

<nav class="mobile-tabbar d-md-none">
    <a href="/painel" class="<?= current_url(true)->getPath() === 'painel' ? 'active' : '' ?>">
        <i class="bi bi-house"></i> Painel
    </a>
    <a href="/humor" class="<?= current_url(true)->getPath() === 'humor' ? 'active' : '' ?>">
        <i class="bi bi-emoji-smile"></i> Humor
    </a>
    <a href="/alimentacao" class="<?= current_url(true)->getPath() === 'alimentacao' ? 'active' : '' ?>">
        <i class="bi bi-egg-fried"></i> Alimentação
    </a>
    <a href="/diario" class="<?= current_url(true)->getPath() === 'diario' ? 'active' : '' ?>">
        <i class="bi bi-journal-text"></i> Diário
    </a>
    <a href="/panico" class="<?= current_url(true)->getPath() === 'panico' ? 'active' : '' ?>" style="color:#e53e3e;">
        <i class="bi bi-exclamation-triangle"></i> Ajuda
    </a>
</nav>

</body>
</html>