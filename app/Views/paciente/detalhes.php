<?= $this->extend('layouts/base_profissional') ?>
<?= $this->section('conteudo') ?>

<?php
$emojiHumor = [
    'excelente' => ['emoji' => '😀', 'cor' => '#276749', 'bg' => '#f0fff4', 'border' => '#c6f6d5'],
    'bom'       => ['emoji' => '🙂', 'cor' => '#009cb9', 'bg' => '#e6f8fb', 'border' => '#b2ebf2'],
    'neutro'    => ['emoji' => '😐', 'cor' => '#6c8a90', 'bg' => '#f0f7f8', 'border' => '#d6eef0'],
    'ruim'      => ['emoji' => '🙁', 'cor' => '#c05621', 'bg' => '#fffaf0', 'border' => '#fbd38d'],
    'pessimo'   => ['emoji' => '😢', 'cor' => '#e53e3e', 'bg' => '#fff5f5', 'border' => '#fed7d7'],
];
?>

<!-- Voltar -->
<div class="mb-3">
    <a href="/dashboard" style="color:var(--mind-muted);text-decoration:none;font-size:0.85rem;">
        <i class="bi bi-arrow-left me-1"></i> Voltar ao dashboard
    </a>
</div>

<!-- Cabeçalho do paciente -->
<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;margin:0;">
            <?= esc($paciente['nome']) ?>
        </h1>
        <p style="color:var(--mind-muted);font-size:0.85rem;margin-top:4px;">
            <?= esc($paciente['email']) ?> · Paciente desde <?= date('d/m/Y', strtotime($paciente['criado_em'])) ?>
        </p>
    </div>

    <?php if ($streak >= 2): ?>
        <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:20px;
                    padding:8px 16px;display:flex;align-items:center;gap:6px;white-space:nowrap;">
            <span style="font-size:1.1rem;">🔥</span>
            <span style="font-size:0.85rem;font-weight:600;color:#c2410c;">
                <?= $streak ?> dias seguidos
            </span>
        </div>
    <?php endif; ?>
</div>

<!-- Cards de resumo -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-num"><?= count($historicoHumor) ?></div>
            <div class="metric-label">Registros de humor</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-num"><?= count($historicoAlimentacao) ?></div>
            <div class="metric-label">Registros de alimentação</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card">
            <div class="metric-num"><?= count($historicoDiario) ?></div>
            <div class="metric-label">Entradas no diário</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="metric-card <?= $totalAlertas > 0 ? 'danger' : '' ?>">
            <div class="metric-num"><?= $totalAlertas ?></div>
            <div class="metric-label">Alertas de pânico (total)</div>
        </div>
    </div>
</div>

<!-- Gráfico de evolução -->
<?php if (count($dadosGrafico['valores']) >= 2): ?>
<div class="mind-table p-4 mb-4">
    <p class="section-title mb-3">
        <i class="bi bi-graph-up me-1"></i> Evolução do humor (últimos 14 registros)
    </p>
    <canvas id="graficoPaciente" height="100"></canvas>
</div>
<?php endif; ?>

<!-- Histórico de humor -->
<div class="mb-4">
    <p class="section-title"><i class="bi bi-emoji-smile me-1"></i> Histórico de humor</p>

    <?php if (empty($historicoHumor)): ?>
        <div class="mind-table p-4 text-center" style="color:var(--mind-muted);font-size:0.9rem;">
            Nenhum registro de humor ainda.
        </div>
    <?php else: ?>
        <div class="mind-table">
            <table class="table">
                <thead>
                    <tr><th>Humor</th><th>Observação</th><th>Data</th></tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($historicoHumor, 0, 10) as $h): ?>
                    <?php $info = $emojiHumor[$h['nivel']] ?? $emojiHumor['neutro']; ?>
                    <tr>
                        <td>
                            <span style="color:<?= $info['cor'] ?>;font-weight:500;">
                                <?= $info['emoji'] ?> <?= ucfirst($h['nivel']) ?>
                            </span>
                        </td>
                        <td style="color:var(--mind-muted);font-size:0.85rem;">
                            <?= $h['observacao'] ? esc(mb_strimwidth($h['observacao'], 0, 80, '…')) : '—' ?>
                        </td>
                        <td style="color:var(--mind-muted);"><?= date('d/m/Y H:i', strtotime($h['criado_em'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Histórico de alimentação -->
<div class="mb-4">
    <p class="section-title"><i class="bi bi-egg-fried me-1"></i> Histórico de alimentação</p>

    <?php if (empty($historicoAlimentacao)): ?>
        <div class="mind-table p-4 text-center" style="color:var(--mind-muted);font-size:0.9rem;">
            Nenhum registro de alimentação ainda.
        </div>
    <?php else: ?>
        <?php foreach ($historicoAlimentacao as $a): ?>
        <div class="mind-table p-3 mb-2">
            <div style="font-size:0.78rem;color:var(--mind-muted);margin-bottom:8px;">
                <?= date('d/m/Y H:i', strtotime($a['criado_em'])) ?>
            </div>
            <div class="row g-2" style="font-size:0.85rem;">
                <div class="col-6 col-md-3"><strong>☕ Café:</strong> <?= esc($a['cafe_manha']) ?: '—' ?></div>
                <div class="col-6 col-md-3"><strong>🍽️ Almoço:</strong> <?= esc($a['almoco']) ?: '—' ?></div>
                <div class="col-6 col-md-3"><strong>🌙 Jantar:</strong> <?= esc($a['jantar']) ?: '—' ?></div>
                <div class="col-6 col-md-3"><strong>🍎 Lanches:</strong> <?= esc($a['lanches']) ?: '—' ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Histórico de diário -->
<div class="mb-4">
    <p class="section-title"><i class="bi bi-journal-text me-1"></i> Entradas do diário</p>

    <?php if (empty($historicoDiario)): ?>
        <div class="mind-table p-4 text-center" style="color:var(--mind-muted);font-size:0.9rem;">
            Nenhuma entrada no diário ainda.
        </div>
    <?php else: ?>
        <?php foreach ($historicoDiario as $d): ?>
        <div class="mind-table p-3 mb-2">
            <div style="font-size:0.78rem;color:var(--mind-muted);margin-bottom:6px;">
                <?= date('d/m/Y H:i', strtotime($d['criado_em'])) ?>
            </div>
            <div style="font-size:0.88rem;line-height:1.6;">
                <?= nl2br(esc($d['conteudo'])) ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (count($dadosGrafico['valores']) >= 2): ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('graficoPaciente'), {
    type: 'line',
    data: {
        labels: <?= json_encode($dadosGrafico['labels']) ?>,
        datasets: [{
            label: 'Humor',
            data: <?= json_encode($dadosGrafico['valores']) ?>,
            borderColor: '#009cb9',
            backgroundColor: 'rgba(0, 156, 185, 0.08)',
            borderWidth: 2.5,
            tension: 0.35,
            fill: true,
            pointBackgroundColor: '#009cb9',
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                min: 0.5, max: 5.5, ticks: {
                    stepSize: 1,
                    callback: (v) => ({1:'😢',2:'🙁',3:'😐',4:'🙂',5:'😀'}[v] || '')
                },
                grid: { color: '#e6f2f4' }
            },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?= $this->endSection() ?>
<?php endif; ?>

<?= $this->endSection() ?>