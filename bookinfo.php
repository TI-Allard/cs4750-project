This is <?php echo $_POST['book_to_view'];?>
<?php foreach ($_POST['book_to_view'] as $item): ?>
  <tr>
     <td><?php echo $item; ?></td>          
  </tr>
<?php endforeach; ?>