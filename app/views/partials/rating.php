<?php

use app\database\entities\RatingProductEntity;
use app\database\repositories\RatingProductRepository;
use app\helpers\Rating;

$entities = array_filter(RatingProductRepository::create()->fetchAll(), function (RatingProductEntity $rating) {
    return $rating->getProductId() == 2 && $rating->getRating() > 0;
});

$reviewCount = count($entities);
$count = 0;

foreach($entities as $key => $entity) {
    if($entity instanceof RatingProductEntity) {
        $count += $entity->getRating();
    }
}
$rating = Rating::create();

$start = $rating->calc($count, $reviewCount, true);
$icon = $rating->getStarIconUnfilled(2);
?>
<div class="row py-2 mt-4 d-flex align-items-center justify-content-center review-section bg-light">
    <h2 style="text-align: center">Avaliações</h2>
    <hr>
    <div class="col-md-4">
        <div class="d-flex justify-content-center flex-column align-items-center">
            <h2 class="d-flex align-items-center mb-3 fs-8"><?= number_format($start, ($count > 0 ? 1 : 0)); ?> / 5</h2>
            <span class="fs-6 mx-1"><?=  $rating->getLabel($start) ?></span>
            <div class="d-flex justify-content-center align-items-center px-2 review"><?= $rating->repeat($start); ?></div>
            <span class="mt-3 text-muted"><?= $reviewCount ?> avaliações</span>
        </div>
    </div>
    <div class="col-md-4">
        <?= $rating->getReviewDetail($entities); ?>
    </div>
    <div class="col-md-4 d-flex justify-content-center">
        <button type="button" class="btn btn-dark btn-review" data-bs-toggle="modal" data-bs-target="#modal-review">Avaliar este produto</button>
    </div>
    <div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="review-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review-title">Feedback</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="rating">
                            <div class="rating-label"></div>
                            <ul class="list-inline rating-list">
                                <li class="list-inline-item star-icon" data-rate="1"><?= $icon ?></li>
                                <li class="list-inline-item star-icon" data-rate="2"><?= $icon ?></li>
                                <li class="list-inline-item star-icon" data-rate="3"><?= $icon ?></li>
                                <li class="list-inline-item star-icon" data-rate="4"><?= $icon ?></li>
                                <li class="list-inline-item star-icon" data-rate="5"><?= $icon ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control shadow-none" placeholder="Escreva um comentário" id="comment" maxlength="200" minlength="50"></textarea>
                            <label for="comment">Escreva um comentário</label>
                            <div class="input-tooltip"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center"><span class="text-muted">min/máx - 50/200</span><span class="text-muted comment-length">0/200</span></div>
                    </div>
                    <button type="button" class="btn btn-dark disabled me-1 btn-submit-review">Avaliar</button>
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>