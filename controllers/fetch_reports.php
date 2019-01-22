<?php
   include('connection.php');

   function formatBytes($bytes, $precision = 2) { 
      $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
  
      $bytes = max($bytes, 0); 
      $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
      $pow = min($pow, count($units) - 1); 
  
      // Uncomment one of the following alternatives
      $bytes /= pow(1024, $pow);
      // $bytes /= (1 << (10 * $pow)); 
  
      return round($bytes, $precision) . ' ' . $units[$pow]; 
   }

   function get_total_datetime($from, $to) {
      $workingDays = [1, 2, 3, 4, 5, 6, 7]; # date format = N
      $workingHours = ['from' => ['00', '01'], 'to' => ['24', '00']];
  
      $start = new DateTime($from);
      $end = new DateTime($to);
  
      $startP = clone $start;
      $startP->setTime(0, 0, 0);
      $endP = clone $end;
      $endP->setTime(23, 59, 59);
      $interval = new DateInterval('P1D');
      $periods = new DatePeriod($startP, $interval, $endP);
  
      $sum = [];
      foreach ($periods as $i => $period) {
          if (!in_array($period->format('N'), $workingDays)) continue;
  
          $startT = clone $period;
          $startT->setTime($workingHours['from'][0], $workingHours['from'][1]);
          if (!$i && $start->diff($startT)->invert) $startT = $start;
  
          $endT = clone $period;
          $endT->setTime($workingHours['to'][0], $workingHours['to'][1]);
          if (!$end->diff($endT)->invert) $endT = $end;
  
          #echo $startT->format('Y-m-d H:i') . ' - ' . $endT->format('Y-m-d H:i') . "\n"; # debug
  
          $diff = $startT->diff($endT);
          if ($diff->invert) continue;
          foreach ($diff as $k => $v) {
              if (!isset($sum[$k])) $sum[$k] = 0;
              $sum[$k] += $v;
          }
      }
  
      // if (!$sum) return 'ccc, no time on job?';
      if (!$sum) return '';
  
      $spec = "P{$sum['y']}Y{$sum['m']}M{$sum['d']}DT{$sum['h']}H{$sum['i']}M{$sum['s']}S";
      $interval = new DateInterval($spec);
      $startS = new DateTime;
      $endS = clone $startS;
      $endS->sub($interval);
      $diff = $endS->diff($startS);
  
      $labels = [
          'y' => 'year',
          'm' => 'month',
          'd' => 'day',
          'h' => 'hour',
          'i' => 'minute',
          's' => 'second',
      ];
      $return = [];
      foreach ($labels as $k => $v) {
          if ($diff->$k) {
              $return[] = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
          }
      }
  
      return implode(', ', $return);
   }

   if (isset($_GET['page']) && $_GET['page']!="") {
		$page_no = $_GET['page'];
	}
	else {
		$page_no = 1;
	}

	$total_records_per_page = 20;
   $offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2"; 

	$result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `radacct`");
	$total_records = mysqli_fetch_array($result_count);
	$total_records = $total_records['total_records'];
   $total_no_of_pages = ceil($total_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1; // total page minus 1

   $result = mysqli_query($conn,"SELECT * FROM `radacct` LIMIT $offset, $total_records_per_page");

   function load_pagination() {
      global $page_no, $previous_page, $next_page, $total_no_of_pages;
      echo "
         <ul class='pagination'>         
            <li ".(($page_no <= 1) ? "class='disabled'" : '')." >
               <a ".(($page_no > 1) ? "href='?page=$previous_page'" : '' ) . ">Prev</a>
            </li>";
            if ($total_no_of_pages <= 10){  	 
               for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";	
                  }
                  else {
                     echo "<li><a href='?page=$counter'>$counter</a></li>";
                  }
               }
            }
            else if ($total_no_of_pages > 10) {
               if($page_no <= 4) {	
                  for ($counter = 1; $counter < 8; $counter++) {	 
                     if ($counter == $page_no) {
                        echo "<li><a class='active'>$counter</a></li>";	
                     }
                     else {
                        echo "<li><a href='?page=$counter'>$counter</a></li>";
                     }
                  }
                  echo "<li><a>...</a></li>";
                  echo "<li><a href='?page=$second_last'>$second_last</a></li>";
                  echo "<li><a href='?page=$total_no_of_pages'>$total_no_of_pages</a></li>";
               }
            else if ($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
               echo "<li><a href='?page=1'>1</a></li>";
               echo "<li><a href='?page=2'>2</a></li>";
               echo "<li><a>...</a></li>";
               for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";
                  } else {
                     echo "<li><a href='?page_no=$counter'>$counter</a></li>";
                  }                  
               }
               echo "<li><a>...</a></li>";
               echo "<li><a href='?page=$second_last'>$second_last</a></li>";
               echo "<li><a href='?page=$total_no_of_pages'>$total_no_of_pages</a></li>";      
            }
            else {
               echo "<li><a href='?page=1'>1</a></li>";
               echo "<li><a href='?page=2'>2</a></li>";
               echo "<li><a>...</a></li>";

               for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                  if ($counter == $page_no) {
                     echo "<li><a class='active'>$counter</a></li>";	
                  }
                  else {
                     echo "<li><a href='?page=$counter'>$counter</a></li>";
                  }        
               }
            }
         }
      echo "
         <li " . (($page_no >= $total_no_of_pages) ? "class='disabled'" : '' ) . ">
            <a " . (($page_no < $total_no_of_pages) ? "href='?page=$next_page'" : '' ) . ">Next</a>
         </li>";
            if ($page_no < $total_no_of_pages) {
               echo "<li><a href='?page=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
            }
      echo "</ul>";
   }