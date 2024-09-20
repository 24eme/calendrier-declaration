<?php

function getCommit() {
    if(!file_exists(__DIR__.'/../.git/HEAD')) {

        return null;
    }

    $head = str_replace(["ref: ", "\n"], "", file_get_contents(__DIR__.'/../.git/HEAD'));
    $commit = null;

    if(strpos($head, "refs/") !== 0) {
        $commit = $head;
    }

    if(file_exists(__DIR__.'/../.git/'.$head)) {
        $commit = str_replace("\n", "", file_get_contents(__DIR__.'/../.git/'.$head));
    }

    return substr($commit, 0, 7);
}
