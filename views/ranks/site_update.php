<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Site Update</h1>
        <a href="/admin/ranks" class="btn btn-primary">Go back to admin</a>
    </div>

    

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    

    <form method="post" action="" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Site name</label>
            <input name="head" type="text" class="form-control" value="<?php echo $siteData['head'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Site version</label>
            <input name="version" type="text" class="form-control" value="<?php echo $siteData['version'] ?>">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
