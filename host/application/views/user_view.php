<?php


foreach ($users as $user) :?>
<h1>
#<?php echo $user->id;?>
Username: <?php echo $user->username;?>

password :<?php echo $user->password;?>
</h1>

<?php endforeach; ?>