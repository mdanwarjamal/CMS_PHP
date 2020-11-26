<?php
  function find_all_subjects($options=[]){
    global $db;
    $visible = $options['visible'] ?? false;

    $query = "SELECT * FROM subjects ";
    if($visible){
        $query .= "WHERE visible = true ";
    }
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
  function find_subject_by_id($id,$options=[]){
    global $db;

    $visible = $options['visible'] ?? false;
    $query = "SELECT * FROM subjects ";
    $query .= "WHERE id='" . db_escape($db,$id) ."' ";
    if($visible){
      $query .= "AND visible = true";
    }
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
  function find_page_by_id($id,$options=[]){
    global $db;

    $visible = $options['visible'] ?? false;
    $preview = $options['preview'] ?? false;

    if($preview){
      $visible = false;
    }
    $query = "SELECT * FROM pages ";
    $query .= "WHERE id='" . db_escape($db,$id) ."' ";
    if($visible){
      $query .= "AND visible = true ";
    }
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

  function find_pages_by_subject_id($subject_id,$options=[]){
    global $db;

    $visible = $options['visible'] ?? false;

    $query = "SELECT * FROM pages ";
    $query .= "WHERE subject_id='" . db_escape($db,$subject_id) ."' ";
    if($visible){
        $query .= "AND visible = true ";
    }
    $query .= "ORDER BY position ASC";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    return $result;
  }
  function find_first_page_id_with_subject_id($subject_id,$options){
    global $db;

    $visible = $options['visible'] ?? false;

    $query = "SELECT * FROM pages ";
    $query .= "WHERE subject_id='" . db_escape($db,$subject_id) ."' ";
    if($visible){
        $query .= "AND visible = true ";
    }
    $query .= "ORDER BY position ASC ";
    $query .= "LIMIT 1";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $page = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $page['id'];
  }

  function validate_admin($admin,$options) {

    $errors = [];
    $paswword_required = $options['password_required']??true;
    //first_name
    if(is_blank($admin['first_name'])){
      $errors[] = "First Name cannot be blank.";
    }
    else if(!has_length($admin['first_name'], ['min' => 2, 'max' => 255])){
      $errors[] = "First Name must be between 2 and 255 characters.";
    }
    //last_name
    if(is_blank($admin['last_name'])){
      $errors[] = "Last Name cannot be blank.";
    }
    else if(!has_length($admin['last_name'], ['min' => 2, 'max' => 255])){
      $errors[] = "Last Name must be between 2 and 255 characters.";
    }


    //Email

    if(is_blank($admin['email'])){
      $errors[] = "Email field must not be blank.";
    }
    else if(!has_length($admin['email'],['max'=>255])){
      $errors[] = "Email must be atmost 255 characters.";
    }
    else if(!has_valid_email_format($admin['email'])){
      $errors[] = "Email must be in valid format";
    }
    // username
    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    }
    elseif(!has_length($admin['username'], ['min' => 8, 'max' => 255])) {
      $errors[] = "Username must be between 8 and 255 characters.";
    }
    elseif(!has_unique_admin_username($admin['username'],$admin['id'] ?? 0)) {
      $errors[] = "Username must be unique.";
    }

    //password

    if($password_required){
      if(!has_length($admin['hashed_password'],['min'=>12])){
        $errors[] = "Password must be of minimum 12 characters";
      }
      else if(!has_correct_password_format($admin['hashed_password'])){
        $errors[] = "Password must contain 1 atleast uppercase, 1 atleast lowercase, 1 atleast number, and 1 atleast symbol";
      }

      //match Password

      if(is_blank($admin['confirm_password'])){
        $errors[] = "Must enter password to confirm";
      }else if($admin['hashed_password'] !== $admin['confirm_password']){
        $errors[] = "Password and Confirm password must match";
      }
    }


    return $errors;
  }

  function find_all_admins(){
    global $db;

    $query = "SELECT * FROM admins ";
    $query .= "ORDER BY id ASC";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    return $result;
  }

  function find_admin_by_id($id){
    global $db;

    $query = "SELECT * FROM admins ";
    $query .= "WHERE id='" . db_escape($db,$id) ."'";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin;
  }

  function find_admin_by_username($username){
    global $db;

    $query = "SELECT * FROM admins ";
    $query .= "WHERE username='" . db_escape($db,$username) ."' ";
    $query .= "LIMIT 1";
    $result = mysqli_query($db,$query);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $admin;
  }

  function update_admin($admin){
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin,['password_required'=>$password_sent]);

    if(!empty($errors)){
      return $errors;
    }

    $admin['hashed_password'] = password_hash($admin['hashed_password'],PASSWORD_BCRYPT);

    $query = "UPDATE admins SET ";
    $query .= "first_name='" . db_escape($db,$admin['first_name']) ."', ";
    $query .= "last_name='" . db_escape($db,$admin['last_name']) ."', ";
    $query .= "email='" . db_escape($db,$admin['email']) ."', ";
    if($password_sent){
        $query .= "hashed_password='" . db_escape($db,$admin['hashed_password']) ."', ";
    }
    $query .= "username='" . db_escape($db,$admin['username']) ."' ";


    $query .= "WHERE id='" . db_escape($db,$admin['id']) . "' ";
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

  function insert_admin($admin){
    global $db;

    $errors = validate_admin($admin);

    if(!empty($errors)){
      return $errors;
    }

    // $admin['password'] = $admin['hashed_password'];
    $admin['hashed_password'] = password_hash($admin['hashed_password'],PASSWORD_BCRYPT);

    $query = "INSERT INTO admins ";
    $query .= "(first_name,last_name,email,username,hashed_password) ";
    $query .= "VALUES (";
      $query .= "'" . db_escape($db,$admin['first_name']) ."', ";
      $query .= "'"  . db_escape($db,$admin['last_name']) ."', ";
      $query .= "'"  . db_escape($db,$admin['email']) ."', ";
      $query .= "'" . db_escape($db,$admin['username']) ."', ";
      $query .= "'" . db_escape($db,$admin['hashed_password']) ."'";
    $query .=")";

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

  function delete_admin($id){
    global $db;

    $query = "DELETE FROM admins ";
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
?>
