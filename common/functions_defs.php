<?php

function clean_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate_name(&$name, &$name_error) {
    $name = clean_data($_POST["name"]);
    if (empty(trim($_POST["name"]))) {
        $name_error = "Error: no name provided";
    }
    elseif (!preg_match("/^[a-zA-Z0-9-_]*$/", $name)) {
        $name_error = "Error: only letters, numbers, dash and underscore";
    }
    else {
        $name = clean_data($_POST["name"]);
    }
}

function validate_email(&$email, &$email_error) {
    $email = clean_data($_POST["email"]);
    if (empty($email)) {
        $email_error = "Error: email is required";
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Error: invalid email format";
        }
    }
}

function validate_username(&$username, &$username_error) {
    $username = clean_data($_POST["username"]);
    if (empty(trim($_POST["username"]))) {
        $username_error = "Error: no name provided";
    }
    elseif (!preg_match("/^[a-zA-Z0-9-_]*$/", $username)) {
        $username_error = "Username error: only letters, numbers, dash and underscore are allowed";
    }
    else {
        $username = clean_data($_POST["username"]);
    }
}

//function find_hash($username) {
//    $password_file = fopen("passwords.csv", "r") or die ("find_hash - Unable to open file passwords.csv");
//
//    while (($data = fgetcsv($password_file, 1000, ",")) !== FALSE) {
//        $count = count($data);
//        if ($count >= 2 && $data[0] == $username) {
//            fclose($password_file);
//            return $data[1];
//        }
//    }
//    fclose($password_file);
//    return "";
//}

function get_introdb_conn() {
    return new mysqli("localhost", "intro", "intro", "introdb");
}

function db_find_hash($conn, $username) {
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // if you expect only 1 result, don't loop, just get the only row
        $row = $result->fetch_row();
        return $row[0];
    } else {
        return "";
    }
}

function insert_user($conn, $username, $password, $email) {
    $stmt = $conn->prepare("insert into users(username, password, email) values (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);
    if (!$stmt->execute()) {
        return $stmt->error;
    } else {
        return "";
    }
}

function insert_new_game($conn, $target_file, $gamename, $subtitle, $description, $price) {
    $stmt = $conn->prepare("insert into vr_games(image, gamename, subtitle, description, price) values (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $target_file, $gamename, $subtitle, $description, $price);
    if (!$stmt->execute()) {
        return $stmt->error;
    } else {
        return "";
    }
}

function delete_game($conn, $game_id) {
    $stmt = $conn->prepare("DELETE FROM vr_games WHERE id = ?");
    $stmt->bind_param("s", $game_id);
    if (!$stmt->execute()) {
        return $stmt->error;
    } else {
        return "";
    }
}

function update_game($conn, $id, $target_file, $gamename, $subtitle, $description, $price ) {
    $stmt = $conn->prepare("UPDATE vr_games SET image=?, gamename=?, subtitle=?, description=?, price=? WHERE id= ?");
    $stmt->bind_param("sssssi", $target_file, $gamename, $subtitle, $description, $price, $id );
    if (!$stmt->execute()) {
        return $stmt->error;
    } else {
        return "";
    }
}

function validate_gamename(&$gamename, &$gamename_error) {
    $gamename = clean_data($_POST["gamename"]);
    if (empty(trim($_POST["gamename"]))) {
        $gamename_error = "Error: no game name provided";
    }
    else {
        $gamename = clean_data($_POST["gamename"]);
    }
}

function db_find_gamename($conn, $gamename) {
    $stmt = $conn->prepare("SELECT gamename FROM vr_games WHERE gamename = ?");
    $stmt->bind_param("s", $gamename);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // if you expect only 1 result, don't loop, just get the only row
        $row = $result->fetch_row();
        return $row[0];
    } else {
        return "";
    }
}