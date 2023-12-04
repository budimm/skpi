<?php if (!empty($errors)) : ?>
    <script>
        Swal.fire({
            title: "Gagal!",
            html: "<?= implode('<br>', $errors) ?>",
            icon: "error"
        });
    </script>
<?php endif ?>