

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between">
        <h1>Rank Detail - <strong><?php echo $rank['name']; ?></strong></h1>
        <a href="/ranks" class="btn btn-primary">Go back to list</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="view-detail-box">
        <h5>Position: No. <?php echo $rank['position']; ?></h5>
        
        <h5>Movement: 
            <?php if ($rank['movement']): ?>
                <div class="rank-count moveup">
                    <span><i class="fas fa-arrow-up"></i></span>
                    <p><?php echo $rank['count']; ?></p>
                </div>
            <?php else: ?>

                <?php if ($rank['count']): ?>
                    <div class="rank-count movedown">
                        <span><i class="fas fa-arrow-down"></i></span>
                        <p><?php echo $rank['count']; ?></p>
                    </div>
                <?php else: ?>
                    <div class="rank-count">
                        <p>NaN</p>
                    </div>
                <?php endif; ?>

                
            <?php endif; ?>
        </h5>
    </div>

    

    <?php if ($rank['imagePath']): ?>
        <div class="my-3">
            <img src="/<?php echo $rank['imagePath']; ?>" class="view-image" alt="">
        </div>
    <?php endif; ?>


    <div>
        <p class="lead"><?php echo $rank['detail']; ?></p>
    </div>

    <?php if ($view): ?>
        <form method="post" action="" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Detail</label>
                <textarea name="detail" class="form-control"><?php echo $rank['detail'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <?php endif; ?>

</div>