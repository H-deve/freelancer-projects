<?php

class test_conn extends Models{

 public function store_User($name, $password) {
        $id = id('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->db->prepare("INSERT INTO users(id, name,encrypted_password, salt, created_at) VALUES(?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $id, $name,$encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();

                if ($result) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }




    public function getUserBynameAndPassword($name, $password) {
 
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = ?");
 
        $stmt->bind_param("s", $name);
 
        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }
 




    /**
     * Check user is existed or not
     */
    public function isUserExisted($name) {
        $stmt = $this->db->prepare("SELECT * from users WHERE name = ?");
 
        $stmt->bind_param("s", $name);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }
 





 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }
 
}

function register($name,$password){


$response = array("error" => FALSE);
 
if (isset($_POST['name']) &&  isset($_POST['password'])) {
 
    // receiving the post params
    $name = $_POST['name'];
   // $email = $_POST['email'];
    $password = $_POST['password'];
 
    // check if user is already existed with the same name
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $name;
        echo json_encode($response);
    } else {
        // create a new user
        $user = $db->storeUser($name, $password);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["id"];
            $response["user"]["name"] = $user["name"];
         //   $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, or password) is missing!";
    echo json_encode($response);
}

}





}


?>