<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<?php
$nome = explode(' ', session()->get('usuario_nome'))[0];

$hora = (int) date('H');
if ($hora < 12)      $saudacao = 'Bom dia';
elseif ($hora < 18)  $saudacao = 'Boa tarde';
else                 $saudacao = 'Boa noite';

$emojiHumor = [
    'excelente' => ['emoji' => '😀', 'cor' => '#276749', 'bg' => '#f0fff4', 'border' => '#c6f6d5'],
    'bom'       => ['emoji' => '🙂', 'cor' => '#009cb9', 'bg' => '#e6f8fb', 'border' => '#b2ebf2'],
    'neutro'    => ['emoji' => '😐', 'cor' => '#6c8a90', 'bg' => '#f0f7f8', 'border' => '#d6eef0'],
    'ruim'      => ['emoji' => '🙁', 'cor' => '#c05621', 'bg' => '#fffaf0', 'border' => '#fbd38d'],
    'pessimo'   => ['emoji' => '😢', 'cor' => '#e53e3e', 'bg' => '#fff5f5', 'border' => '#fed7d7'],
];
?>

<!-- Saudação -->
<div class="mb-4 d-flex justify-content-between align-items-start flex-wrap gap-2">
    <div>
        <h1 style="font-size:1.5rem;font-weight:700;margin:0;">
            <?= $saudacao ?>, <?= esc($nome) ?>! 👋
        </h1>
        <p style="color:var(--mind-muted);font-size:0.85rem;margin-top:4px;">
            Como está se sentindo hoje? Registre seu estado.
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

<!-- Último humor (se existir) -->
<?php if ($ultimoHumor): ?>
    <?php $info = $emojiHumor[$ultimoHumor['nivel']] ?? $emojiHumor['neutro']; ?>
    <div style="background:<?= $info['bg'] ?>;border:1px solid <?= $info['border'] ?>;
                border-radius:12px;padding:14px 16px;margin-bottom:24px;
                display:flex;align-items:center;gap:12px;">
        <span style="font-size:1.6rem;"><?= $info['emoji'] ?></span>
        <div>
            <div style="font-size:0.78rem;color:var(--mind-muted);text-transform:uppercase;letter-spacing:0.5px;">
                Último registro de humor
            </div>
            <div style="font-weight:600;color:<?= $info['cor'] ?>;">
                <?= ucfirst($ultimoHumor['nivel']) ?>
                <span style="font-weight:400;color:var(--mind-muted);font-size:0.82rem;">
                    · <?= date('d/m \à\s H:i', strtotime($ultimoHumor['criado_em'])) ?>
                </span>
            </div>
        </div>
        <a href="/humor" style="margin-left:auto;font-size:0.8rem;color:var(--mind-primary);text-decoration:none;">
            Atualizar →
        </a>
    </div>
<?php else: ?>
    <!-- EMPTY STATE: nunca registrou humor -->
    <div style="background:#fff;border:1.5px dashed var(--mind-border);border-radius:12px;
                padding:18px 16px;margin-bottom:24px;display:flex;align-items:center;gap:14px;">
        <span style="font-size:1.8rem;">👋</span>
        <div style="flex:1;">
            <div style="font-weight:600;font-size:0.92rem;margin-bottom:2px;">
                Você ainda não registrou seu humor hoje
            </div>
            <div style="font-size:0.8rem;color:var(--mind-muted);">
                Leva menos de 30 segundos — e ajuda muito no seu acompanhamento.
            </div>
        </div>
        <a href="/humor" class="btn-mind" style="text-decoration:none;white-space:nowrap;padding:10px 18px;font-size:0.85rem;">
            Registrar agora
        </a>
    </div>
<?php endif; ?>

<!-- Grid de ações -->
<div class="row g-3 mb-3">
    <div class="col-6">
        <a href="/humor" class="action-card h-100">
            <div class="card-icon">😊</div>
            <div class="card-title">Registrar humor</div>
            <div class="card-desc">Como você está se sentindo agora?</div>
        </a>
    </div>
    <div class="col-6">
        <a href="/alimentacao" class="action-card h-100">
            <div class="card-icon">🥗</div>
            <div class="card-title">Alimentação</div>
            <div class="card-desc">Registre suas refeições do dia</div>
        </a>
    </div>
    <div class="col-6">
        <a href="/diario" class="action-card h-100">
            <div class="card-icon">📓</div>
            <div class="card-title">Diário livre</div>
            <div class="card-desc">Escreva o que quiser, sem julgamentos</div>
        </a>
    </div>
    <div class="col-6">
        <a href="/panico" class="panic-card h-100">
            <div class="card-icon">🚨</div>
            <div class="card-title">Preciso de ajuda</div>
            <div class="card-desc">Toque aqui em caso de crise</div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>