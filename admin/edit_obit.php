<?php include 'includes/header.php'; ?>
<?php
  $id = $_GET['id'];

  // create DB object
  $db = new Database();

  // create obituaries query
  $query = "SELECT * FROM tblObits WHERE id = ".$id;
  //run query
  $obit = $db->select($query)->fetch_assoc();

?>

<?php
  // if submit button is pressed
  if(isset($_POST['submit'])){
    //assign variables
    $name = mysqli_real_escape_string($db->link, $_POST['name']);
    $obituary = mysqli_real_escape_string($db->link, $_POST['obituary']);
    $birthdate = mysqli_real_escape_string($db->link, $_POST['dob']);
    $deathdate = mysqli_real_escape_string($db->link, $_POST['dod']);
    // simple validation
    if($name == ''|| $obituary == ''|| $birthdate ==''|| $deathdate == ''){
      // set error
      $error = 'Please fill out all required fields.';
    } else {
      // or update the values
      $query = "UPDATE tblObits
                SET Name = '$name',
                    Obituary = '$obituary',
                    BirthDate = '$birthdate',
                    DeathDate = '$deathdate'                      
                WHERE id = " .$id;

      $update_row = $db->update($query);
    }
  }
?>

<?php
  // if delete button is pressed
  if(isset($_POST['delete'])){
    // call delete method
    $query = "DELETE FROM tblObits
              WHERE id = " .$id;
    $delete_row = $db->delete($query);

    $filename = "../images/obits/".$obit['ImagePath'];
    unlink($filename);

  }
?>
<h2 class="page-header">Edit <?php echo $obit['Name']; ?>'s Obituary</h2>
<div class="row">
  <div class="col-md-8">
    <form method="post" action="edit_obit.php?id=<?php echo $id; ?>">
      <div class="form-group">
        <label>Name</label>
        <input name="name" type="text" class="form-control" placeholder="Enter name" value="<?php echo $obit['Name']; ?>">
      </div>
      <div class="form-group">
        <label>Obituary</label>
        <textarea name="obituary" class="form-control" placeholder="Enter obituary">
          <?php echo $obit['Obituary']; ?>
        </textarea>
      </div>
      <div class="form-group">
        <label>Date Of Birth</label>
        <input name="dob" type="date" class="form-control" placeholder="Enter date of birth" value="<?php echo $obit['BirthDate']; ?>">
      </div>
      <div class="form-group">
        <label>Date Of Death</label>
        <input name="dod" type="date" class="form-control" placeholder="Enter date of death" value="<?php echo $obit['DeathDate']; ?>">
      </div>
      <div>
        <input name="submit" type="submit" class="btn btn-default" value="Submit" />
        <a href="index.php" class="btn btn-default">Cancel</a>
        <input name="delete" type="submit" class="btn btn-danger delete" value="Delete" />
      </div>  
      <br>
    </form>
    <div>
      <?php echo $error; ?>
    </div>
  </div>
  <div class="col-md-4">
    <img class="img-thumbnail img-responsive" src="../images/obits/<?php echo $obit['ImagePath']; ?>" alt="<?php echo $obit['Name']; ?>"/>
  </div>
</div> <!-- .row -->
<?php include 'includes/footer.php'; ?>