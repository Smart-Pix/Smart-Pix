<div class="row">
    <div class="col-4 col-m-12">
        <div class="bio">
            <div class="profil-avatar">
                <?php if (!empty($user->getAvatar())): ?>
                    <img src="/public/cdn/images/avatars/<?php echo $user->getAvatar(); ?>" alt="">
                <?php else: ?>
                    <p>Aucun avatar sélectionné</p>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user->getId()): ?>
                <a href="/profile"><i class="fa fa-camera-retro" aria-hidden="true"></i></a>
                <?php endif; ?>
            </div>
            <div class="bio-info">
                <p class="username"><?php echo $user->getUsername(); ?></p>
                <p class="name"><?php echo $user->getFirstname() ." ". $user->getLastname(); ?></p>
            </div>
            <hr>
            <div class="bio-other">
                <h2><a href="/user-albums/<?php echo $user->getId(); ?>">Ses albums</a></h2>
                <p class="photos-fav">
                    <?php
                    foreach ($albums as $album):
                        $commu = new Community();
                        $commu = $commu->populate(['id' => $album['community_id']]);
                    ?>
                        <a href="/<?php echo $commu->getSlug(); ?>/album/<?php echo $album['id']; ?>">
                            <?php if ($album['thumbnail_url'] !== null && !empty($album['thumbnail_url'])): ?>
                                <img src="/public/cdn/images/<?php echo $album['thumbnail_url']; ?>" alt="<?php echo $album['title']; ?>">
                            <?php else: ?>
                                <img src="/public/image/footer_lodyas.png" alt="<?php echo $album['title']; ?>">
                            <?php endif; ?>
                        </a>
                    <?php
                        endforeach;
                        if (count($albums) == 0):
                    ?>
                        Aucun album à afficher.
                    <?php elseif (count($albums) == 14): ?>
                        <span><a href="/user-albums/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
                    <?php endif; ?>
                </p>
                <h2><a href="/user-pictures/<?php echo $user->getId(); ?>">Ses photos</a></h2>
                <p class="photos-fav">
                    <?php
                    foreach ($pictures as $picture):
                        $commu = new Community();
                        $commu = $commu->populate(['id' => $picture['community_id']]);
                    ?>
                        <a href="/<?php echo $commu->getSlug(); ?>/picture/<?php echo $picture['id']; ?>"><img src="/public/cdn/images/<?php echo $picture['url']; ?>" alt="<?php echo $picture['title']; ?>"></a>
                    <?php
                        endforeach;
                        if (count($pictures) == 0):
                    ?>
                    Aucune photo à afficher.
                    <?php elseif (count($pictures) == 14): ?>
                        <span><a href="/user-pictures/<?php echo $user->getId(); ?>" class="wall-more">...</a></span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-8 col-m-12">
        <div class="timeline">
            <div class="timeline-story">
                <?php
                    foreach ($actions as $action):
                        $action_date = strtotime($action['created_at']);
                        $commu = new Community();
                        $commu = $commu->populate(['id' => $action['community_id']]);
                ?>
                <div class="story">
                    <p>
                        <?php
                            switch ($action['type_action']) {
                                case "signup":
                                    $signUp = new User();
                                    $signUp = $signUp->populate(['id' => $action['related_id']]);
                                    echo $signUp->getUsername() . " a rejoint Smart-Pix. Bienvenue !";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "create-community":
                                    $createdCommu = new Community();
                                    $createdCommu = $createdCommu->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a créé une nouvelle communauté : <a href="/<?php echo $createdCommu->getSlug(); ?>"><?php echo $createdCommu->getName(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "join-community":
                                    $joinedCommu = new Community();
                                    $joinedCommu = $joinedCommu->populate(['id' => $action['related_id']]); ?>
                                    <?php echo $user->getUsername(); ?> a rejoint une communauté : <a href="/<?php echo $joinedCommu->getSlug(); ?>"><?php echo $joinedCommu->getName(); ?></a>
                                    <?php echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "picture":
                                    $picture = new Picture();
                                    $picture = $picture->populate(['id' => $action['related_id']]);
                                    echo $user->getUsername() . " a ajouté une nouvelle image : <a href=\"/".$commu->getSlug()."/picture/".$action['related_id']."\">".$picture->getTitle()."</a> dans la communauté <a href=\"/".$commu->getSlug()."\">".$commu->getName()."</a>";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;

                                case "album":
                                    $album = new Album();
                                    $album = $album->populate(['id' => $action['related_id']]);
                                    echo $user->getUsername() . " a ajouté un nouvel album : <a href=\"/".$commu->getSlug()."/album/".$action['related_id']."\">".$album->getTitle()."</a> dans la communauté <a href=\"/".$commu->getSlug()."\">".$commu->getName()."</a>";
                                    echo "<span class=\"action-date\">le ".date("d/m/Y", $action_date)." à ".date("G:i:s", $action_date)."</span>";
                                    break;
                                default:
                                    break;
                            }
                        ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
<!--        <div class="loading">-->
<!--            <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>-->
<!--            <span class="sr-only">Loading...</span>-->
<!--        </div>-->
    </div>
</div>

<script>
    function loadActions(actions, count, limit) {
        $.each(actions, function () {
            if (count >= limit)
                return false;
            $(this).fadeIn("slow");
            count++;
        });
    }
    $(document).ready(function() {
        var win = $(window);
        var actions = $('.story');
        var limit = 10;
        var count = 0;
        console.log(actions.length);
        actions.hide();
        loadActions(actions, count, limit);

        $('.loading').hide();

        win.scroll(function() {
            // Test si on a atteint le bas de page :
            if ($(document).height() - win.height() == Math.ceil(win.scrollTop())) {
                limit += 10;
                loadActions(actions, count, limit);
            }
        });
    });
</script>
