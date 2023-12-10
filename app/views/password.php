<?php
echo $this->layout('master', ['title' => $title]); 
?>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Redefinir senha</h5>
                    <form method="post" action="/password/update">
                        <div class="mb-3">
                            <label for="password" class="form-label">Nova senha</label>
                            <input type="password" class="form-control shadow-none" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirmar Nova senha</label>
                            <input type="password" class="form-control shadow-none" id="confirm-password" name="confirm-password">
                            <div class="input-group-text text-wrap mt-3">
                                Deve conter 8-20 caracteres, letras maiúsculas e minúsculas, números e símbolos.
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Redefinir senha</button>
                        </div>
                        <input type="hidden" name="code" value="<?= $code ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>