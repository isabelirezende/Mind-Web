<?= $this->extend('layouts/base_paciente') ?>
<?= $this->section('conteudo') ?>

<div style="text-align:center;padding:32px 0;">

    <div style="width:72px;height:72px;background:#f0fff4;border-radius:50%;
                display:flex;align-items:center;justify-content:center;
                margin:0 auto 20px;font-size:2rem;border:2px solid #c6f6d5;">
        ✅
    </div>

    <h1 style="font-size:1.4rem;font-weight:700;margin-bottom:8px;color:#276749;">
        Pedido registrado
    </h1>

    <p style="color:var(--mind-muted);font-size:0.9rem;max-width:360px;margin:0 auto 24px;line-height:1.7;">
        Seu profissional foi notificado e está ciente do seu pedido de ajuda.
        Você fez a coisa certa ao pedir apoio.
    </p>

    <div style="background:#f0f7f8;border:1px solid var(--mind-border);border-radius:12px;
                padding:16px 20px;max-width:360px;margin:0 auto 28px;text-align:left;">
        <p style="font-size:0.85rem;margin:0;line-height:1.7;color:var(--mind-text);">
            💬 <strong>Respire fundo.</strong><br>
            Inspire lentamente pelo nariz (4 segundos),<br>
            segure (4 segundos),<br>
            expire pela boca (6 segundos).<br><br>
            Repita isso 3 vezes. Você consegue. 🫁
        </p>
    </div>

    <p style="font-size:0.8rem;color:var(--mind-muted);margin-bottom:20px;">
        Em caso de emergência imediata: <strong>SAMU 192</strong> · <strong>CVV 188</strong>
    </p>

    <a href="/painel" class="btn-mind" style="text-decoration:none;display:inline-block;">
        <i class="bi bi-house me-1"></i> Voltar ao painel
    </a>
</div>

<?= $this->endSection() ?>