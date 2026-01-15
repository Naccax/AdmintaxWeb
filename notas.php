<?php 
          foreach($reciboSueldo as $row)
          {
            echo "<tr>";
            foreach($row as $campo)
            {
              echo "<td>";
              echo $campo;
              echo "</td>";
            }
            if($row["Detalle"]=="Descuentos Obligatorios")
            {
              echo "<td>*****<td>";
            }
            echo "</tr>";
          }
        ?>