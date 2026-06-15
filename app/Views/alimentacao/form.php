<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<div class="mb-4">
    <a href="/painel" style="color:var(--mind-muted);text-decoration:none;font-size:0.85rem;">
        <i class="bi bi-arrow-left me-1"></i> Voltar
    </a>
    <h1 style="font-size:1.4rem;font-weight:700;margin:12px 0 4px;">Alimentação de hoje</h1>
    <p style="color:var(--mind-muted);font-size:0.85rem;">Registre o que você comeu. Qualquer detalhe ajuda.</p>
</div>

<div class="mind-card">
    <form action="/alimentacao/salvar" method="POST">
        <?= csrf_field() ?>

        <?php
        $refeicoes = [
            ['campo' => 'cafe_manha', 'emoji' => '☕', 'label' => 'Café da manhã', 'placeholder' => 'Ex: pão com manteiga, café com leite…'],
            ['campo' => 'almoco',     'emoji' => '🍽️', 'label' => 'Almoço',        'placeholder' => 'Ex: arroz, feijão, frango, salada…'],
            ['campo' => 'jantar',     'emoji' => '🌙', 'label' => 'Jantar',         'placeholder' => 'Ex: sopa, sanduíche, macarrão…'],
            ['campo' => 'lanches',    'emoji' => '🍎', 'label' => 'Lanches',        'placeholder' => 'Ex: fruta, biscoito, suco…'],
        ];
        foreach ($refeicoes as $r):
            $valorAnterior = $ultimoRegistro[$r['campo']] ?? '';
        ?>
        <div class="mb-4">
            <div class="section-label">
                <?= $r['emoji'] ?> <?= $r['label'] ?>
            </div>
            <textarea name="<?= $r['campo'] ?>"
                class="mind-textarea mt-1"
                rows="2"
                placeholder="<?= $r['placeholder'] ?>"><?= esc(old($r['campo'], $valorAnterior)) ?></textarea>
        </div>
        <?php endforeach; ?>

        <button type="submit" class="btn-mind w-100">
            <i class="bi bi-check-circle me-1"></i> Salvar alimentação
        </button>
    </form>
</div>


<script>
document.querySelectorAll('.mind-textarea').forEach(textarea => {
    function verificar() {
        if (textarea.value.trim().length > 0) {
            textarea.style.borderColor = '#9ae6b4';
        } else {
            textarea.style.borderColor = '';
        }
    }
    textarea.addEventListener('input', verificar);
    verificar(); // checa no load (para valores pré-preenchidos)
});
</script>

<?= $this->endSection() ?>