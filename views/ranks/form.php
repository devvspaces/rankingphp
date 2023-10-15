<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if ($rank['imagePath']): ?>
    <div class="my-3">
        <p class="mb-1">Current image:</p>
        <img src="/<?php echo $rank['imagePath']; ?>" class="thumb-image" alt="">
    </div>
<?php endif; ?>

<form method="post" action="" class="mt-4" enctype='multipart/form-data'>
    <div class="mb-3">
        <label class="form-label">Rank Image</label>
        <input name="image" type="file" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Rank Name</label>
        <input name="name" type="text" class="form-control" value="<?php echo $rank['name'] ?>">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>