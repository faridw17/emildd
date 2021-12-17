<?= $this->extend('default'); ?>

<?= $this->section('title') ?>
<?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('navbar') ?>
<?= $navbar ?>
<?= $this->endSection() ?>

<?= $this->section('sidebar') ?>
<?= $sidebar ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $content ?>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<div class="text-muted">Copyright &copy; <?= $footer['judul'] ?> <?= date("Y") ?></div>
<?= $this->endSection() ?>