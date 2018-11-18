<?php
function dbconn ($host="localhost", $user="root", $pass="", $db= "finance")
{
    $conn=mysqli_connect($host, $user, $pass, $db);
    if(!$conn)
    {
        echo "Conection failed". mysqli_connect_error();
    }
    else
    {
        mysqli_select_db($conn, $db);
        return $conn;
    }
}
$conn=dbconn();
function stripText($text)
{
    global $conn;

    $text=trim($text);
    $text=stripslashes($text);
    $text=htmlspecialchars($text);
    $text = mysqli_real_escape_string($conn, $text);

    return $text;
}

function checkIfDataAlreadyExists($needle, $haystack, $table)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM $table WHERE $haystack='$needle'");
    if (mysqli_num_rows($query)>0){
        return true;
    }
    else
    {
        return false;
    }
}

function login ($email, $pass)
{
    global $conn;
    global $b;

    if (empty($email)) {
        return "The Email field is required";
    } else {
        if (empty($pass)) {
            return "The Passowrd field is required";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Invalid email address";
            } else {
                $email = stripText($email);
                $pass = stripText($pass);
                $md5pass = md5($pass);
                $loginQuery = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' and password = '$md5pass'");
                if (mysqli_num_rows($loginQuery) > 0) {
                    while ($row = mysqli_fetch_assoc($loginQuery)) {
                        $_SESSION['email'] = $email;
                        $_SESSION['id'] = $row['id'];
                        $b = $_SESSION['id'];

                    }
                    redirect("index.php");
                } else {
                    return "Your credentials doesn't match";
                }
            }
        }
    }
}

function notSetSession()
{
    if (!isset($_SESSION['email']))
    {
        redirect("login.php");
    }
}

function setSession()
{
    if (isset($_SESSION['email']))
    {
        redirect("index.php");
    }
}

function redirect($location)
{
    header("location: $location");
}

function showPosition()
{
    global $conn;

    $sql ="SELECT * FROM users WHERE email = '".$_SESSION['email']."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        return ["id"=>$row['id'], "email"=>$row['email'], "position"=>$row['current_position'], "created_by"=>$row['created_by'],
            "joined"=>$row['created_at']];
    }
}

function setPosition($position)
{
    if ($position == 1)
    {
        return "Admin";
    }
    else
    {
        if ($position == 2)
        {
            return "Committee";
        }
        else
        {
            if ($position == 3)
            {
                return "President";
            }
            else
            {
                if ($position == 4)
                {
                    return "Secretary";
                }
                else
                {
                    if ($position == 5)
                    {
                        return "Financial Secretary";
                    }
                    else
                    {
                        return "Member";
                    }
                }
            }
        }
    }
}

function showProfile()
{
    global $conn;

    $position =showPosition();

        $sql="SELECT * FROM users_personal_details WHERE user_id = '".$position['id']."'";
        if(!$sql)
        {
            return "Server Error";
        }
        else
        {
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            return ["first_name"=>$row['fname'], "last_name"=>$row['lname'], "image"=>$row['image'], "address"=>$row['address'],
                "city"=>$row['city'], "state"=>$row['state'], "created_by"=>$position['created_by']];
        }
}

