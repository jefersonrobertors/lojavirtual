<?php

use app\helpers\CSRF;

echo $this->layout('master', ['title' => $title]); 

$csrf_field = CSRF::create();
?>
<div class="bg-primary">
    <div class="py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-md-6 col-xl-7">
                    <div class="d-flex justify-content-center text-bg-primary">
                        <div class="col-12 col-xl-9">
                            <img class="img-fluid rounded mb-4" loading="lazy" src="./assets/img/bsb-logo-light.svg" width="245" height="80" alt="">
                            <hr class="border-primary-subtle mb-4">
                            <h2 class="h1 mb-4">We make digital products that drive you to stand out.</h2>
                            <p class="lead mb-5">We write words, take photos, make videos, and interact with artificial intelligence.</p>
                            <div class="text-endx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="black" class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                                    <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h2>Inscrever-se</h2>
                                        <p class="text-muted">Já tem cadastro? <a href="<?= route('login') ?>">Entrar</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="progress px-1" style="height: 3px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="step-container d-flex justify-content-between">
                                    <div class="step-circle" title="1/4" onclick="displayStep(1)">1</div>
                                    <div class="step-circle" title="2/4" onclick="displayStep(2)">2</div>
                                    <div class="step-circle" title="3/4" onclick="displayStep(3)">3</div>
                                </div>
                            </div>
                            <form class="row gy-3 overflow-hidden form form-register" action="<?= route('register') ?>" method="post">
                                <div class="step step-1">
                                    <div class="col-12">
                                        <p class="text-muted">1/3 - Identificação.</p>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" data-required="true" name="fullName" id="fullName" autocomplete="off">
                                            <label for="fullName" class="input-label">Nome Completo</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="email" class="input-control w-100 border-rounded email" spellcheck="false" data-required="true" data-custom-name="Email" name="email" id="email" autocomplete="true">
                                            <label for="email" class="input-label">E-mail</label>
                                            <div class="help-block"></div>
                                            <ul id="suggests" class="list-unstyled"></ul>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" data-required="true" data-custom-name="CPF" maxlength="14" name="cpf" id="cpf" autocomplete="off">
                                            <label for="cpf" class="input-label">CPF</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="tel" class="input-control w-100 border-rounded" data-required="false" maxlength="15" data-custom-name="Telefone" name="phone-number" id="phone-number" autocomplete="off">
                                            <label for="phone-number" class="input-label">Telefone</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary next-step shadow-none">
                                                Continuar
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="step step-2" style="display:none">
                                    <div class="col-12">
                                        <p class="text-muted">2/3 - Crie uma senha.</p>
                                        <div class="input-floating mb-3">
                                            <input type="password" class="input-control w-100 border-rounded" data-required="true" data-custom-name="Senha" name="password" id="password" maxlength="20" autocomplete="off">
                                            <label for="password" class="input-label">Senha</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="password" class="input-control w-100 border-rounded" data-required="true" data-custom-name="Senha" aria-describedby="help" maxlength="20" name="confirm-password" id="confirm-password" autocomplete="off">
                                            <label for="confirm-password" class="input-label">Confirme a senha</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="eye-check mb-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input shadow-none eye-check-input" type="checkbox" id="eye">
                                                <label class="form-check-label eye-label" for="eye">Mostrar senha</label>
                                            </div>
                                        </div>
                                        <span class="strength-label"></span>
                                        <div class="password-meter mt-2 mb-2">
                                            <div class="meter-section meter-1 rounded me-2"></div>
                                            <div class="meter-section meter-2 rounded me-2"></div>
                                            <div class="meter-section meter-3 rounded me-2"></div>
                                            <div class="meter-section meter-4 rounded"></div>
                                        </div>
                                        <div id="help" class="form-text text-muted mb-2">
                                            Deve conter 8-20 caracteres, letras maiúsculas e minúsculas, números e símbolos.
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button type="button" class="btn btn-primary previous-step shadow-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                                </svg>
                                                Voltar
                                            </button>
                                            <button type="button" class="btn btn-primary next-step shadow-none">
                                                Continuar
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="step step-3" style="display: none;">
                                    <div class="col-12">
                                        <p class="text-muted">3/3 - Endereço.</p>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" data-required="true" data-cusstom-name="CEP" name="cep" maxlength="9" id="cep" autocomplete="off">
                                            <label for="cep" class="input-label">CEP</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" data-required="true" data-custom-name="Cidade" name="city" id="city" autocomplete="off">
                                            <label for="city" class="input-label">Cidade</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" data-required="true" data-custom-name="Estado" maxlength="2" name="state" id="state" autocomplete="off">
                                            <label for="state" class="input-label">Estado</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" name="address" data-required="true" data-custom-name="Logradouro" id="address" autocomplete="off">
                                            <label for="address" class="input-label">Logradouro</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" name="district" data-required="true" data-custom-name="Bairro" id="district" autocomplete="off">
                                            <label for="district" class="input-label">Bairro</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="input-floating mb-3">
                                            <input type="text" class="input-control w-100 border-rounded" spellcheck="false" data-required="false" data-custom-name="Complemento" name="complement" id="complement" autocomplete="off">
                                            <label for="complement" class="input-label">Complemento</label>
                                            <div class="help-block"></div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-primary previous-step shadow-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                                </svg>
                                                Voltar
                                            </button>
                                            <button type="button" class="g-recaptcha btn btn-dark shadow-none" data-action="submit" data-callback="onSubmit" data-sitekey="<?= env('GOOGLE_RECAPTCHA_SITE_KEY') ?>">Inscrever-se</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 mb-2">
                                    <small class="text-muted">Ao se inscrever, você concorda com a nossa <a href="">Política de Privacidade</a></small>
                                </div>
                                <?= $csrf_field ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('partials/footer.php'); ?>
    <?php include('partials/whatsappButton.php'); ?>
</div>