<?php if($picture->getIsVisible() == 0): ?>
    <style>
        .fa-flag{
            cursor: pointer;
        }
        .fa-flag:hover{
            color: rgb(189, 16, 16);
        }
    </style>
<div class="row">

            <div class="col-9 col-m-12 image-center">
                <!-- La photo ! -->
                <img src="/public/cdn/images/<?php echo $picture->getUrl(); ?>" alt="">
            </div>
            <div class="col-3 col-m-12 align-left picture-info-panel">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $author->getId()): ?>
                <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/edit-picture/<?php echo $picture->getId(); ?>" class="btn edit-picture">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <?php endif; ?>
                <!-- Info photo & photographe -->
                <h2><?php echo $picture->getTitle(); ?></h2>
                <h3 class="italic">Par <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $author->getId(); ?>"><?php echo $author->getUsername(); ?></a></h3>
                <p><?php echo $picture->getDescription(); ?></p>
                    <?php if (isset($tagsId) && !empty($tagsId)): ?>
                        <hr>
                        <p class="picture-tags">
                            Tags :
                    <?php
                        foreach ($tagsId as $tagId):
                            $tag = new Tag();
                            $tag = $tag->populate(['id' => $tagId['tag_id']]);
                    ?>
                    <span><a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/tag/<?php echo $tag->getId(); ?>/<?php echo $tag->getSlug(); ?>"><?php echo $tag->getTitle(); ?></span></a>
                    <?php endforeach; ?>
                </p>
                <?php endif; ?>
            </div>
</div>

<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <p>
        <?php if (count($albums) > 1):
            echo "Cette image fait partie des albums suivants :";
        elseif (count($albums) == 1):
            echo "Cette image fait partie de l'album :";
        else:
            echo "Cette image ne fait partie d'aucun album.";
        endif; ?>

        <?php
        $i = 1;
        foreach ($albums as $album): ?>
            <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/album/<?php echo $album['id']; ?>"><?php echo $album['title']; ?></a>
            <?php
            if ($i != count($albums)) echo "- ";
            $i++;
            ?>
        <?php endforeach; ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <h2>Commentaires :</h2>
        <?php if(isset($comments)):
            foreach ($comments as $comment):
                $createdAt = strtotime($comment['created_at']);
                $commentAuthor = new User();
                $commentAuthor = $commentAuthor->populate(['id' => $comment['user_id']]);

                $c = new Comment;
                $c = $c->populate(['user_id'=>$_SESSION['user_id']])
                ?>

                <div class="comment">
                    <p class="comment-author">
                        <?php if (!empty($commentAuthor->getAvatar())): ?>
                            <img src="/public/cdn/images/avatars/<?php echo $commentAuthor->getAvatar(); ?>" class="comment-avatar" alt="Avatar de <?php echo $commentAuthor->getUsername(); ?>">
                        <?php else: ?>
                            <i class="fa fa-user comment-no-avatar" aria-hidden="true"></i>
                        <?php endif; ?>
                        <a href="<?php echo isset($community) ? "/".$community->getSlug() : ""; ?>/user/<?php echo $commentAuthor->getId(); ?>"><?php echo $commentAuthor->getUsername(); ?></a>
                    </p>
                    <p class="comment-time">le <?php echo date("d/m/Y", $createdAt); ?> à <?php echo date("G:i:s", $createdAt); ?>&nbsp;&nbsp;
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <i class="fa fa-flag" data-id="<?php echo $comment['id'] ?>"
                             <?php echo ($c->isFlaged($_SESSION['user_id'], $comment['id']))? 'style="color: red"' : ''; ?>
                             aria-hidden="true"></i>
                        <?php endif; ?>
                    </p>
                    <p class="comment-content"><?php echo $comment['content']; ?></p>
                </div>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <?php if(isset($unpublishedComments)): ?>
        <div class="col-12">
            <p>Vous avez déjà un message en attente de validation sur cette photo</p>
        </div>
    <?php else: ?>
        <div class="col-2"></div>
        <div class="col-8">
            <form action="/add-comment" method="post" class="form-group">
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <textarea name="content" required="required"></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    <?php endif; ?>

    <?php else: ?>
        <p>Cette photo est actuellement en modération !</p>
    <?php endif; ?>
</div>
<script>
    $('.fa-flag').click(function(){
        $this = $(this);
        if($this.css('color') == 'rgb(255, 0, 0)'){
            $.ajax({
                url: '/unFlagComment',
                method: 'POST',
                dataType: 'json',
                data: {id: $this.data('id')},
                success: function(data){
                    $this.css('color','grey');
                    $('body').append(data);
                    flash();
                }
            });
        } else {
            var c = confirm('Êtes vous sur de vouloir signaler ce commentaire ?');
            if (c = true){
                    $.ajax({
                        url: '/flagComment',
                        method: 'POST',
                        dataType: 'json',
                        data: {id: $this.data('id')},
                        success: function(data){
                            $this.css('color', 'rgb(255, 0, 0)');
                            $('body').append(data);
                            flash();
                        }
                    });
            }
        }
    });
</script>
