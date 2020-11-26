<?php require_once '../private/initialize.php'; ?>

<?php
  $page=null;
  $preview = false;

  if(isset($_GET['preview'])){
    // $preview_page_id = $_GET['id'];
    // $preview_page = find_page_by_id($preview_page_id,['visible'=>true,'preview'=>true]);
    // if(!$preview_page){
    //   redirect_to(url_for('index.php'));
    // }
    $preview = $_GET['preview'] == 'true' && is_logged_in() ? true:false;
  }
  $visible = !$preview;

  if(isset($_GET['id'])){
    $page_id = $_GET['id'];
    $page = find_page_by_id($page_id,['visible'=>$visible]);
    if(!$page){
      redirect_to(url_for('index.php'));
    }
    $subject_id = $page['subject_id'];
  }
  if(isset($_GET['subject_id'])){
    $subject_id = $_GET['subject_id'];
    $subject = find_subject_by_id($subject_id,['visible'=>$visible]);
    if(!$subject){
      redirect_to(url_for('index.php'));
    }
  }

?>

<?php include SHARED_PATH . '/public_header.php'; ?>

<div id="main">
  <?php include SHARED_PATH . '/public_navigation.php'; ?>
  <div id="page">
    <?php
      if(isset($preview_page)){
        $allowed_tags = "<div><img><h1><h2><p><br><strong><em><ul><li><a>";
        //add h()
        echo strip_tags($preview_page['content'],$allowed_tags);
      }
      else if(isset($page)){
        $allowed_tags = "<div><img><h1><h2><p><br><strong><em><ul><li><a>";
        //add h()
        echo strip_tags($page['content'],$allowed_tags);
      }
      else{
        include SHARED_PATH . '/static_homepage.php';
      }

    ?>
  </div>
</div>
<?php include SHARED_PATH . '/public_footer.php'; ?>
