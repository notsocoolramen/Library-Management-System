<?php
require('dbconn.php');

$bookid=$_GET['id1'];
$rollno=$_GET['id2'];

// $rollno = $_SESSION['RollNo'];
//                 $query = "SELECT * FROM LMS.user WHERE RollNo = '$rollno'";
//                 $result = $conn->query($query);

//                 if ($result && $result->num_rows > 0) {
//                     $row = $result->fetch_assoc();
//                     $rollno = $row['Type']; // Retrieve the sender's name from the query result
//                 } else {
//                     $rollno = "Unknown"; // Set a default value if the sender's name is not found in the database
//                 }


$sql="select Category from LMS.user where RollNo='$rollno'";
$result=$conn->query($sql);
$row=$result->fetch_assoc();

$category=$row['Category'];



if($category == 'GEN' || $category == 'OBC' )
{$sql1="update LMS.record set Date_of_Issue=curdate(),Due_Date=date_add(curdate(),interval 07 day),Renewals_left=1 where BookId='$bookid' and RollNo='$rollno'";
 
if($conn->query($sql1) === TRUE)
{$sql3="update LMS.book set Availability=Availability-1 where BookId='$bookid'";
 $result=$conn->query($sql3);
 $sql5 = "INSERT 
         INTO LMS.message (Sender,RollNo, Msg, Date, Time)
         VALUES ($rollno, 'Your request for issue of BookId: $bookid has been accepted', CURDATE(), CURTIME())";
//  $sql5="insert into LMS.message (RollNo,Msg,Date,Time) values ('$rollno','Your request for issue of BookId: $bookid  has been accepted',curdate(),curtime())";
 $result=$conn->query($sql5);
echo "<script type='text/javascript'>alert('Success')</script>";
header( "Refresh:0.01; url=issue_request2.php", true, 303);
}
else
{
	echo "<script type='text/javascript'>alert('Error')</script>";
    header( "Refresh:1; url=issue_request2.php", true, 303);

}
}
else
{$sql2="update LMS.record set Date_of_Issue=curdate(),Due_Date=date_add(curdate(),interval 07 day),Renewals_left=1 where BookId='$bookid' and RollNo='$rollno'";

if($conn->query($sql2) === TRUE)
{$sql4="update LMS.book set Availability=Availability-1 where BookId='$bookid'";
 $result=$conn->query($sql4);
 $sql6="insert into LMS.message (RollNo,Msg,Date,Time) values ('$rollno','Your request for issue of BookId: $bookid has been accepted',curdate(),curtime())";
 $result=$conn->query($sql6);
echo "<script type='text/javascript'>alert('Success')</script>";
header( "Refresh:1; url=issue_request2.php", true, 303);
}
else
{
	echo "<script type='text/javascript'>alert('Error')</script>";
    header( "Refresh:1; url=issue_request2.php", true, 303);

}
}



?>