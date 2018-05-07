<?php
//Grant that this is 
if (!empty($_POST)) {
    
    //Create the header's for the service
    header("access-control-allow-credentials:true");
    header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
    header("access-control-allow-methods:POST, GET, OPTIONS");
    header("access-control-allow-origin:".$_SERVER['HTTP_ORIGIN']);
    header("access-control-expose-headers:AMP-Access-Control-Allow-Source-Origin");
    header("amp-access-control-allow-source-origin:http://".$_SERVER['HTTP_HOST']);
    header("Content-Type: application/json");
    
    //Prepare data for insertion and get data from the post request
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $postalCode = isset($_POST['postal_code']) ? $_POST['postal_code'] : '';
    $local = isset($_POST['local']) ? $_POST['local'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $surName = '';
    $currDate = date ("Y-m-d");
    $date = date("Y-m-d G:i:s");
    $origem = 'AMP';
    
    //Grant that the needed parameeters are passed and with the right parameters
    if($name!='' && $phone!='' && $postalCode!='' && $local!='' && $email!=''  ){

        //Separate the different parts of the name
        $yourNameArray = explode(" ",$name);
        
        if( sizeof($yourNameArray) > 1){
            $name =  $yourNameArray[0];
            $surName =  $yourNameArray[sizeof($yourNameArray) -1 ];
        }


        //Load the Configuration File
        require_once("config.php");


        //Insert data in to the Database
        $sql="INSERT INTO inscricoes (nomeapelido,apelido,codPostal,localidade,telefone,email,dataRegisto,data,origem) VALUES ('".$name."','".$surName."','".$postalCode."', '".$local."', '".$phone."','".$email."','".$currDate."','".$date."','".$origem."')";

        //Return information to the System responsible for the service consumption
        if(!$result = $conn->query($sql)){
            die('500: There was an error running the query [' . $conn->error . ']');
            $errorArrSql = array ('code'=> 500,'mesage'=>'Server Error');
            echo json_encode($errorArrSql);
        }
        else
        {
            //Create the JSON response
            $arr = array ('code'=> 200,' mesage'=>'One Row Aded','origem' => $origem,'name' => $name,'surname' => $surName, 'phone' => $phone , 'postal_code' => $postalCode,'local' => $local,'date' => $date,'email' => $email);
            echo json_encode($arr);
        }


       
    }

    else{
        $errorArr = array ('code'=> 400,'mesage'=>'Form Parammeters are not all correct set');
        echo json_encode($errorArr);

    }


    
}
?>
