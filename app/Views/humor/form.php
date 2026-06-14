<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<div class="mb-4">
    <a href="/painel" style="color:var(--mind-muted);text-decoration:none;font-size:0.85rem;">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
    <h1 style="font-size:1.4rem;font-weight:700;margin:12px 0 4px;">Como você está se sentindo?</h1>
    <p style="color:var(--mind-muted);font-size:0.85rem;">Selecione o que melhor descreve seu estado agora.</p>
</div>

<div class="mind-card">
    <form action="/humor/salvar" method="POST">
        <?= csrf_field() ?>

        <!-- Seletores de humor -->
        <div class="mb-4">
            <div class="section-label">Seu humor agora</div>
            <div class="d-flex gap-2 flex-wrap mt-2" id="humorBtns">
                <?php
                $opcoes = [
                    ['valor' => 'excelente', 'emoji' => '😀', 'label' => 'Excelente'],
                    ['valor' => 'bom',       'emoji' => '🙂', 'label' => 'Bom'],
                    ['valor' => 'neutro',    'emoji' => '😐', 'label' => 'Neutro'],
                    ['valor' => 'ruim',      'emoji' => '🙁', 'label' => 'Ruim'],
                    ['valor' => 'pessimo',   'emoji' => '😢', 'label' => 'Péssimo'],
                ];
                foreach ($opcoes as $op): ?>
                <button type="button"
                    class="humor-btn"
                    data-valor="<?= $op['valor'] ?>"
                    onclick="selecionarHumor(this)">
                    <span style="font-size:1.6rem;display:block;"><?= $op['emoji'] ?></span>
                    <span style="font-size:0.78rem;"><?= $op['label'] ?></span>
                </button>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="nivel" id="nivelInput" value="">
        </div>

        <!-- Observação -->
        <div class="mb-4">
            <div class="section-label">Quer contar mais? (opcional)</div>
            <textarea name="observacao" class="mind-textarea mt-1" rows="3"
                placeholder="Como foi seu dia? Algo aconteceu?"></textarea>
        </div>

        <button type="submit" class="btn-mind w-100">
            <i class="bi bi-check-circle me-1"></i> Salvar registro
        </button>
    </form>
</div>

<!-- Histórico recente -->
<?php if (!empty($historico)): ?>
<div class="mt-4">
    <p class="section-label">Seus últimos 7 registros</p>
    <?php
    $emojiMap = ['excelente'=>'😀','bom'=>'🙂','neutro'=>'😐','ruim'=>'🙁','pessimo'=>'😢'];
    $corMap   = ['excelente'=>'#276749','bom'=>'#009cb9','neutro'=>'#6c8a90','ruim'=>'#c05621','pessimo'=>'#e53e3e'];
    foreach ($historico as $h): ?>
    <div style="background:#fff;border:1px solid var(--mind-border);border-radius:10px;
                padding:12px 14px;margin-bottom:8px;display:flex;align-items:center;gap:10px;">
        <span style="font-size:1.2rem;"><?= $emojiMap[$h['nivel']] ?? '😐' ?></span>
        <div style="flex:1;">
            <span style="font-weight:600;color:<?= $corMap[$h['nivel']] ?? '#333' ?>;">
                <?= ucfirst($h['nivel']) ?>
            </span>
            <?php if ($h['observacao']): ?>
                <span style="color:var(--mind-muted);font-size:0.82rem;margin-left:6px;">
                    · <?= esc(mb_strimwidth($h['observacao'], 0, 50, '…')) ?>
                </span>
            <?php endif; ?>
        </div>
        <span style="font-size:0.78rem;color:var(--mind-muted);">
            <?= date('d/m H:i', strtotime($h['criado_em'])) ?>
        </span>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<style>
.humor-btn {
    background: #fff;
    border: 1.5px solid var(--mind-border);
    border-radius: 12px;
    padding: 12px 16px;
    min-width: 80px;
    cursor: pointer;
    transition: all 0.15s;
    text-align: center;
    color: var(--mind-text);
    line-height: 1.4;
}
.humor-btn:hover {
    border-color: var(--mind-light);
    background: var(--mind-bg);
}
.humor-btn.ativo {
    border-color: var(--mind-primary);
    background: #e6f8fb;
    box-shadow: 0 0 0 3px rgba(0,156,185,0.1);
}
</style>

<script>
function selecionarHumor(btn) {
    document.querySelectorAll('.humor-btn').forEach(b => b.classList.remove('ativo'));
    btn.classList.add('ativo');
    document.getElementById('nivelInput').value = btn.dataset.valor;
}
</script>

<?= $this->endSection() ?>