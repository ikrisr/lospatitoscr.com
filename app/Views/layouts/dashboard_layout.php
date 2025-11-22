<?php require __DIR__ . "/header.php"; ?>
<?php require __DIR__ . "/topbar.php"; ?>

<div class="flex">
    <?php require __DIR__ . "/sidebar.php"; ?>

    <main class="flex-1 p-10">
        <?php require $contenido; ?>
    </main>
</div>

<?php require __DIR__ . "/footer.php"; ?>
