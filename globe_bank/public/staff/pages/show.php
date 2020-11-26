<?php require_once '../../../private/initialize.php'; ?>
<?php
 require_login();
 $id = $_GET['id']??'1';
 $page = find_page_by_id($id);
 $subject = find_subject_for_page($id);
?>
<?php $page_title = 'Show Page' ?>
<?php require_once SHARED_PATH . '/staff_header.php'; ?>
<div id="content">
  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>
  <!-- <div class="success" >
    <h3 style="color:green;"><?php //echo $_SESSION['status']??''; unset($_SESSION['status']); ?></h3>
  </div> -->
  <div class="page show">
    <h1><?php echo h($page['menu_name']); ?></h1>
    <div class="actions">
      <a class="action" href="<?php echo url_for('/index.php?id=' . h(u($page['id'])) . "&preview=true"); ?>" target="_blank">Preview</a>
    </div>
    <div class="attributes">
      <dl>
        <dt>Subject</dt>
        <dd><?php echo h($subject); ?></dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><?php echo h($page['menu_name']); ?></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd><?php echo h($page['position']); ?></dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd><?php echo $page['visible'] == 1?'true':'false'; ?></dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <?php echo h($page['content']); ?>
        </dd>
      </dl>
    </div>
  </div>
</div>
<?php require_once SHARED_PATH . '/staff_footer.php'; ?>
