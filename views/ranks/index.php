

        <div class="container">
            <div class="d-flex align-items-center my-3">
                <h1>Rankings</h1>
            </div>
        </div>

        <section>
            <div class="container">
                <div id="board">
                
                <?php foreach($ranks as $i=>$ranks): ?>
                        

                    <div class="rank-parent" num=<?php echo $i + 1;  ?>>
                        <div class="rank-card" rankID=<?php echo $ranks['id'] ?>>

                            <?php if ($ranks['image']): ?>
                            <img src="/<?php echo $ranks['image'] ?>" alt="">
                            <?php endif; ?>

                            <div class="rank-content">
                                <div class="rank-top">
                                    <div class="rank-title">
                                        <span><i class="fas fa-crown"></i></span>
                                        <p>No. <?php echo $i + 1;  ?></p>
                                    </div>

                                    <?php if ($ranks['movement']): ?>
                                        <div class="rank-count moveup">
                                            <span><i class="fas fa-arrow-up"></i></span>
                                            <p><?php echo $ranks['count']; ?></p>
                                        </div>
                                    <?php else: ?>

                                        <?php if ($ranks['count']): ?>
                                            <div class="rank-count movedown">
                                                <span><i class="fas fa-arrow-down"></i></span>
                                                <p><?php echo $ranks['count']; ?></p>
                                            </div>
                                        <?php else: ?>
                                            <div class="rank-count">
                                                <p>NaN</p>
                                            </div>
                                        <?php endif; ?>

                                        
                                    <?php endif; ?>
                                </div>
                                <h4 class="mt-3"><?php echo $ranks['name']; ?></h4>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if(count($ranks) == 0 ): ?>
                    <h3>No rankings added yet!</h3>
                <?php endif; ?>
                    
                </div>
            </div>
        </section>

        <script src="/assets/js/setCrown.js"></script>