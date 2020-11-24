<?php
  function find_all_subjects(){
    global $db;
    $query = "SELECT * FROM subjects ";
    $query .= "ORDER BY position ASC";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    return $result;
  }
  function get_menu_name($id){
    global $db;

    $query = "SELECT menu_name FROM subjects ";
    $query .= "WHERE id='" . db_escape($db,$id) ."'";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject['menu_name'];
  }
  function find_subject_by_id($id){
    global $db;

    $query = "SELECT * FROM subjects ";
    $query .= "WHERE id='" . db_escape($db,$id) ."'";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject;
  }
  function validate_subject($subject) {

    $errors = [];

    // menu_name
    if(is_blank($subject['menu_name'])) {
      $errors[] = "Name cannot be blank.";
    }
    elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int) $subject['position'];
    if($postion_int <= 0) {
      $errors[] = "Position must be greater than zero.";
    }
    if($postion_int > 999) {
      $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $subject['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }

    return $errors;
  }

  function insert_subject($subject){
    global $db;

    $errors = validate_subject($subject);

    if(!empty($errors)){
      return $errors;
    }

    $query = "INSERT INTO subjects ";
    $query .= "(menu_name,position,visible) ";
    $query .= "VALUES (";
    $query .= "'" . db_escape($db,$subject['menu_name']) . "',";
    $query .= "'" . db_escape($db,$subject['position']) . "',";
    $query .= "'" . db_escape($db,$subject['visible']) . "'";
    $query .= ")";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function update_subject($subject){
    global $db;

    $errors = validate_subject($subject);

    if(!empty($errors)){
      return $errors;
    }

    $query = "UPDATE subjects SET ";
    $query .= "menu_name='" . db_escape($db,$subject['menu_name']) ."', ";
    $query .= "position='" . db_escape($db,$subject['position']) ."', ";
    $query .= "visible='" . db_escape($db,$subject['visible']) ."' ";
    $query .= "WHERE id='" . db_escape($db,$subject['id']) . "' ";
    $query .= "LIMIT 1";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_subject($id){
    global $db;

    $query = "DELETE FROM subjects ";
    $query .= "WHERE id='" . db_escape($db,$id) . "' ";
    $query .= "LIMIT 1";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function find_all_pages(){
    global $db;
    $query = "SELECT * FROM pages ";
    $query .= "ORDER BY subject_id ASC,position ASC";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    return $result;
  }
  function find_page_by_id($id){
    global $db;

    $query = "SELECT * FROM pages ";
    $query .= "WHERE id='" . db_escape($db,$id) ."'";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page;
  }
  function validate_page($page) {

    $errors = [];




    // menu_name
    if(is_blank($page['menu_name'])) {
      $errors[] = "Name cannot be blank.";
    }
    elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ??'0';
    if(!has_unique_page_menu_name($page['menu_name'],$current_id)){
      $errors[] = "Menu name must be unique";
    }

    // position
    // Make sure we are working with an integer
    $postion_int = (int) $page['position'];
    if($postion_int <= 0) {
      $errors[] = "Position must be greater than zero.";
    }
    if($postion_int > 999) {
      $errors[] = "Position must be less than 999.";
    }

    // visible
    // Make sure we are working with a string
    $visible_str = (string) $page['visible'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }
    //content
    if(is_blank($page['content'])) {
      $errors[] = "Content cannot be blank.";
    }

    return $errors;
  }
  function insert_page($page){
    global $db;

    $errors = validate_page($page);

    if(!empty($errors)){
      return $errors;
    }

    $query = "INSERT INTO pages ";
    $query .= "(subject_id,menu_name,position,visible,content) ";
    $query .= "VALUES (";
    $query .= "'" . db_escape($db,$page['subject_id']) . "',";
    $query .= "'" . db_escape($db,$page['menu_name']) . "',";
    $query .= "'" . db_escape($db,$page['position']) . "',";
    $query .= "'" . db_escape($db,$page['visible']) . "',";
    $query .= "'" . db_escape($db,$page['content']) . "'";
    $query .= ")";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function update_page($page){
    global $db;

    $errors = validate_page($page);

    if(!empty($errors)){
      return $errors;
    }

    $query = "UPDATE pages SET ";
    $query .= "subject_id='" . db_escape($db,$page['subject_id']) ."', ";
    $query .= "menu_name='" . db_escape($db,$page['menu_name']) ."', ";
    $query .= "position='" . db_escape($db,$page['position']) ."', ";
    $query .= "visible='" . db_escape($db,$page['visible']) ."',";
    $query .= "content='" . db_escape($db,$page['content']) ."' ";
    $query .= "WHERE id='" . db_escape($db,$page['id']) . "' ";
    $query .= "LIMIT 1";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_page($id){
    global $db;



    $query = "DELETE FROM pages ";
    $query .= "WHERE id='" . db_escape($db,$id). "' ";
    $query .= "LIMIT 1";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      return true;
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function find_subject_for_page($id){
    global $db;

    $query = "SELECT menu_name FROM subjects ";
    $query .= "WHERE id=(";
      $query .= "SELECT subject_id FROM pages ";
      $query .= "WHERE id='" . db_escape($db,$id) ."'";
    $query .= ")";

    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    if($result){
      $subject = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $subject['menu_name'];
    }else{
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
?>
