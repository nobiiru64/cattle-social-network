<?php

namespace Nobiiru;


class View {

    public function render($file, $template = 'default',$data = []) {
        $userstr = ' (Guest)';
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
            $this->loggedin = TRUE;
            $userstr = " ($this->user)";
        } else {
            $this->loggedin = FALSE;
        }

        if(is_array($data)) extract($data);

        include_once "../resources/view/{$template}/_header.php";
        include_once "../resources/view/{$template}/{$file}.php";
        include_once "../resources/view/{$template}/_footer.php";
    }


    public function redirect($link) {
        header('Location: /'.$link);
    }
}
