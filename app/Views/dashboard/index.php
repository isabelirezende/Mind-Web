<?= $this->extend('layouts/base_profissional') ?>
<?= $this->section('conteudo') ?>

<?php
$emojiHumor = [
    'excelente' => ['emoji' => '😀', 'cor' => '#276749'],
    'bom'       => ['emoji' => '🙂', 'cor' => '#009cb9'],
    'neutro'    => ['emoji' => '😐', 'cor' => '#6c8a90'],
    'ruim'      => ['emoji' => '🙁', 'cor' => '#c05621'],
    'pessimo'   => ['emoji' => '😢', 'cor' => '#e53e3e'],
];
?>

<!-- ===================== HEADER DA PÁGINA ===================== -->
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.4rem;font-weight:700;margin:0;">
            Bom dia, <?= esc(explode(' ', session()->get('usuario_nome'))[0]) ?> 👋
        </h1>
        <p style="color:var(--mind-muted);font-size:0.82rem;margin-top:3px;">
            <?= date('d \d\e m \d\e Y') ?>
        </p>
    </div>
    <!-- Atalhos rápidos -->
    <div class="d-flex gap-2 flex-wrap">
        <a href="#secao-alertas" class="btn-atalho <?= $totalAlertas > 0 ? 'btn-atalho-danger' : '' ?>">
            <i class="bi bi-bell"></i>
            Alertas
            <?php if ($totalAlertas > 0): ?>
                <span class="badge-count"><?= $totalAlertas ?></span>
            <?php endif; ?>
        </a>
        <a href="#secao-pacientes" class="btn-atalho">
            <i class="bi bi-people"></i> Pacientes
        </a>
        <a href="#secao-humor" class="btn-atalho">
            <i class="bi bi-emoji-smile"></i> Registros
        </a>
    </div>
</div>

<?php if ($totalAlertas > 0): ?>
<div class="alerta-dashboard mb-4">
    <i class="bi bi-exclamation-triangle-fill"></i>

    <div>
        <strong>Atenção!</strong><br>
        Existem <?= $totalAlertas ?> alerta(s) pendente(s) de visualização.
    </div>

    <a href="#secao-alertas">
        Ver alertas
    </a>
</div>
<?php endif; ?>

<!-- ===================== CARDS DE MÉTRICAS ===================== -->
<div class="row g-3 mb-4">

    <!-- Card Pacientes — clicável -->
    <div class="col-6 col-md-3">
        <a href="#secao-pacientes" class="metric-card-link">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="metric-num"><?= $totalPacientes ?></div>
                        <div class="metric-label">Pacientes</div>
                    </div>
                    <i class="bi bi-people metric-icon"></i>
                </div>
                <div class="metric-footer">Ver pacientes →</div>
            </div>
        </a>
    </div>

    <!-- Card Alertas novos — clicável, vermelho se tiver alertas -->
    <div class="col-6 col-md-3">
        <a href="#secao-alertas" class="metric-card-link">
            <div class="metric-card <?= $totalAlertas > 0 ? 'danger' : '' ?>">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="metric-num"><?= $totalAlertas ?></div>
                        <div class="metric-label">Alertas novos</div>
                    </div>
                    <i class="bi bi-exclamation-triangle metric-icon" style="<?= $totalAlertas > 0 ? 'color:#fed7d7' : '' ?>"></i>
                </div>
                <div class="metric-footer <?= $totalAlertas > 0 ? 'danger' : '' ?>">
                    <?= $totalAlertas > 0 ? 'Ver alertas →' : 'Sem alertas novos ✓' ?>
                </div>
            </div>
        </a>
    </div>

    <!-- Card Registros hoje -->
    <div class="col-6 col-md-3">
        <a href="#secao-humor" class="metric-card-link">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="metric-num"><?= count($humoresRecentes) ?></div>
                        <div class="metric-label">Últimos registros</div>
                    </div>
                    <i class="bi bi-journal-text metric-icon"></i>
                </div>
                <div class="metric-footer">Ver registros →</div>
            </div>
        </a>
    </div>

    <!-- Card Humor Médio -->
    <div class="col-6 col-md-3">
        <a href="#secao-humor" class="metric-card-link">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="metric-num">
                            <?= $humorMedio ?>
                        </div>

                        <div class="metric-label">
                            Humor médio
                        </div>
                    </div>

                    <i class="bi bi-graph-up metric-icon"></i>
                </div>

                <div class="metric-footer">
                    Média geral dos pacientes
                </div>
            </div>
        </a>
    </div>

    <!-- Card Em acompanhamento -->
    <div class="col-6 col-md-3">
        <a href="#secao-pacientes" class="metric-card-link">
            <div class="metric-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="metric-num"><?= $totalPacientes ?></div>
                        <div class="metric-label">Em acompanhamento</div>
                    </div>
                    <i class="bi bi-heart-pulse metric-icon"></i>
                </div>
                <div class="metric-footer">Ver lista →</div>
            </div>
        </a>
    </div>

