<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIND — <?= $titulo ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --mind-primary:   #009cb9;
            --mind-light:     #8fd1d4;
            --mind-bg:        #f0f7f8;
            --mind-sidebar:   #ffffff;
            --mind-text:      #1a2e35;
            --mind-muted:     #6c8a90;
            --mind-border:    #d6eef0;
            --mind-danger:    #e53e3e;
        }

        body {
            background: var(--mind-bg);
            color: var(--mind-text);
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        /* Sidebar */
        .mind-sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--mind-sidebar);
            border-right: 1px solid var(--mind-border);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            padding: 0;
            z-index: 100;
        }

        .mind-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid var(--mind-border);
        }

        .mind-logo h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--mind-primary);
            margin: 0;
            letter-spacing: -0.5px;
        }

        .mind-logo span {
            font-size: 0.72rem;
            color: var(--mind-muted);
            display: block;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .mind-nav {
            padding: 16px 0;
            flex: 1;
        }

        .mind-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: var(--mind-text);
            text-decoration: none;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }

        .mind-nav a:hover,
        .mind-nav a.active {
            background: var(--mind-bg);
            color: var(--mind-primary);
            border-left-color: var(--mind-primary);
        }

        .mind-nav a i { font-size: 1rem; }

        .mind-user-area {
            padding: 16px 20px;
            border-top: 1px solid var(--mind-border);
            font-size: 0.82rem;
            color: var(--mind-muted);
        }

        .mind-user-area strong {
            display: block;
            color: var(--mind-text);
            font-size: 0.88rem;
            margin-bottom: 2px;
        }

        .mind-user-area a {
            color: var(--mind-danger);
            text-decoration: none;
            font-size: 0.8rem;
        }

        /* Conteúdo principal */
        .mind-content {
            margin-left: 240px;
            padding: 32px;
            min-height: 100vh;
        }

        /* Cards de métricas */
        .metric-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            border: 1px solid var(--mind-border);
            border-left: 4px solid var(--mind-primary);
        }

        .metric-card.danger { border-left-color: var(--mind-danger); }

        .metric-card .metric-num {
            font-size: 2rem;
            font-weight: 700;
            color: var(--mind-primary);
            line-height: 1;
        }

        .metric-card.danger .metric-num { color: var(--mind-danger); }

        .metric-card .metric-label {
            font-size: 0.82rem;
            color: var(--mind-muted);
            margin-top: 4px;
        }

        .metric-card .metric-icon {
            font-size: 1.8rem;
            color: var(--mind-light);
        }

        /* Tabelas */
        .mind-table {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--mind-border);
            overflow: hidden;
        }

        .mind-table .table { margin: 0; }

        .mind-table .table thead th {
            background: var(--mind-bg);
            color: var(--mind-muted);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            border-bottom: 1px solid var(--mind-border);
            padding: 12px 16px;
        }

        .mind-table .table tbody td {
            padding: 12px 16px;
            font-size: 0.88rem;
            border-bottom: 1px solid var(--mind-border);
            vertical-align: middle;
        }

        .mind-table .table tbody tr:last-child td { border-bottom: none; }

        /* Badges */
        .badge-panico {
            background: #fff5f5;
            color: var(--mind-danger);
            border: 1px solid #fed7d7;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-novo {
            background: var(--mind-danger);
            color: #fff;
            font-size: 0.7rem;
            padding: 2px 7px;
            border-radius: 20px;
        }

        /* Seção */
        .section-title {
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--mind-muted);
            font-weight: 600;
            margin-bottom: 12px;
        }

        /* Flash messages */
        .flash-msg {
            border-radius: 10px;
            font-size: 0.88rem;
            padding: 12px 16px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .mind-sidebar { transform: translateX(-100%); }
            .mind-content { margin-left: 0; padding: 16px; }
        }
    </style>
</head>
<body>

<aside class="mind-sidebar">
    <div class="mind-logo">
        <h1>MIND</h1>
        <span>Saúde Mental</span>
    </div>
    <nav class="mind-nav">
        <a href="/dashboard" class="<?= (current_url(true)->getPath() === '/dashboard') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
    </nav>
    <div class="mind-user-area">
        <strong><?= esc(session()->get('usuario_nome')) ?></strong>
        Profissional
        <br>
        <a href="/logout"><i class="bi bi-box-arrow-right"></i> Sair</a>
    </div>
</aside>

<main class="mind-content">

    <?php if (session()->getFlashdata('sucesso')): ?>
        <div class="alert flash-msg alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('sucesso') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erro')): ?>
        <div class="alert flash-msg alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('erro') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('conteudo') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
<script>
    // Auto-dismiss flash messages
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            let bsAlert = bootstrap.Alert.getOrCreateInstance(a);
            bsAlert.close();
        });
    }, 4000);
</script>
</body>
</html>