function updateProfile($fname, $lname, $address, $city, $state, $image)
{
    global $conn;

    if (empty($fname))
    {
        return "The first name field is required";
    } else {
        if (empty($lname))
        {
            return "The Last name field is required";
        }
        else
            {
            if (empty($address))
            {
                return "The address field is required";
            }
            else
            {
                if (empty($city))
                {
                    return "The city field is required";
                }
                else
                {
                    if (empty($state))
                    {
                        return "The State field is required";
                    }

                    else
                    {
                        $fname = stripText($fname);
                        $lname = stripText($lname);
                        $address = stripText($address);
                        $city = stripText($city);
                        $state = stripText($state);

                        $sql = "SELECT * FROM users WHERE email = '" . $_SESSION['email'] . "'";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($query);
                        $id = $row['id'];

                        if (empty($image['name']))
                        {
                            $sql1 = "UPDATE users_personal_details SET fname='$fname', lname = '$lname', address ='$address', city = '$city',
                                    state ='$state', updated_at=now() WHERE user_id=$id";
                            if (mysqli_query($conn, $sql1))
                            {
                                return "Personal details updated successfully";
                            }
                            else
                            {
                                return "Server Error";
                            }
                        }
                        else
                        {
                            if (!empty($image['name']))
                            {
                                $profile = showProfile();
                                $exist_image = $profile['image'];
                                if ($exist_image!=="user.jpg")
                                {
                                    $link = "dist/img/$exist_image";
                                    if(unlink($link))
                                    {
                                        if (getimagesize($image['tmp_name']))
                                        {
                                            $rand = rand(10,100000);
                                            $array = explode(".", $image['name']);
                                            $ext =end($array);
                                            $new = $rand.".".$ext;

                                            if(move_uploaded_file($image['tmp_name'], "dist/img/".$new))
                                            {
                                                $sql = "UPDATE users_personal_details SET fname='$fname', lname = '$lname', image = '$new',
                                                        address ='$address', city = '$city', state ='$state', updated_at=now() WHERE user_id=$id";
                                                if (mysqli_query($conn, $sql))
                                                {
                                                    return "Personal details updated successfully";
                                                }
                                                else
                                                {
                                                   return "Server Error";
                                                }
                                            }
                                            else
                                            {
                                                return "Server Error";
                                            }
                                        }
                                        else
                                        {
                                            return "The file you're trying to upload is not an image";
                                        }

                                    }
                                    else
                                    {
                                        return "Server Error";
                                    }
                                }

                                else
                                {
                                    if (getimagesize($image['tmp_name']))
                                    {
                                        $rand = rand(10,100000);
                                        $array = explode(".", $image['name']);
                                        $ext =end($array);
                                        $new = $rand.".".$ext;

                                        if(move_uploaded_file($image['tmp_name'], "dist/img/".$new))
                                        {
                                            $sql = "UPDATE users_personal_details SET fname='$fname', lname = '$lname', image = '$new',
                                                        address ='$address', city = '$city', state ='$state', updated_at=now() WHERE user_id=$id";
                                            if (mysqli_query($conn, $sql))
                                            {
                                                return "Personal details updated successfully";
                                            }
                                            else
                                            {
                                                return "Server Error";
                                            }
                                        }
                                        else
                                        {
                                            return "Server Error";
                                        }
                                    }
                                    else
                                    {
                                        return "The file you're trying to upload is not an image";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function showAccountBalance()
{
    global $conn;

    $position=showPosition();

    $sql="SELECT * FROM account_details WHERE user_id = '".$position['id']."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return ["id"=>$row['id'], "user_id"=>$row['user_id'], "account_balance"=>$row['account_balance']];
    }
}

function depositRequests ($amount, $image)
{
    global $conn;
    $position = showPosition();

    if (empty($amount))
    {
        return "Please specify an amount";
    }
    else
    {
        if (empty($image['name']))
        {
            return "Please upload proof of payment";
        }
        else
        {
            $amount = stripText($amount);
            if (getimagesize($image['tmp_name']))
            {
                $rand = rand(10,100000);
                $array = explode(".", $image['name']);
                $ext =end($array);
                $new = $rand.".".$ext;

                if(move_uploaded_file($image['tmp_name'], "dist/img/slips/".$new))
                {
                    $sql = "INSERT INTO pending_financial_requests(user_id, request_type, slip_image, amount, requested_at) 
                            VALUES ('".$position['id']."', 'deposit', '$new', '$amount', now())";
                    if (mysqli_query($conn, $sql))
                    {
                        return "You have requested that your account be credited with ".$amount.
                            ". Please wait while your request is processed by the Financial Secretary";
                    }
                    else
                    {
                        return "Server Error";
                    }
                }
                else
                {
                    return "Server Error";
                }
            }

        }
    }
}


function withdrawRequests ($amount)
{
    global $conn;
    $position = showPosition();
    $balance = showAccountBalance();
    $bal = $balance['account_balance'];

    if (empty($amount))
    {
        return "Please specify an amount";
    }
    else
    {
        if ($amount > $bal)
        {
            return ["status" => "error", "message" => "The amount you can withdraw cannot be greater than the amount in your account"];
        }
        else
        {
            $amount = stripText($amount);
            $sql = "INSERT INTO pending_financial_requests(user_id, request_type, slip_image, amount, requested_at) 
                VALUES ('" .$position['id']."', 'withdraw', 'null', '$amount', now())";
            if (mysqli_query($conn, $sql))
            {
                return ["status" => "success", "message" => "Your request has been submitted, please wait for approval", "amount"=> $amount];
            }
            else
            {
                return ["status" => "error", "message" => "Server Error"];
            }
        }
    }
}

function loanRequests($amount)
{
    global $conn;
    $position = showPosition();
    $balance = showAccountBalance();
    $bal = $balance['account_balance'];

    if (empty($amount))
    {
        return "Please specify an amount";
    }
    else
    {
        if ($amount > $bal)
        {
            return ["status" => "error", "message" => "The loan you want to apply for cannot be greater than the amount in your account"];
        }
        else
        {
            $amount = stripText($amount);
            $sql = "INSERT INTO pending_financial_requests(user_id, request_type, slip_image, amount, requested_at) 
                VALUES ('" .$position['id']."', 'loan', 'null', '$amount', now())";
            if (mysqli_query($conn, $sql))
            {
                return ["status" => "success", "message" => "Your request has been submitted, please wait for approval", "amount"=> $amount];
            }
            else
            {
                return ["status" => "error", "message" => "Server Error"];
            }
        }
    }
}

function showRequest($id)
{
    global $conn;
    $sql ="SELECT * FROM pending_financial_requests WHERE id = '".$id."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            return ["id" => $row['id'], "user_id" => $row['user_id'], "request_type" => $row['request_type'], "slip_image" => $row['slip_image'],
                "amount" => $row['amount'], "requested_at" => $row['requested_at'], "fin_sec_approval" => $row['fin_sec_approval'],
                "fin_sec_approval_date" => $row['fin_sec_approval_date'], "president_approval" => $row['president_approval'],
                "president_approval_date" => $row['president_approval_date']];
        }
        else
        {return "Error";}
    }
}

function showMember($id)
{
    global $conn;

    $sql ="SELECT * FROM users WHERE id = '".$id."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            return ["id" => $row['id'], "email" => $row['email'], "position" => $row['current_position'], "created_by" => $row['created_by'],
                "joined" => $row['created_at'], "deleted"=>$row['deleted']];
        }
        else
        {
            return "Error";
        }
    }
}

function showMemberDetails($id)
{
    global $conn;

    $member = showMember($id);

    $sql ="SELECT * FROM users_personal_details WHERE user_id = '".$member['id']."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            return ["first_name" => $row['fname'], "last_name" => $row['lname'], "image" => $row['image'], "address" => $row['address'],
                "city" => $row['city'], "state" => $row['state'], "updated_at" => $row['updated_at']];
        }
        else {return "Error";}
    }
}

