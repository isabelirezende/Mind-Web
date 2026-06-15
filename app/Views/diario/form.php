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

        <div class="mb-2">
            <textarea name="conteudo" id="conteudoDiario" 
            class="mind-textarea" rows="10"
                style="min-height:220px;font-size:0.95rem;line-height:1.7;"
                placeholder="Escreva aqui… o que está sentindo, o que aconteceu hoje, qualquer coisa que queira registrar."
                oninput="atualizarContador()"
                ><?= esc(old('conteudo')) ?></textarea>
        </div>

        <div class="mb-4" style="text-align:right;">
            <span id="contadorCaracteres" style="font-size:0.78rem;
            color:var(--mind-muted);">0 caracteres</span>
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

<script>
function atualizarContador() {
    const texto = document.getElementById('conteudoDiario').value;
    const contador = document.getElementById('contadorCaracteres');
    const tamanho = texto.length;

    if (tamanho === 0) {
        contador.textContent = '0 caracteres';
        contador.style.color = 'var(--mind-muted)';
    } else if (tamanho < 3) {
        contador.textContent = `${tamanho} caractere${tamanho === 1 ? '' : 's'} — escreva um pouco mais`;
        contador.style.color = '#e53e3e';
    } else {
        contador.textContent = `${tamanho} caracteres`;
        contador.style.color = 'var(--mind-muted)';
    }
}

// Atualiza o contador ao carregar a página (caso tenha old() preenchido após erro de validação)
document.addEventListener('DOMContentLoaded', atualizarContador);
</script>

<?= $this->endSection() ?>