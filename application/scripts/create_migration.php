<?php
    // create file migration    
    $timestamp = gmdate("YmdHis");
    $name = getopt(null, ["name:"])["name"];
    $migration_path = "../migrations/";
    $migration_name = $migration_path . $timestamp . "_create_" . $name . ".php";
    
    if ($name != '') {
        // modify file template/migration_template.php appropriate to migration's name
        $migration_file = "template/migration_template.php";
        $text_in_migration_file = file_get_contents($migration_file);

        // replace table and controller's name
        $text_in_migration_file = str_replace("template", $name, $text_in_migration_file);
        file_put_contents($migration_file, $text_in_migration_file);

        copy("template/migration_template.php", $migration_name);

        // replace table and controller's name to default
        $text_in_migration_file = str_replace($name, "template", $text_in_migration_file);
        file_put_contents($migration_file, $text_in_migration_file);
    } else {
        echo "please use --name to specify migration's name";
    }
?>
