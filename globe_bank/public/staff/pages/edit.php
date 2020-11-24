<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])){
  redirect_to(url_for('/staff/pages/new.php'));
}
$id = $_GET['id'];
// $menu_name='';
// $position='';
// $visible='';
$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

$page = find_page_by_id($id);
$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set);
mysqli_free_result($page_set);

if(is_post_request()){
  $page =[];
  $page['id'] = $id;
  $page['subject_id'] = $_POST['subject_id']??'';
  $page['menu_name'] = $_POST['menu_name'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content']??'';

  $result = update_page($page);
  if($result === true){
    redirect_to(url_for('/staff/pages/show.php?id=' . $page['id']));
  }else{
    $errors = $result;
  }
}



?>

<?php $page_title = 'Edit Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject edit">
    <h1>Edit Page</h1>
    <?php echo display_errors($errors); ?>
    <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))) ?>" method="post">
      <!-- <dl>
        <dt>Subject ID</dt>
        <dd><input type="text" name="subject_id" value="<?php echo h($page['subject_id']) ?>" /></dd>
      </dl> -->
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id">
            <?php for($i=1;$i <= $subject_count; $i++): ?>
              <?php $curr_subject = get_menu_name($i); ?>
              <option value="<?php echo $i; ?>"  <?php echo $page['position'] == $i ?'selected':'' ?>><?php echo $curr_subject; ?></option>
            <?php endfor; ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php for($i=1;$i <= $page_count; $i++): ?>
              <option value="<?php echo $i; ?>"  <?php echo $page['position'] == $i ?'selected':'' ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" <?php echo $page['visible'] == 1 ? 'checked': '' ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" rows="8" cols="80"><?php echo $page['content'] ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