</div>

<!-- ===================== GRÁFICO GERAL ===================== -->
<?php if (count($dadosGrafico['valores']) >= 2): ?>
<div class="mind-section mb-4">
    <div class="mind-section-header">
        <span><i class="bi bi-graph-up me-2"></i>Evolução geral de humor — últimos 14 dias</span>
        <span style="font-size:0.78rem;color:var(--mind-muted);">Média de todos os pacientes</span>
    </div>
    <div class="mind-section-body" style="padding:16px 20px 20px;">
        <!-- container com altura fixa — evita gráfico enorme -->
        <div style="position:relative;height:200px;width:100%;">
            <canvas id="graficoGeral"></canvas>
        </div>
    </div>
</div>
<?php else: ?>
<div class="mind-section mb-4">
    <div class="mind-section-header">
        <span><i class="bi bi-graph-up me-2"></i>Evolução geral de humor</span>
    </div>
    <div class="mind-section-body p-4 text-center" style="color:var(--mind-muted);font-size:0.88rem;">
        <i class="bi bi-bar-chart" style="font-size:1.8rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
        O gráfico aparece após os pacientes fazerem pelo menos 2 registros de humor.
    </div>
</div>
<?php endif; ?>

<!-- ===================== ALERTAS DE PÂNICO ===================== -->
<div class="mind-section mb-4" id="secao-alertas">
    <div class="mind-section-header">
        <span>
            <i class="bi bi-bell me-2"></i>Alertas de pânico
            <?php if ($totalAlertas > 0): ?>
                <span class="badge-count ms-2" style="background:#e53e3e;"><?= $totalAlertas ?></span>
            <?php endif; ?>
        </span>
    </div>

    <?php if (empty($alertasRecentes)): ?>
        <div class="mind-section-body p-4 text-center" style="color:var(--mind-muted);font-size:0.88rem;">
            <i class="bi bi-check-circle" style="font-size:1.8rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
            Nenhum alerta registrado. Tudo tranquilo por aqui.
        </div>
    <?php else: ?>
        <div class="mind-section-body" style="padding:0;">
            <table class="mind-table-inner">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Data e hora</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alertasRecentes as $alerta): ?>
                    <tr>
                        <td>
                            <a href="/dashboard/paciente/<?= $alerta['usuario_id'] ?>"
                               style="font-weight:500;color:var(--mind-text);text-decoration:none;">
                                <?= esc($alerta['paciente_nome']) ?>
                                <i class="bi bi-arrow-up-right" style="font-size:0.7rem;color:var(--mind-primary);"></i>
                            </a>
                        </td>
                        <td style="color:var(--mind-muted);">
                            <?= date('d/m/Y H:i', strtotime($alerta['criado_em'])) ?>
                        </td>
                        <td>
                            <?php if ($alerta['visualizado']): ?>
                                <span class="badge-status ok">Visto</span>
                            <?php else: ?>
                                <span class="badge-status novo">Novo</span>
                                <span class="badge-status panico ms-1">Pânico</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (! $alerta['visualizado']): ?>
                                <a href="/alertas/ver/<?= $alerta['id'] ?>"
                                   class="link-acao">
                                    Marcar como visto
                                </a>
                            <?php else: ?>
                                <span style="font-size:0.82rem;color:var(--mind-muted);">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- ===================== REGISTROS DE HUMOR RECENTES ===================== -->
