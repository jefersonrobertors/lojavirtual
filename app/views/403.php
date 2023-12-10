<?php $this->layout('master', ['title' => 'Forbidden 403']); ?>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center vh-100 user-select-none">
        <div class="col-md-6">
            <h1 class="display-1">Forbidden (403)</h1>
            <div class="lead"><?=$this->e($message)?></div>
        </div>
    </div>
</div>