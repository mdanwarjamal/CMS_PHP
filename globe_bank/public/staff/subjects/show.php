<?php require_once '../../../private/initialize.php'; ?>
<?php
  require_login();
  $id = $_GET['id']??'1';
  $subject = find_subject_by_id($id);
?>
<?php $page_title = 'Show Subject' ?>
<?php require_once SHARED_PATH . '/staff_header.php'; ?>
<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>
  <div class="subject show">
    <!-- <div class="success" >
      <h3 style="color:green;"><?php //echo $_SESSION['status']??''; unset($_SESSION['status']); ?></h3>
    </div> -->
    <h1><?php echo h($subject['menu_name']); ?></h1>
    <div >
      <dl>
        <dt>Menu Name</dt>
        <dd><?php echo h($subject['menu_name']); ?></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd><?php echo h($subject['position']); ?></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd><?php echo $subject['visible'] == 1?'true':'false'; ?></dd>
      </dl>
    </div>
  </div>

</div>
<?php require_once SHARED_PATH . '/staff_footer.php'; ?>
