<table border=1>
    <tr>
        <td>ID</td>
        <td>first_name</td>
        <td>Last Name</td>
        <td>Email</td>
        <td>City</td>
        <td>Makrs</td>
    </tr>
<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "lpu";
$conn = new mysqli($servername, $username, $password, $database);
$sql="select * from students where id>10";
$sql="select * from students where id>10 && marks>80";
$sql="select * from students where not id>10";
$sql="select * from students where first_name like 'a%'";
$sql="select * from students where first_name like '_i%'";
$sql="select * from students where first_name like 'V_k%'";
$sql="select * from students   order by first_name desc";
$sql="select * from students   order by first_name asc";
 $sql="select avg(marks) as avg,last_name from students   group by marks";
$sql="select min(marks) as min,first_name from students   group by marks";
$sql="SELECT min(marks) AS marks,first_name,last_name,email,city FROM students";
$sql="SELECT sum(marks) AS marks FROM students";
$sql="SELECT LCASE(first_name)as first_name  FROM students";
$sql="SELECT UCASE(first_name)as first_name  FROM students";

$sql="select avg(marks) as ms,first_name,last_name,email,city ,marks from students group by marks";
$result=mysqli_query($conn,$sql);
while($row=mysqli_fetch_assoc($result))
{
    ?>
    <tr>
        <td><?php echo $row["ms"];?></td>
        <!-- <td><?php echo $row["id"];?></td> -->
    <td><?php echo $row["first_name"];?></td>
    <td><?php echo $row["last_name"];?></td> 
        <td><?php echo $row["email"];?></td>
        <td><?php echo $row["city"];?></td>
        <td><?php echo $row["marks"];?></td> 
    </tr>
<?php
}

$conn->close();
?>
</table>
