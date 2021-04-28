<?php	
        function DataSaved()
        {
            return "<!DOCTYPE html>
            <html lang=\"de\">
            <title>Datenbank</title>
                    <head>
                        <meta charset=\"utf-8\">
                        <style>
                        body
                        {
                            background-color: lightgrey;
                        }
                        div
                        {
                            color: blue;
                        }
                        </style>
                    </head>     
                    <body> 
                        <form>
                            <div>Datensatz gespeichert.</div>
                            <p>
                            <a href=\"index.html\" style=\"color: purple;\">weiter</a>
                            </p>
                        </form>
                    </body>
            </html>";
        }

        function Error()
        {
            return "<!DOCTYPE html>
            <html lang=\"de\">
            <title>Datenbank</title>
                    <head>
                        <meta charset=\"utf-8\">
                        <style>
                        body
                        {
                            background-color: lightgrey;
                        }
                        div
                        {
                            color: red;
                        }
                        </style>
                    </head>     
                    <body> 
                        <form>
                            <div>Fehler: Unknown database 'it31_goralewski'</div>
                            <p>
                            <a href=\"index.html\" style=\"color: purple;\">weiter</a>
                            </p>
                        </form>
                    </body>
            </html>";
        }

        $db = mysqli_connect("localhost", "root", "", "it31_goralewski");

        if (mysqli_connect_errno())
        {
            sprintf($str, "Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
            die(Error());
        }

        $nachname = mysqli_real_escape_string($db, $_POST['nachname']);
        $vorname = mysqli_real_escape_string($db, $_POST['vorname']);
        $noten = mysqli_real_escape_string($db, $_POST['note']);

        if ($_POST['usecase'] == "daten")
        {
            $query = "SELECT nachname, vorname, note FROM noten WHERE nachname = '$nachname' and vorname = '$vorname' and note='$noten'";
            $res = mysqli_query($db, $query);
            if(!$row = mysqli_fetch_assoc($res))
            {
                $query = "INSERT INTO noten (nachname, vorname, note) VALUES ('$nachname', '$vorname', '$noten')";
                mysqli_query($db, $query);                
            }     
            echo(DataSaved());     
        }   
        else if($_POST['usecase'] == "datenAusgabe")
        {
            $avg = "SELECT ROUND(AVG (note), 2) as avg_ FROM noten";
            $avg =  mysqli_query($db, $avg);
            $avg = mysqli_fetch_assoc($avg);        

            $anz = "SELECT COUNT(note) as anzahl FROM noten";
            $anz = mysqli_query($db, $anz);
            $anz = mysqli_fetch_assoc($anz);         

            $index = 1;  
                              
            $result = mysqli_query($db, "SELECT nachname, vorname, note FROM noten ORDER BY note DESC"); 

            if(mysqli_num_rows($result)) 
            {   
                echo"   
                <body style=\"background-color: lightgray;\">               
                <table border='1' style=\"background-color: white\">
                <tr style=\"background-color: darkgray;\">
                    <td><div style=\"color: blue; font-size: 20px; font-family: arial\">Nachname&nbsp;&nbsp;</div></td>
                    <td><div style=\"color: blue; font-size: 20px; font-family: arial\">Vorname&nbsp;&nbsp;</div></td>
                    <td><div style=\"color: blue; font-size: 20px; font-family: arial\">Note&nbsp;&nbsp;</div></td>
                </tr>";

                while($row = mysqli_fetch_array($result)) 
                { 
                    echo"        
                    <tr>
                        <td>
                        <div style=\"color: blue;\">{$row['nachname']}</div>
                        </td>
                        <td>
                        <div style=\"color: blue;\">{$row['vorname']}<div>
                        </td>
                        <td>
                        <div style=\"color: blue;\">{$row['note']}<div>
                        </td>
                    </tr>"; 

                    $index++;
                }
            }
                echo"
                <table>
                    <tr>
                    <p></p>
                    <div style=\"color: blue;\">Durschschnittsnote: {$avg['avg_']}</div>
                    <p></p>
                        <td>
                            <a href=\"Index.html\" style=\"color: purple;\">weiter</a>
                        </td>
                    </tr>
                </table>";
            }      
?>