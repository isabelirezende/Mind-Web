<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<div style="text-align:center;padding:24px 0;">

    <div style="font-size:3rem;margin-bottom:12px;">🫂</div>

    <h1 style="font-size:1.4rem;font-weight:700;margin-bottom:8px;">
        Você não está sozinho(a)
    </h1>
    <p style="color:var(--mind-muted);font-size:0.9rem;max-width:340px;margin:0 auto 32px;">
        Se você está passando por um momento difícil, pressione o botão abaixo. Seu profissional será notificado.
    </p>

    <form action="/panico/salvar" method="POST" id="formPanico">
        <?= csrf_field() ?>
        <button type="submit" id="btnPanico"
            style="background:#e53e3e;color:#fff;border:none;border-radius:16px;
                   padding:20px 40px;font-size:1.1rem;font-weight:700;cursor:pointer;
                   box-shadow:0 4px 20px rgba(229,62,62,0.3);transition:all 0.2s;
                   display:inline-flex;align-items:center;gap:10px;">
            <i class="bi bi-exclamation-triangle-fill" style="font-size:1.3rem;"></i>
            Preciso de ajuda agora
        </button>
    </form>

    <p style="margin-top:24px;font-size:0.8rem;color:var(--mind-muted);">
        CVV — Centro de Valorização da Vida: <strong>188</strong> (24h)
    </p>

    <div style="margin-top:12px;">
        <a href="/painel" style="font-size:0.85rem;color:var(--mind-muted);text-decoration:none;">
            ← Voltar ao painel
        </a>
    </div>
</div>

<script>
document.getElementById('formPanico').addEventListener('submit', function() {
    const btn = document.getElementById('btnPanico');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando…';
});
</script>

<?= $this->endSection() ?>