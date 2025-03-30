<?php

$accountid =  getFromQueryString ('account');

$accountrecord = readDatabaseRecord($accountrecordkeys, 'data/accounts/' . $accountid . '.txt');
echo "<div class = 'content-column'>";
echo "<h2>Account: </h2>";

echo "<b>Name: </b>" . $accountrecord['name'];
echo "<br><br><b>URL: </b><a href = '" . $accountrecord['url'] . "'><b>" . $accountrecord['url'] . "</b></a>";
echo "<br><br><b>Username: </b>" . $accountrecord['username'];
echo "<br><br><b>Password: </b>" . $accountrecord['password'];
$selectedarray = selectMapEntries ('data/category-account-map.txt', '', $accountid);
$selectedstring = implode (',',$selectedarray);
echo "<br><br><b>Categories: </b>" . $selectedstring;
echo "<br><br><b>Details: </b>" . nl2br($accountrecord['details']);
echo "</div><div class = 'sidebar-column'>";
echo "<a class = 'adminbutton' href = 'index.php'>&larr; Home</a>";
echo "<a class = 'adminbutton' href = 'index.php?page=add-update-account&account=" . $accountid ."'>Edit</a>";


  ?>
  