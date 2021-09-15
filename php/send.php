<?php

require 'aws-ses/SimpleEmailService.php';
require 'aws-ses/SimpleEmailServiceMessage.php';
require 'aws-ses/SimpleEmailServiceRequest.php';

require 'curl.php';
require 'config/aws.config.php';
require 'config/dbh.config.php';

$sqli = "SELECT * FROM users;";             // here using  normal statement to check user found in the database
$res  = mysqli_query($conn,$sqli);          //query the database
$resultCheck = mysqli_num_rows($res);       // no of rows exists
if($resultCheck > 0){

                $status = "verified";
                //Create a template 
                $sql  = "SELECT * FROM users WHERE User_email_status = ?;";
                //create a prepared statement 
                $stmt = mysqli_stmt_init($conn);
                //Prepare the prepared statement
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: index.php?error=stmtfailed");
                        exit();
                }
                        
                    //bind Parameters to the place holder
                    mysqli_stmt_bind_param($stmt,"s",$status);
                    //Run parameters inside database
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                                                               // loop through to get all users found in the database
                    while( $row  =  mysqli_fetch_assoc($result)){
                            $m = new SimpleEmailServiceMessage();  
                            $ses = new SimpleEmailService($AccessKey, $SecretKey);     
                            $email = $row['User_email'];                        
                            $recipient =  $email;
                            $sender = $mail_id;
                            $senderName = $name;
                            
                 
                            $attachmentUrl =  $comics[$comic_name]['image'];        
                            $filename = $comic_name.".png";

                            $m->addTo($recipient);
                            $m->setFrom($sender);
                            $m->setSubject('XKCD-Comics');
                            

                            $m->setMessageFromString(null, $content);
                            $m->addAttachmentFromUrl($filename,$attachmentUrl, $mimeType = 'application/octet-stream', $contentId = null, $attachmentType = 'attachment');
                            $ses->sendEmail($m);

                }
    
            }else{
                echo "No user found";
            }
?>