function displayRequest($id)
{
    $request= showRequest($id);



    if ($request != "Error")
    {
        $member = showMember($request['user_id']);
        $member_details =showMemberDetails($request['user_id']);
        if ($member != "Error")
        {
           if ($member_details != "Error")
            {
                return ["request"=>$request, "member"=>$member, "member_details"=>$member_details];
            }
            else {return "Error";}
        }else {return "Error";}
    }else {return "Error";}



}

function fetchUserPersonalDetails($id)
{
    global $conn;

    $sql= "SELECT * FROM users_personal_details WHERE user_id = '".$id."'";
    if (!$sql)
    {
        return ["status"=>"error", "message"=>"Server Error"];
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return ["first_name"=>$row['fname'], "last_name"=>$row['lname'], "image"=>$row['image'],
            "address"=>$row['address'], "city"=>$row['city'], "state"=>$row['state']];
    }
}

function recordIntoHistory($id)
{
    global $conn;
    $position = showPosition();
    $profile = showProfile();
    $request = displayRequest($id);

    $type_id = $request['request']['id'];
    $user_id = $request['request']['user_id'];
    $approved_id = $position['id'];

    $fetch = fetchUserPersonalDetails($user_id);

    $type = $request['request']['request_type'];
    $slip_image = $request['request']['slip_image'];
    $amount = $request['request']['amount'];
    $requested_by = $fetch["first_name"] . ", " . $fetch["last_name"];
    $request_at = $request['request']['requested_at'];
    $approved_by = $profile["first_name"] . ", " . $profile["last_name"];
    $approved_position = setPosition($position['position']);


    $sql = "INSERT INTO financial_history (type_id, request_type, slip_image, amount, user_id, requested_by, 
              requested_date, approved_id, approved_by, approved_position, approved_date) VALUES ('" . $type_id . "', '" . $type . "', '" . $slip_image . "', 
              '" . $amount . "', '" . $user_id . "', '" . $requested_by . "', '" . $request_at . "', '" . $approved_id . "', '" . $approved_by . "',
              '" . $approved_position . "', now())";

    if (!$sql) {
        return "Server Error1";
    } else {
        $query = mysqli_query($conn, $sql);
        if ($query) {
            return "success";
        } else {
            return "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}


function finSecApproval($id)
{
    global $conn;
    $sql = "UPDATE pending_financial_requests SET fin_sec_approval='1' WHERE id=$id";
    if (!$sql)
    {
        return "Server Error";
    }
    else
    {
        $status = recordIntoHistory($id);
        if ($status == "success")
        {
            if (mysqli_query($conn, $sql))
            {

                return "Approved Successfully";
            }
            else
            {
                return "Server Error";
            }
        }
        else
        {
            return "error112";
        }
    }
}


function presidentApproval($id)
{
    global $conn;

    $request = displayRequest($id);
    $user_id = $request['request']['user_id'];
    $type = $request['request']['request_type'];
    $amount = $request['request']['amount'];

    if ($type == "deposit" )
    {
        $bal = depositAccount($user_id, $amount);
    }
    elseif($type == "withdraw")
    {
        $bal = withdrawAccount($user_id, $amount);
    }

    if ($bal['status'] == "success")
    {
        $acct = editAccount($user_id, $bal['bal']);

        if ($acct == "success")
        {
            $sql = "UPDATE pending_financial_requests SET president_approval='1' WHERE id=$id";
            if (!$sql)
            {
                return "Server Error";
            }
            else
            {
                $status = recordIntoHistory($id);
                if ($status == "success")
                {
                    if (mysqli_query($conn, $sql))
                    {
                        return "Approved Successfully";
                    }
                    else
                    {
                        return "Server Error";
                    }
                }
                else
                {
                    return "error";
                }
            }

        }

    }
    else
    {
        return "Server Error";
    }


}

function depositAccount($id, $amount)
{
    global $conn;

    $sql="SELECT * FROM account_details WHERE user_id = '".$id."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $accountDetails= ["id"=>$row['id'], "user_id"=>$row['user_id'], "account_balance"=>$row['account_balance']];
        $newBal = $accountDetails["account_balance"] + $amount;

        return ["status"=>"success", "bal"=>$newBal];
    }

}


function withdrawAccount($id, $amount)
{
    global $conn;

    $sql="SELECT * FROM account_details WHERE user_id = '".$id."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $accountDetails= ["id"=>$row['id'], "user_id"=>$row['user_id'], "account_balance"=>$row['account_balance']];
        $newBal = $accountDetails["account_balance"] - $amount;

        return ["status"=>"success", "bal"=>$newBal];
    }

}

