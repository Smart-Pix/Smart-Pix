<?php
class Route{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];
    private $communities = false;

    public function __construct($path, $callable){
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }

    public function with($param, $regex){
        if($regex == 'communities'){
            $this->communities = true;
            $communities = new Community;
            $communities = $communities->getAllBy([]);
            $regex = '';
            foreach ($communities as $c) {
                $regex .= '('.str_replace('-','\-',$c['slug']).')|';
            }
        }
        $this->params[$param] = $regex;
        return $this;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '('. $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call(){
        $matches = array();
//        if($this->communities == true){
            //$this->matches = [reset($this->matches), end($this->matches)];
            for ($i = 0; $i < count($this->matches); $i++) {
//                if (isset($previous)) {
//                    if (strcmp($previous, $this->matches[$i]) !== 0 && !empty($this->matches[$i])) {
//                        $matches[] = $this->matches[$i];
//                    }
//                }
                if (!empty($this->matches[$i])) {
                    $matches[] = $this->matches[$i];
                }
                if (isset($matches[$i-1]) && isset($matches[$i]) && strcmp($matches[$i-1],$matches[$i]) == 0) {
                    unset($matches[$i]);
                }
//                $previous = $this->matches[$i];
            }

            $matches = array_unique($matches, SORT_REGULAR);
            $matches = array_values($matches);
//            var_dump($matches);
//        }
        if(is_string($this->callable)){
            Helpers::createLogExist();

            $params = explode('@', $this->callable);
            $controller = $params[0]."Controller";
            $controllerPath = "controllers".DS.$controller.".class.php";

            if( !file_exists($controllerPath) ){
                Helpers::log("Le controller ".$params[0]." n'existe pas");
                if(ENV == "PROD"){
                    header('Location:/404');
                }
                throw new RouterException("Le controller ".$params[0]." n'existe pas");
            }
            include $controllerPath;
            //Est ce que l'instanciation est possible
            if( !class_exists($controller) ){
                Helpers::log("L'instanciation de  ".$params[0]." n'est pas possible");
                if(ENV == "PROD"){
                    header('Location:/404');
                }
                throw new RouterException("L'instanciation de  ".$params[0]." n'est pas possible");
            }
            $controller = new $controller();
            //Est ce que la méthode existe à travers l'objet
            if( !method_exists($controller, $params[1]) ){
                Helpers::log("La méthode ". $params[1]." n'existe pas dans ". $params[0]);
                if(ENV == "PROD"){
                    header('Location:/404');
                }
                throw new RouterException("La méthode ". $params[1]." n'existe pas dans ". $params[0]);
            }
            return call_user_func_array([$controller, $params[1]], $matches);

//            return $controller->$params[1]();
        } else {
            return call_user_func_array($this->callable, $matches);
        }
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
