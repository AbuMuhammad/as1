<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box <?= $this->box['type'] ?>">
            <div class="box-header <?= $this->box['headerBorder'] ? 'with-border' : '' ?>">
                <h3 class="box-title"><?= $this->pageHeader['boxTitle'] ?></h3>
                <div class="box-tools">
                    <?php
                    $this->widget('BTombolBox', [
                        'encodeLabel' => false,
                        'id' => '',
                        'items' => $this->menu,
                    ]);
                    ?>
                </div>
            </div>
            <?= $content; ?>
        </div>
    </div>
</div>
<?php
$this->endContent();
