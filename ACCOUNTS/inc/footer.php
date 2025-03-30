<footer>
    <?php
if ($pageid !== 'display-document') {
    echo "<a  href = '../../data/images/download-files/ACCOUNTS.zip'><br>Download Code<br></a>";
    echo "<br>Copyright &copy; " .  date('Y') ." Susan Rodgers, <a href = 'https://lilaavenue.com'>Lila Avenue</a><br><br><br><br>";
}
?>

</div>
<script>
function accordionToggle(bttn) { 
    ///Used tp display sections in  Control Panel 
    var x = document.getElementById(bttn+"-content");    
    if (x.style.display === "block"  ) {
         x.style.display = 'none';
     }
     else {
         x.style.display = 'block';
     }
}
</script>
  
</footer>
</body>
</html>