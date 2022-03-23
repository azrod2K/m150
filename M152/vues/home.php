<div class="padding">
    <div class="full col-sm-9">
        <!-- content -->
        <div class="row">
        <?php
			// message d'erreur
			if ($_SESSION['message']['type'] != null) { ?>
				<div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?= $_SESSION['message']['content'] ?>
				</div>
			<?php
				$_SESSION['message'] = [
					'type' => null,
					'content' => null
				];
			}
			?>
            <!-- main col left -->
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-thumbnail"><img src="assets/img/bg_5.jpg" class="img-responsive"></div>
                    <div class="panel-body">
                        <p class="lead">Les Aventures</p>
                        <p>Nombre de posts : <?= Post::CountAllPosts() ?>  </p>
                    </div>
                </div>
            </div>
            <!-- main col right -->
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>les posts les plus cool de la planète terre</h4>
                    </div>
                    <div class="panel-body">
                        <h2>welcome</h2>
                    </div>
                </div>
                <?php
                foreach ($posts as $Post) {
                    $medias = Media::getAllMediasByPostId($Post->getIdPost());
                ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <!-- main col left -->
                                <div class="col-sm-6">
                                    <p>Posté le <?= date_format(date_create($Post->getCreationDate()), 'd-m-Y, H:i:s'); ?>
                                        <br>
                                        Modifié le <?= date_format(date_create($Post->getModificationDate()), 'd-m-Y, H:i:s'); ?>
                                    </p>
                                </div>
                                <div class="col-sm-6" style="text-align: right;">
                                    <a class="btn btn-primary" href="index.php?uc=post&action=update&idPost=<?= $Post->getIdPost() ?>">Edit</a>
                                    <a class="btn btn-danger" href="index.php?uc=post&action=delete&idPost=<?= $Post->getIdPost() ?>">X</a>
                                </div>
                            </div>
                            </h4>
                        </div>
                        <div class="panel-body">
                            <!-- Carousel container -->
                            <div id="carousel<?= $Post->getIdPost(); ?>" class="carousel slide" data-ride="carousel">
                                <!-- Content -->
                                <div class="carousel-inner" role="listbox">
                                    <?php
                                    $count = 0;
                                    foreach ($medias as $Media) {
                                        // Si le media est une image
                                        switch (explode("/", $Media->getTypeMedia())[0]) {
                                            case 'image':
                                    ?>
                                                <!-- Slide -->
                                                <div class="item <?= $count == 0 ? "active" : "" ?>">
                                                    <img src="./assets/uploads/<?= $Media->getNomMedia() ?>" alt="Sunset over beach" width="100%">
                                                </div>
                                            <?php
                                                break;
                                            case 'video':
                                            ?>
                                                <div class="item <?= $count == 0 ? "active" : "" ?>">
                                                    <!-- Pour que l'attribut autoplay marche, il faut l'attribut muted -->
                                                    <video controls autoplay loop muted width="100%">
                                                        <source src="./assets/uploads/<?= $Media->getNomMedia() ?>" type="<?= $Media->getTypeMedia() ?>">
                                                    </video>
                                                </div>
                                            <?php
                                                break;
                                            case 'audio':
                                            ?>
                                                <div style="padding-left: 35%;" class="item <?= $count == 0 ? "active" : "" ?>">
                                                    <audio controls src="./assets/uploads/<?= $Media->getNomMedia() ?>"></audio>
                                                </div>
                                    <?php

                                                break;
                                        }
                                        $count++;
                                    }
                                    ?>
                                </div>
                                <?php
                                if ($count > 1) {
                                ?>
                                    <!-- Previous/Next controls -->
                                    <a class="left carousel-control" href="#carousel<?= $Post->getIdPost(); ?>" role="button" data-slide="prev">
                                        <span class="icon-prev" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel<?= $Post->getIdPost(); ?>" role="button" data-slide="next">
                                        <span class="icon-next" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                            <br>
                            <p class="lead"><?= $Post->getCommentaire(); ?></p>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
        <!--/row-->
        <hr>
        <h4 class="text-center">
            <a href="http://usebootstrap.com/theme/facebook" target="ext">Copyright © 2021</a>
        </h4>
        <hr>
    </div><!-- /col-9 -->
</div><!-- /padding -->