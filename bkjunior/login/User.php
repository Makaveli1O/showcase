<?php
/**
 * Created by PhpStorm.
 * User: makaveli_10
 * Date: 02/08/2018
 * Time: 10:42
 */

class User extends Dbh
{
    protected $username;
    protected $password;
    protected $user_id;
    protected $character_existence;

    public function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;
        if ($this->injectionAttackAttempt($this->username, $this->password)) {
            echo '<script>alert("SQL Injection attempt detected.")</script>';
            return false;
        }
        $this->login();
    }

    public function login()
    {
        $user = $this->checkDatabase();
        if ($user)
        {
            $_SESSION['Logged'] = $this->username;
            $_SESSION['id'] = $this->user_id;
        }
    }

    protected function injectionAttackAttempt($username, $password){
        $attackAttempt = false;
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)){
            $attackAttempt = true;
        }else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)){
            $attackAttempt = true;
        }

        return $attackAttempt;
    }

    protected function checkDatabase()
    {

        $sql = "SELECT * FROM `users` WHERE username = '$this->username' AND password = '$this->password'";
        $result=$this->connect()->query($sql);

        if(empty($data=$result->fetch_assoc()))
        {
            echo '<script>alert("Wrong username or password!")</script>';
            return false;
        }else{
            $this->user_id = $data['id'];
            return true;
        }
    }
    //METODY NA VYPIS

    public function customers()
    {
        $sql = "SELECT * FROM customers";
        $result=$this->connect()->query($sql);
        //toto sa neopakuje
        echo '<table style="width:100%">
                 <tr>
                   <th>Id</th>
                   <th>Meno</th> 
                   <th>Priezvisko</th>
                   <th>Adresa</th>
                   </tr>
            ';
        while($row = $result->fetch_assoc()) {
        //toto sa opakuje cita z db
            echo '
                 <tr>
                   <td>'.$row['id'].'</td>
                   <td>'.$row['name'].'</td> 
                   <td>'.$row['subname'].'</td>
                   <td>'.$row['adress'].'</td>
                 </tr>
                ';
        }
        //koniec
        echo'</table>';
    }

}