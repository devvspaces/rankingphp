

        <div class="container">
            <div class="d-flex align-items-center my-3 justify-content-between" style="flex-wrap: wrap;">
                <h1>Admin Ranks List</h1>

                <div class="main_site_up">
                    <a href="/ranks/create" class="btn btn-sm btn-success">Create New Rank</a>
                    <a href="#" class="btn btn-sm btn-primary" id="updateOrder">Update order</a>
                    <a href="/site/update" class="btn btn-sm btn-primary">Update Site</a>
                    <a href="/logout" class="btn btn-sm btn-outline-danger">Logout</a>
                    <a href="#" class="btn btn-sm btn-outline-primary" id="toggleEdit">Edit mode</a>
                </div>
            </div>
        </div>

        <section>
            <div class="container">

                <div class="form-search">
                    <input type="text" class="form-control" placeholder="Search ranking ...">
                    <button class="btn btn-sm btn-primary"><span><i class="fas fa-search"></i></span></button>
                </div>
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
                                <h4 class="mt-3 mb-2 noselect"><a href="/admin/ranks/view?id=<?php echo $ranks['id']; ?>"><?php echo $ranks['name']; ?></a></h4>

                                <div class="maxes">
                                    <p>Highest: <span class="highest"><?php echo $ranks['highest']; ?></span></p>
                                    <p>Lowest: <span class="lowest"><?php echo $ranks['lowest']; ?></span></p>
                                </div>

                                <a href="/ranks/update?id=<?php echo $ranks['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                <form class="d-inline" action="/ranks/delete" method="post">
                                    <input type="hidden" name="id" value="<?php echo $ranks['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>

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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="/assets/js/scripts.js"></script>