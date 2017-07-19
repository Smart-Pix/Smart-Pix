<?php

class CommunityController{

    public function __construct(){
        
    }

    public function checkName(){
        $name = $_POST['name'];
        $community = new Community;
        $community = $community->populate(['name' => $name]);
        $user = new User;
        $user = $user->populate(array('username' => $_SESSION['username']));
        if($community){
            echo json_encode('error');
        } else {
            echo json_encode('good');
        }
    }

    public function index(){
        $v = new View('community.index', 'frontend');
        $communities = new Community;
        $communities = $communities->getAllBy(array('user_id'=>$_SESSION['user_id']), "DESC");
        $v->assign('communities', $communities);
    }

    public function create(){
            $community = new Community('DEFAULT', $_SESSION['user_id'], $_POST['name'], $_POST['description']);
            $now = new DateTime("now");
            $nowStr = $now->format("Y-m-d H:i:s");
            $community->setCreatedAt($nowStr);
            $community->setUpdatedAt($nowStr);
            $community->save(true);
            $_SESSION['messages']['success'][] = "Nouvelle communauté crée !";
            Header("Location: /communities");
    }
}
