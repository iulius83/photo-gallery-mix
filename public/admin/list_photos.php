<?php
require_once('../../includes/initialize.php');
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php

// 1. the current page number ($current_page)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// 2. records per page ($per_page)
$per_page = 5;

// 3. total record count ($total_count)
$total_count = Photograph::count_all();

$pagination = new Pagination($page, $per_page, $total_count);

// instead of finding all records, just find the records for this page
$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);


  // Find all the photographs - pagination used instead
  // $photos = Photograph::find_all();
?>
<?php include_layout_template('admin_header.php') ?>
<a href="index.php">&laquo; Back</a><br />

<h2>Photographs</h2>

<?php echo output_message($message); ?>

<br />

<div id="pagination" style="clear: both;">
<?php
if ($pagination->total_pages() > 1) {

  if ($pagination->has_previous_page()) {
    echo "<a href=\"list_photos.php?page=";
    echo $pagination->previous_page();
    echo "\">&laquo; Previous</a> ";
  } else {
    echo "&laquo; Previous";
  }
  for ($i=1; $i <= $pagination->total_pages(); $i++) {
    if ($i == $page) {
      echo " <span class=\"selected\">{$i}</span>";
    } else {
      echo " <a href=\"list_photos.php?page={$i}\">{$i}</a> ";
    }
  }
  if ($pagination->has_next_page()) {
    echo "<a href=\"list_photos.php?page=";
    echo $pagination->next_page();
    echo "\">Next &raquo;</a> ";
  } else {
    echo " Next &raquo;";
  }
}
?>
</div>

<br />

<table id="tableData">
  <thead>
    <th>Image</th>
    <th>Filename</th>
    <th>Caption</th>
    <th>Size</th>
    <th>Type</th>
    <th>Comments</th>
    <th>&nbsp;</th>
  </thead>
<?php foreach($photos as $photo): ?>
  <tr>
    <td><img src="../<?php echo $photo->image_path() ?>" width="150" /></td>
    <td><?php echo $photo->filename; ?></td>
    <td><?php echo $photo->caption; ?></td>
    <td><?php echo $photo->size_as_text(); ?></td>
    <td><?php echo $photo->type; ?></td>
    <td>
      <a href="comments.php?id=<?php echo $photo->id; ?>">
        <?php echo count($photo->comments()); ?>
      </a>
    </td>
    <td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a></td>
  </tr>
<?php endforeach; ?>
</table>

<br />

<a href="photo_upload.php">Upload a new Photograph</a>

<?php include_layout_template('admin_footer.php') ?>
