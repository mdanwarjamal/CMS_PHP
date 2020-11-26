<?php

require_once('../../../private/initialize.php');
require_login();
$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set) + 1;
mysqli_free_result($page_set);

$subject_set = find_all_subjects();
$subject_count = mysqli_num_rows($subject_set);
mysqli_free_result($subject_set);

$page =[];
$page['position'] = $page_count;

$subject_id = '';
$menu_name='';
$position='';
$visible='';
$content='';
$page['subject_id'] =  '';
$page['menu_name'] = '';
$page['position'] =  '';
$page['visible'] =  '';
$page['content'] ='';
if(is_post_request()){
  $page['subject_id'] = $_POST['subject_id'] ?? '';
  $page['menu_name'] = $_POST['menu_name'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content']??'';
  $result = insert_page($page);
  if($result === true){
    $new_id = mysqli_insert_id($db);
    $_SESSION['status'] = 'Successfully created a new page';
    redirect_to(url_for('/staff/pages/show.php?id=' . $new_id));
  }else{
    $errors = $result;
  }
}
?>

<?php $page_title = 'Create Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

  <div class="subject new">
    <h1>Create Page</h1>
    <?php echo display_errors($errors); ?>
    <form action="<?php echo url_for('/staff/pages/new.php') ?>" method="post">
      <!-- <dl>
        <dt>Subject ID</dt>
        <dd><input type="text" name="subject_id" value="" /></dd>
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
        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>" /></dd>
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
          <textarea name="content" rows="8" cols="80"></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