function editAccount($id, $newBal)
{
    global $conn;

    $sql = "UPDATE account_details SET account_balance='".$newBal."' WHERE user_id=$id";

    if (!$sql)
    {
        return "Server Error";
    }
    else
    {
        $query = mysqli_query($conn, $sql);
        if ($query)
        {
            return "success";
        }
        else
        {
            return "server error";
        }
    }
}

function addUser ($email, $pass, $cpass)
{
    if (empty($email))
    {
        return "email is required";
    }
    else
    {
        if (checkIfDataAlreadyExists($email, "email", "users"))
        {
            return "email already exists";
        }
        else
        {
            if (empty($pass) && empty($cpass))
            {
                return "please fill in the password field and the confirm password field";
            }
            else
            {

                if (!strlen($pass) >= 5)
                {
                    return "password must be at least 5 characters";
                }
                else
                {
                    $md5pass = md5($cpass);
                    if ($pass !== $cpass)
                    {
                        return "passwords must be the same";
                    }
                    else
                    {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            return "invalid email address";
                        }
                        else
                        {
                            $email = stripText($email);
                            $insertIntoUserTable = insertIntoUserTable($email, $md5pass);

                            if ($insertIntoUserTable == "success")
                            {
                                return "User added successfully";
                            }
                            else
                            {
                                return "error3";
                            }

                        }
                    }
                }
            }
        }
    }
}

