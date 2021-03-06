<?php

class PictureController {

    public function checkCommunity($community) {
        if (!empty($community)) {
            $commu = new Community();
            $commu = $commu->populate(['slug' => $community]);
            if (!$commu) {
                $_SESSION['messages']['error'][] = "La communauté n'a pas été trouvée";
                $v = new View("404", "frontend");
                return 0;
            }
            return $commu;
        }
    }

    /*
     * Ajout d'une image par un user (/picture/create)
     */
    public function add() {
        $v = new View("picture.create", "frontend");
        $v->assign('title', "Ajout d'une image");
        if ($_POST) {
            $title = htmlspecialchars(trim($_POST['title']));
            $description = htmlspecialchars(trim($_POST['description']));
            $picture = new Picture();

            if (!empty($title) && !empty($description)) {
                $picture->setUserId($_SESSION['user_id']);
                $picture->setAlbumId(null);
                $picture->setTitle($title);
                $picture->setDescription($description);
                if (isset($_FILES["picture"])) {
                    if ($_FILES['picture']['error'] > 0) {
                        if ($_FILES['picture']['error'] == 1 || $_FILES['picture']['error'] == 2)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image est trop volumineux (max: 5 Mo)";
                        elseif ($_FILES['picture']['error'] != 4)
                            $_SESSION['messages']['warning'][] = "Le fichier d'image a rencontré une erreur.";
                    } else {
                        $fileInfo = pathinfo($_FILES['picture']['name']);
                        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                        if (
                            strtolower($fileInfo["extension"]) == "jpg" ||
                            strtolower($fileInfo["extension"]) == "jpeg" ||
                            strtolower($fileInfo["extension"]) == "png" ||
                            strtolower($fileInfo["extension"]) == "gif"
                        ) {
                            $now = new DateTime("now");
                            $nowStr = $now->format("Y-m-d H:i:s");
                            $picture->setUrl($ext);
                            $picture->setWeight($_FILES['picture']['size']);
                            $picture->setIsVisible(0);
                            $picture->setCreatedAt($nowStr);
                            $picture->setUpdatedAt($nowStr);
                            $picture->save();
                            // Create related action
                            $action = new Action();
                            $action->setUserId($_SESSION['user_id']);
                            $action->setTypeAction("picture");
                            $action->setRelatedId($picture->getDb()->lastInsertId());
                            $action->setCreatedAt($nowStr);
                            $action->save();
                            move_uploaded_file($_FILES['picture']['tmp_name'], PATH_ABSOLUT."/public/cdn/images/".$picture->getUrl());
                            header("Location: ".PATH_RELATIVE."picture/".$picture->getDb()->lastInsertId());
                            $_SESSION['messages']['success'][] = "Votre image a été ajoutée";
                        } else {
                            $_SESSION['messages']['warning'][] = "Format d'image invalide<br>(essayez: .jpg, .jpeg, .png ou .gif)";
                        }
                    }
                } else {
                    $_SESSION['messages']['warning'][] = "Aucune image sélectionnée";
                }
            }

        }
    }

    public function tag($community = null, $id = null, $tagSlug = null) {
        $v = new View("picture.tag", "frontend");
        $commu = $this->checkCommunity($community);
        $tag = new Tag();
        $tag = $tag->populate(['id' => $id, 'slug' => $tagSlug]);
        $tagPicture = new Tag_Picture();
        $tagPicture = $tagPicture->getAllBy(['tag_id' => $tag->getId()]);
        $v->assign('community', $commu);
        $v->assign('tag', $tag);
        $v->assign('tagPictures', $tagPicture);
    }

    public function removeTag() {
        $removeTag = new Tag_Picture();
        $removeTag->deleteOneBy(['tag_id' => $_POST['tag_id'], 'picture_id' => $_POST['picture_id']]);
        $_SESSION['messages']['success'][] = "Le tag a bien été retiré de l'image";
        GlobalController::flash('json');
        exit();
    }

}
