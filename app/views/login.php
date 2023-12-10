<?php

use app\helpers\CSRF;

echo $this->layout('master', ['title' => $title]);

$csrf_field = CSRF::create();

?>
<div class="bg-primary">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="center vh-100">
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="card border-1 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h1>Entrar</h1>
                                        <p class="text-muted">Ainda não tem cadastro? <a href="<?= route('register') ?>" title="Inscrever-se">Inscrever-se</a></p>
                                    </div>
                                </div>
                            </div>
                            <form class="row gy-3 overflow-hidden form form-login" action="<?= route('login') ?>" method="post">
                                <div class="col-12">
                                    <div class="input-floating">
                                        <input type="text" class="input-control border-rounded w-100 email" name="email" id="email" autocomplete="off" spellcheck="false">
                                        <label for="email" class="input-label">E-mail</label>
                                        <div class="help-block"><?= flash('email') ?></div>
                                        <ul id="suggests" class="list-unstyled"></ul>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-floating">
                                        <input type="password" class="input-control border-rounded w-100" name="password" id="password" autocomplete="off" spellcheck="false">
                                        <label for="password" class="input-label">Senha</label>
                                        <div class="eye-pwd"><i class="bi bi-eye-fill fs-4"></i></div>
                                        <div class="help-block"><?= flash('password') ?></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="button" class="g-recaptcha btn btn-dark btn-lg shadow-none" data-action="submit" data-callback="onSubmit" data-sitekey="<?= env('GOOGLE_RECAPTCHA_SITE_KEY') ?>">Entrar</button>
                                        <a class="text-underline d-flex justify-content-end mt-1" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modal-password">Esqueci minha senha</a>
                                    </div>
                                </div>
                                <?= $csrf_field ?>
                            </form>
                            <div class="row">
                                <div class="divider d-flex justify-content-center align-items-center my-4">
                                    <p class="text-center mx-3 mb-0 text-muted">ou</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <?php include_once('partials/social-login.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-password" tabindex="-1" data-bs-backdrop="static" aria-labelledby="password-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-title p-3 d-flex justify-content-end">
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>                        
            <div class="modal-body mb-3 center flex-column">
                <div class="col-10">
                    <div class="mb-4">
                        <h2>Esqueci minha senha</h2>
                        <p class="text-muted">Informe o e-mail cadastrado para receber as instruções de recuperação.</p>                                
                    </div>
                </div>
                <form class="col-sm-10" method="post" action="<?= route('password/recovery') ?>">
                    <div class="input-floating mb-3">
                        <input type="email" class="input-control w-100 border-rounded" name="email-pwd" id="email-subscribed" autocomplete="off" spellcheck="false">
                        <label for="email-subscribed" class="input-label">E-mail</label>
                        <div class="d-flex justify-content-between">
                            <div class="input-tooltip"></div>
                            <a class="text-underline" style="cursor:pointer" href="#">Perdi acesso ao meu email</a>
                        </div>
                    </div>
                    <?= $csrf_field ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-dark shadow-none" data-bs-dismiss="modal">Receber instruções</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include_once('partials/whatsappButton.php');
include_once('partials/footer.php');
?>