function insertIntoUserTable($email, $cpass)
{
    global $conn;


    $profile = showProfile();

    $created_by = $profile['first_name'].",".$profile['last_name'];

    $query = "INSERT INTO users (email, password, current_position, created_by, created_at, deleted) 
                  VALUES ('". $email ."', '".$cpass."', '0', '".$created_by ."', now(), '0')";
    if (mysqli_query($conn, $query))
    {
        return "success";
    }
    else
    {
        return "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

function insertIntoUsersPersonalDetailsTable()
{
    global $conn;
    $position = showPosition();
    $sql = "INSERT INTO users_personal_details (user_id, fname, lname, image, address, city, state, updated_at) 
              VALUES('".$position["id"]."', 'null', 'null', 'user.jpg', 'null', 'null', 'null', now())";
    if(!$sql)
    {
        return "server error";
    }
    else
    {
        if (mysqli_query($conn, $sql))
        {
            return "success";
        }
        else
        {
            return "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

function insertIntoAccountDetailsTable()
{
    global $conn;
    $position = showPosition();
    $sql = "INSERT INTO account_details (user_id, account_balance) 
              VALUES('".$position["id"]."', '0')";
    if(!$sql)
    {
        return "server error";
    }
    else
    {
        if (mysqli_query($conn, $sql))
        {
            return "success";
        }
        else
        {
            return "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

function checkUserDetails()
{
    global $conn;
    $position =showPosition();

    $query= mysqli_query($conn,"SELECT * FROM users_personal_details WHERE user_id = '".$position['id']."'");
    if (mysqli_num_rows($query)>0){
        return true;
    }
    else
    {
        return false;
    }
}

function checkUserAcct()
{
    global $conn;

    $position=showPosition();

    $query= mysqli_query($conn,"SELECT * FROM account_details WHERE user_id = '".$position['id']."'");
    if (mysqli_num_rows($query)>0){
        return true;
    }
    else
    {
        return false;
    }
}

function showUserAccountBalance($id)
{
    global $conn;

    $sql="SELECT * FROM account_details WHERE user_id = '".$id."'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return ["id"=>$row['id'], "user_id"=>$row['user_id'], "account_balance"=>$row['account_balance']];
    }
}

function readFinSecRequestApproval($id)
{
    global $conn;

    $sql ="SELECT * FROM financial_history WHERE type_id = '".$id."' and approved_position = 'Financial Secretary'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        return ["approved_by"=>$row['approved_by'], "approved_date"=>$row['approved_date']];
    }
}

function readPresidentRequestApproval($id)
{
    global $conn;

    $sql ="SELECT * FROM financial_history WHERE type_id = '".$id."' and approved_position = 'President'";
    if(!$sql)
    {
        return "Server Error";
    }
    else
    {
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        return ["approved_by"=>$row['approved_by'], "approved_date"=>$row['approved_date']];
    }
}