<div class="mind-section mb-4" id="secao-humor">
    <div class="mind-section-header">
        <span><i class="bi bi-emoji-smile me-2"></i>Registros de humor recentes</span>
    </div>

    <?php if (empty($humoresRecentes)): ?>
        <div class="mind-section-body p-4 text-center" style="color:var(--mind-muted);font-size:0.88rem;">
            <i class="bi bi-journal" style="font-size:1.8rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
            Nenhum registro de humor ainda.
        </div>
    <?php else: ?>
        <div class="mind-section-body" style="padding:0;">
            <table class="mind-table-inner">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Humor</th>
                        <th>Observação</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($humoresRecentes as $h): ?>
                    <?php $info = $emojiHumor[$h['nivel']] ?? $emojiHumor['neutro']; ?>
                    <tr>
                        <td>
                            <a href="/dashboard/paciente/<?= $h['usuario_id'] ?>"
                               style="font-weight:500;color:var(--mind-text);text-decoration:none;">
                                <?= esc($h['paciente_nome']) ?>
                                <i class="bi bi-arrow-up-right" style="font-size:0.7rem;color:var(--mind-primary);"></i>
                            </a>
                        </td>
                        <td>
                            <span style="color:<?= $info['cor'] ?>;font-weight:500;">
                                <?= $info['emoji'] ?> <?= ucfirst($h['nivel']) ?>
                            </span>
                        </td>
                        <td style="color:var(--mind-muted);font-size:0.84rem;">
                            <?= $h['observacao'] ? esc(mb_strimwidth($h['observacao'], 0, 60, '…')) : '—' ?>
                        </td>
                        <td style="color:var(--mind-muted);font-size:0.82rem;">
                            <?= date('d/m H:i', strtotime($h['criado_em'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- ===================== LISTA DE PACIENTES ===================== -->
<div class="mind-section mb-4" id="secao-pacientes">
    <div class="mind-section-header">
        <span><i class="bi bi-people me-2"></i>Pacientes em acompanhamento</span>
        <span style="font-size:0.78rem;color:var(--mind-muted);"><?= count($pacientes) ?> cadastrado(s)</span>
    </div>

    <?php if (empty($pacientes)): ?>
        <div class="mind-section-body p-4 text-center" style="color:var(--mind-muted);font-size:0.88rem;">
            <i class="bi bi-person-plus" style="font-size:1.8rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
            Nenhum paciente cadastrado ainda.
        </div>
    <?php else: ?>
        <div class="mind-section-body" style="padding:0;">
            <table class="mind-table-inner">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cadastro</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $p): ?>
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="avatar-circle">
                                    <?= mb_strtoupper(mb_substr($p['nome'], 0, 1)) ?>
                                </div>
                                <span style="font-weight:500;"><?= esc($p['nome']) ?></span>
                            </div>
                        </td>
                        <td style="color:var(--mind-muted);"><?= esc($p['email']) ?></td>
                        <td style="color:var(--mind-muted);"><?= date('d/m/Y', strtotime($p['criado_em'])) ?></td>
                        <td>
                            <a href="/dashboard/paciente/<?= $p['id'] ?>" class="link-acao">
                                Ver histórico →
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- ===================== ESTILOS ESPECÍFICOS DA VIEW ===================== -->
<style>
/* Cards de métricas — agora são links */
.metric-card-link {
    text-decoration: none;
    display: block;
}
.metric-card-link:hover .metric-card {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,156,185,0.12);
    border-color: var(--mind-light);
}
.metric-card {
    transition: all 0.18s;
    cursor: pointer;
}
.metric-footer {
    font-size: 0.72rem;
    color: var(--mind-primary);
    margin-top: 10px;
    font-weight: 500;
    letter-spacing: 0.2px;
}
.metric-footer.danger {
    color: var(--mind-danger);
}

/* Botões de atalho no header */
.btn-atalho {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff;
    border: 1px solid var(--mind-border);
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 0.82rem;
    color: var(--mind-text);
    text-decoration: none;
    transition: all 0.15s;
    font-weight: 500;
}
.btn-atalho:hover {
    border-color: var(--mind-primary);
    color: var(--mind-primary);
    background: #f0f9fb;
}
.btn-atalho-danger {
    border-color: #fed7d7;
    background: #fff5f5;
    color: var(--mind-danger);
}
.btn-atalho-danger:hover {
    background: #fee2e2;
    color: var(--mind-danger);
}

/* Badge de contagem */
.badge-count {
    background: var(--mind-danger);
    color: #fff;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 20px;
    line-height: 1;
}

/* Seções com header padronizado */
.mind-section {
    background: #fff;
    border: 1px solid var(--mind-border);
    border-radius: 12px;
    overflow: hidden;
}
.mind-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid var(--mind-border);
    background: var(--mind-bg);
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--mind-muted);
    font-weight: 600;
}
.mind-section-body {
    padding: 16px 20px;
}

