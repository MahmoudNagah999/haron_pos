
<?php          if ($user_Expenses !== "1" and $user_IsAdmin != 1) {}else{?>

<button onclick="javascript:location.href='expenses_set.php'" style="width:150px; height:50px;"><?php echo"$Expenses_lang"; ?></button>
<?php } ?>
<?php          if ($user_UsersAndPermissions !== "1" and $user_IsAdmin != 1) {}else{?>

<button onclick="javascript:location.href='users.php'" style="width:150px; height:50px;"><?php echo"$Users_permissions_lang"; ?></button>
<?php } ?>
<?php          if ($user_Groups !== "1" and $user_IsAdmin != 1) {}else{?>

<button onclick="javascript:location.href='groups.php'" style="width:100px; height:50px;"><?php echo"$the_Groups_lang"; ?></button>
<?php } ?>

<button onclick="javascript:location.href='branches.php'" style="width:100px; height:50px;"><?php echo"$the_branch_lang"; ?></button>
<button onclick="javascript:location.href='staff.php'" style="width:100px; height:50px;"><?php echo"$the_Staff_lang"; ?></button>
<button onclick="javascript:location.href='store.php'" style="width:100px; height:50px;"><?php echo"$the_Stores_lang"; ?></button>
<button onclick="javascript:location.href='safe.php'" style="width:100px; height:50px;"><?php echo"$the_safes_lang"; ?></button>
<button onclick="javascript:location.href='region.php'" style="width:100px; height:50px;"><?php echo"$the_regions_lang"; ?></button>
<button onclick="javascript:location.href='centers.php'" style="width:100px; height:50px;"><?php echo"المراكز"; ?></button>
<?php          if ($user_GeneralSettings !== "1" and $user_IsAdmin != 1) {}else{?>

<button onclick="javascript:location.href='config.php'" style="width:100px; height:50px;"><?php echo"$General_Settings_lang"; ?></button>
<?php } ?>
