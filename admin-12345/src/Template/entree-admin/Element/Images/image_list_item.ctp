<div id="image-<?= h($imageId) ?>" class="image">
  <img src="<?= $src ?>" width="100" data-class="image" data-id="<?= $imageId ?>">
  <div class="action">
    <button
      type="button" class="btn btn-sm btn-danger"
      data-class="btn-del" data-id="<?= $imageId ?>"><i class="fas fa-times"></i>
    </button>
  </div>
</div>
