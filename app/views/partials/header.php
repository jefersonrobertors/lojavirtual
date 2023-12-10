<header class="bg-dark">
    <div class="header-bottom">
        <div class="brand">
            <h1 style="color: white;">Logo</h1>
        </div>
        <form class="form-search" method="GET">
            <div class="input-floating">
                <input type="text" class="input-control" name="s" id="search" autocomplete="off" spellcheck="false">
                <label for="search" class="input-label text-muted">Faça sua busca aqui</label>
                <button type="submit" class="input-btn-icon"><i class="bi bi-search input-icon"></i></button>
            </div>
        </form>
        <div class="btn-list">
            <button type="button" class="btn fs-2" data-bs-toggle="modal" data-bs-target="#auth-modal"><i class="bi bi-person"></i></button>
            <button type="button" class="btn fs-4"><i class="bi bi-heart"></i></button>
            <button type="button" class="btn"><a href="/cart" class="fs-4" data-count="0" id="btn-cart"><i class="bi bi-bag"></i></a></button>
            <div class="modal fade" id="auth-modal" tabindex="-1" aria-labelledby="auth-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-title p-3 d-flex justify-content-end">
                             <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</header>