<div class="container">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Admin Login</h1>
        <a href="/" class="btn btn-primary">Go back to list</a>
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
            <label class="form-label">Username</label>
            <input name="name" type="text" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>


</div>

