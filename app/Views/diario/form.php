<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<div class="mb-4">
    <a href="/painel" style="color:var(--mind-muted);text-decoration:none;font-size:0.85rem;">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
    <h1 style="font-size:1.4rem;font-weight:700;margin:12px 0 4px;">Diário livre</h1>
    <p style="color:var(--mind-muted);font-size:0.85rem;">
        Este é seu espaço. Escreva o que quiser — pensamentos, sentimentos, acontecimentos.
    </p>
</div>

<div class="mind-card">
    <form action="/diario/salvar" method="POST">
        <?= csrf_field() ?>

        <div class="mb-4">
            <textarea name="conteudo" class="mind-textarea" rows="10"
                style="min-height:220px;font-size:0.95rem;line-height:1.7;"
                placeholder="Escreva aqui… o que está sentindo, o que aconteceu hoje, qualquer coisa que queira registrar."
                ><?= esc(old('conteudo')) ?></textarea>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <span style="font-size:0.78rem;color:var(--mind-muted);">
                <i class="bi bi-lock me-1"></i> Sua escrita é privada
            </span>
            <button type="submit" class="btn-mind">
                <i class="bi bi-floppy me-1"></i> Salvar
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>