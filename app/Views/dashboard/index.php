<?= $this->extend('layouts/base_profissional') ?>
<?= $this->section('conteudo') ?>

<!-- Header da página -->
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;margin:0;">
            Bom dia, <?= esc(explode(' ', session()->get('usuario_nome'))[0]) ?> 👋
        </h1>
        <p style="color:var(--mind-muted);font-size:0.85rem;margin-top:4px;">
            <?= date('l, d \d\e F \d\e Y') ?>
        </p>
    </div>
</div>

<!-- Cards de métricas -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-num"><?= $totalPacientes ?></div>
                    <div class="metric-label">Pacientes</div>
                </div>
                <i class="bi bi-people metric-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card danger">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-num"><?= $totalAlertas ?></div>
                    <div class="metric-label">Alertas novos</div>
                </div>
                <i class="bi bi-exclamation-triangle metric-icon" style="color:#fed7d7;"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-num"><?= count($humoresRecentes) ?></div>
                    <div class="metric-label">Registros hoje</div>
                </div>
                <i class="bi bi-journal-text metric-icon"></i>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="metric-num"><?= $totalPacientes ?></div>
                    <div class="metric-label">Em acompanhamento</div>
                </div>
                <i class="bi bi-heart-pulse metric-icon"></i>
            </div>
        </div>
    </div>
</div>

<!-- Alertas recentes -->
<div class="mb-4">
    <p class="section-title">
        <i class="bi bi-bell me-1"></i> Alertas de pânico
    </p>

    <?php if (empty($alertasRecentes)): ?>
        <div class="mind-table p-4 text-center" style="color:var(--mind-muted);font-size:0.9rem;">
            <i class="bi bi-check-circle" style="font-size:2rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
            Nenhum alerta registrado. Tudo tranquilo por aqui.
        </div>
    <?php else: ?>
        <div class="mind-table">
            <table class="table">
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
                            <div style="font-weight:500;"><?= esc($alerta['paciente_nome']) ?></div>
                        </td>
                        <td style="color:var(--mind-muted);">
                            <?= date('d/m/Y H:i', strtotime($alerta['criado_em'])) ?>
                        </td>
                        <td>
                            <?php if ($alerta['visualizado']): ?>
                                <span style="background:#f0fff4;color:#276749;border:1px solid #c6f6d5;font-size:0.75rem;padding:3px 8px;border-radius:20px;">
                                    Visto
                                </span>
                            <?php else: ?>
                                <span class="badge-novo">Novo</span>
                                <span class="badge-panico ms-1">Pânico</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (! $alerta['visualizado']): ?>
                                <a href="/alertas/ver/<?= $alerta['id'] ?>"
                                   style="font-size:0.82rem;color:var(--mind-primary);text-decoration:none;">
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

<!-- Registros de humor recentes -->
<div>
    <p class="section-title">
        <i class="bi bi-emoji-smile me-1"></i> Registros de humor recentes
    </p>

    <?php
    $emojiHumor = [
        'excelente' => '😀',
        'bom'       => '🙂',
        'neutro'    => '😐',
        'ruim'      => '🙁',
        'pessimo'   => '😢',
    ];
    $corHumor = [
        'excelente' => '#276749',
        'bom'       => '#009cb9',
        'neutro'    => '#6c8a90',
        'ruim'      => '#c05621',
        'pessimo'   => '#e53e3e',
    ];
    ?>

    <?php if (empty($humoresRecentes)): ?>
        <div class="mind-table p-4 text-center" style="color:var(--mind-muted);font-size:0.9rem;">
            <i class="bi bi-journal" style="font-size:2rem;color:var(--mind-light);display:block;margin-bottom:8px;"></i>
            Nenhum registro de humor ainda.
        </div>
    <?php else: ?>
        <div class="mind-table">
            <table class="table">
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
                    <tr>
                        <td style="font-weight:500;"><?= esc($h['paciente_nome']) ?></td>
                        <td>
                            <span style="color:<?= $corHumor[$h['nivel']] ?? '#333' ?>;font-weight:500;">
                                <?= $emojiHumor[$h['nivel']] ?? '' ?> <?= ucfirst($h['nivel']) ?>
                            </span>
                        </td>
                        <td style="color:var(--mind-muted);font-size:0.85rem;">
                            <?= $h['observacao'] ? esc(mb_strimwidth($h['observacao'], 0, 60, '…')) : '—' ?>
                        </td>
                        <td style="color:var(--mind-muted);">
                            <?= date('d/m H:i', strtotime($h['criado_em'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>