<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once("vendor/autoload.php");
require_once("models/data-layer.php");

$f3 = Base::instance();

$f3->route("GET /", function() {
    $view = new Template();
    echo $view->render("views/app.html");
});

$f3->route("GET|POST /survey", function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST["name"];
        $checkbox = implode(", ", $_POST['checkbox']);
        if (empty($name) || empty($checkbox)) {
            echo "Please submit type in all inputs";
        } else {
            $f3->set('SESSION.name', $name);
            $f3->set('SESSION.checkbox', $checkbox);
            $f3->reroute("summary");
        }
    }
    $checkbox = getCheckboxes();
    $f3->set('checkbox', $checkbox);

    $view = new Template();
    echo $view->render("views/survey.html");
});

$f3->route("GET /summary", function() {
    $view = new Template();
    echo $view->render("views/summary.html");
});

$f3->run();
