<?php

    function showFlashMessage(){
        $_SESSION['flash'] = true;
    }

    function paginationLinks(array $data){

        if($data['current_page'] > 1){

            $prevPage = $data['current_page'] - 1;
            echo('<li class="page-item"><a class="page-link" href="' . $_ENV['BASE_URL'] . '/authors?page=' . $prevPage .'">Previous</a></li>');

        }else {
            echo('<li class="page-item"><a class="page-link disabled"">Previous</a></li>');
        }

        for ($i=1; $i <= $data['total_pages']; $i++){

            $className = 'page-link';
            $data['current_page'] == $i ? $className.= ' currentPage' : null;
            echo('<li class="page-item"><a class="' . $className .'" href="' . $_ENV['BASE_URL'] . '/authors?page=' . $i . '">' . $i . '</a></li>');
        }

        if ($data['current_page'] < $data['total_pages']){
        
            $nextPage = $data['current_page'] + 1;
            echo('<li class="page-item"><a class="page-link" href="' . $_ENV['BASE_URL'] . '/authors?page=' . $nextPage . '">Next</a></li>');

        }else {
            echo('<li class="page-item"><a class="page-link disabled">Next</a></li>');
        }
    }

    function dd($var)
    {
        ob_end_clean();
        $backtrace = debug_backtrace();

        echo "\n<pre>\n";

        if (isset($backtrace[0]['file'])) {
            $filename = $backtrace[0]['file'];
            $filename = explode('\\' , $filename);
            echo end($filename) . "\n\n";
        }

        echo "---------------------------------\n\n";
        var_dump($var);
        echo "</pre>\n";
        die;
    }