/* Tabela interna das seções */
.mind-table-inner {
    width: 100%;
    border-collapse: collapse;
}
.mind-table-inner thead th {
    background: var(--mind-bg);
    color: var(--mind-muted);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    padding: 10px 20px;
    border-bottom: 1px solid var(--mind-border);
    white-space: nowrap;
}
.mind-table-inner tbody td {
    padding: 11px 20px;
    font-size: 0.86rem;
    border-bottom: 1px solid var(--mind-border);
    vertical-align: middle;
}
.mind-table-inner tbody tr:last-child td {
    border-bottom: none;
}
.mind-table-inner tbody tr:hover td {
    background: #f8fcfd;
}

/* Badges de status */
.badge-status {
    font-size: 0.72rem;
    padding: 3px 8px;
    border-radius: 20px;
    font-weight: 500;
}
.badge-status.ok {
    background: #f0fff4;
    color: #276749;
    border: 1px solid #c6f6d5;
}
.badge-status.novo {
    background: var(--mind-danger);
    color: #fff;
}
.badge-status.panico {
    background: #fff5f5;
    color: var(--mind-danger);
    border: 1px solid #fed7d7;
}

/* Link de ação em tabela */
.link-acao {
    font-size: 0.82rem;
    color: var(--mind-primary);
    text-decoration: none;
    font-weight: 500;
    white-space: nowrap;
}
.link-acao:hover {
    text-decoration: underline;
}

/* Avatar círculo */
.avatar-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: var(--mind-bg);
    border: 1.5px solid var(--mind-border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--mind-primary);
    flex-shrink: 0;
}

/*Style ds alertas*/
.alerta-dashboard {
    background: #fff5f5;
    border: 1px solid #fed7d7;
    border-left: 5px solid #e53e3e;
    border-radius: 10px;
    padding: 14px 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.alerta-dashboard i {
    font-size: 1.4rem;
    color: #e53e3e;
}

.alerta-dashboard strong {
    color: #c53030;
}

.alerta-dashboard a {
    color: #e53e3e;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}

.alerta-dashboard a:hover {
    text-decoration: underline;
}

/* Scroll suave nas âncoras */
html { scroll-behavior: smooth; }

/* Responsividade da tabela em mobile */
@media (max-width: 640px) {
    .mind-table-inner thead th:nth-child(3),
    .mind-table-inner tbody td:nth-child(3) {
        display: none;
    }
    .btn-atalho span { display: none; }
    .mind-section-header { font-size: 0.72rem; }
}
</style>

<!-- ===================== SCRIPTS (GRÁFICO) ===================== -->
<?php if (count($dadosGrafico['valores']) >= 2): ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('graficoGeral'), {
    type: 'line',
    data: {
        labels: <?= json_encode($dadosGrafico['labels']) ?>,
        datasets: [{
            label: 'Média de humor',
            data: <?= json_encode($dadosGrafico['valores']) ?>,
            borderColor: '#009cb9',
            backgroundColor: 'rgba(0,156,185,0.07)',
            borderWidth: 2.5,
            tension: 0.38,
            fill: true,
            pointBackgroundColor: '#009cb9',
            pointRadius: 4,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, /* CRÍTICO: junto com o div de altura fixa, isso corrige o bug */
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        const map = {1:'Péssimo 😢',2:'Ruim 🙁',3:'Neutro 😐',4:'Bom 🙂',5:'Excelente 😀'};
                        const v = Math.round(ctx.parsed.y);
                        return map[v] || `Média: ${ctx.parsed.y}`;
                    }
                }
            }
        },
        scales: {
            y: {
                min: 0.5,
                max: 5.5,
                ticks: {
                    stepSize: 1,
                    callback: (v) => ({1:'😢',2:'🙁',3:'😐',4:'🙂',5:'😀'}[v] || ''),
                    font: { size: 13 }
                },
                grid: { color: '#e8f4f6' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 } }
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
<?php endif; ?>

<?= $this->endSection() ?>