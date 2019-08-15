<?

  if (preg_match("/sched_igb.php/i", $PHP_SELF)) {
      echo "You can not access this file directly!";
      die();
  }

  $exponinter = mypw($ibank_interest + 1, $multiplier);
  $expoloan = mypw($ibank_loaninterest + 1, $multiplier);

  echo "<B>IBANK</B><p>";

  $ibank_result = $db->Execute("UPDATE $dbtables[ibank_accounts] SET balance=balance * $exponinter, loan=loan * $expoloan");
  echo "All IGB accounts updated ($multiplier times).<p>";

  $multiplier = 0;

?>
