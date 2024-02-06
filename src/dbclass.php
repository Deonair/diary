<?php
//Class named DB has been made
class DB
{
    //This can only be used from within the class!
    protected $conn;

    //Function made to connect to the database 
    public function conn()
    {
        try {
            //DB Username
            $username = 'root';

            //DB Password
            $wachtwoord = '';

            //PDO Configuration
            $options = [
                PDO::ATTR_EMULATE_PREPARES => false, // Zet emulatie uit voor echte prepared statements
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //enables errors for debugging
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Zet fetch automatisch op array
            ];
            //Host configuration
            $dsn = "mysql:host=localhost;dbname=diary;charset=utf8mb4";
            //Create PDO
            $this->conn = new PDO($dsn, $username, $wachtwoord, $options);
            //return value boolean
            return true;
            //Put variable from the conn on NULL
            $this->conn = NULL;
        } catch (PDOException $e) {
            //Database connection error
            exit('Er ging iets mis...');
            //Send variable back
            return $e;
        }
    }
}

class Gebruikers extends DB
{

    //public id
    public $id;
    //public voornaam
    public $voornaam;
    //public tussenvoegsels
    public $tussenvoegsel;
    //public Achternaam
    public $achternaam;
    //public Email
    public $email;


    //Create Function VolledigeNaamWeergeven
    //Makes sure that the name will be displayed on the welcomepage
    public function vnw()
    {
        echo $this->voornaam;
        echo ' ';
        echo $this->tussenvoegsel;
        echo ' ';
        echo $this->achternaam;
    }

    //Create function voornaam
    //Makes sure that the name will displayed on the changing details page
    public function voornaam()
    {
        echo $this->voornaam;
    }

    //Create function Tussenvoegsels
    //Makes sure that the name will displayed on the changing details page
    public function tussenvoegsel()
    {
        echo $this->tussenvoegsel;
    }

    //Create function Voegsels
    //Makes sure that the name will displayed on the changing details page
    public function achternaam()
    {
        echo $this->achternaam;
    }

    //Create function email
    //Makes sure that the name will displayed on the changing details page
    public function email()
    {
        echo $this->email;
    }

    //Insert in to the database function 
    public function create($voornaam, $tussenvoegsel, $achternaam, $email, $wachtwoord, $wachtwoord2)
    {
        //Hash wachtwoord encrypten van het wachtwoord

        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        try {
            // Create a connection with the database
            $this->conn();
            // Define SQL Query
            $sql = "INSERT INTO `gebruikers` (voornaam, tussenvoegsels, achternaam, email, wachtwoord) VALUES (:voornaam, :tussenvoegsels, :achternaam, :email, :wachtwoord)";
            // Prepare SQL
            $stmt = $this->conn->prepare($sql);
            // Bind value with the named placeholder
            $stmt->bindParam(":voornaam", $voornaam);
            $stmt->bindParam(":tussenvoegsels", $tussenvoegsel);
            $stmt->bindParam(":achternaam", $achternaam);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":wachtwoord", $hash);
            //SQL query daadwerkelijk uitvoeren
            $stmt->execute();
            //Zet verbinding op NULL
            $this->conn = NULL;
        } catch (PDOException $e) {
            //
            exit('Er bestaat al een user met dit emailadres.'); //something a user can understand
            return $e;
        }
    }

    //Login function selects the info out of the database checks if its right and connects you further
    public function login($email, $wachtwoord)
    {
        try {
            // Create a connection with the database
            $this->conn();
            //Define sql query 
            $sql = "SELECT * FROM gebruikers WHERE email = :email";
            //Prepare sql 
            $stmt = $this->conn->prepare($sql);
            //binding values to the placeholders 
            $stmt->bindParam(":email", $email);
            // Execute sql query 
            $stmt->execute();
            // Pickup data
            $data = $stmt->fetch();

            $this->conn = NULL;

            //Check if typed in password is desame as password in database
            if (password_verify($wachtwoord, $data['wachtwoord'])) {
                // class variabelen invullen
                $this->id = $data['id_gebruiker'];
                $this->voornaam = $data['voornaam'];
                $this->tussenvoegsel = $data['tussenvoegsels'];
                $this->achternaam = $data['achternaam'];
                $this->email = $data['email'];
                // Send status back
                return true;
            } else {
                // Send Status back
                return 'wachtwoord en komen niet overeen.';
            }
        } catch (PDOException $e) {
            $this->conn = NULL;
            // Send status back
            return $e;
        }
    }

    //Checks if user is logged in
    public function is_loggedin()
    {
        if (isset($_SESSION['gebruiker_data'])) {
            return true;
        }
    }

    //Log Out function
    public function doLogout()
    {
        session_destroy();
        unset($_SESSION['gebruiker_data']);
        return true;
    }

    //Update function 
    public function update($voornaam, $tussenvoegsels, $achternaam, $email, $oudwachtwoord, $wachtwoord)
    {
        if (empty($wachtwoord)) {
        } else {
            //Hash wachtwoord
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        }
        try {
            //Extract session data
            $user = unserialize($_SESSION['gebruiker_data']);
            //Fetch user id from session
            $user_id = $user->id;
            // Create a connection with the database
            $this->conn();
            //Define sql query
            $sql = "UPDATE `gebruikers` 
                    SET 
			voornaam=COALESCE(NULLIF(:voornaam, ''),voornaam),
			tussenvoegsels=COALESCE(NULLIF(:tussenvoegsels, ''),tussenvoegsels),
			achternaam=COALESCE(NULLIF(:achternaam, ''),achternaam),
			email=COALESCE(NULLIF(:email, ''),email),
			wachtwoord=COALESCE(NULLIF(:nww1, ''),wachtwoord)			
            WHERE id_gebruiker = :userid";
            // Prepare Sql
            $stmt = $this->conn->prepare($sql);
            //Bind value with named placehoders
            $stmt->bindParam(':userid', $user_id);
            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':tussenvoegsels', $tussenvoegsels);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nww1', $hash);

            //Define second SQL for old password fetches
            $sql2 = "SELECT wachtwoord FROM gebruikers WHERE id_gebruiker = :id";
            //Prepare SQL
            $stmt2 = $this->conn->prepare($sql2);
            //BInd values with placeholder
            $stmt2->bindParam(":id", $user_id);

            // Actually execute SQL Query
            $stmt2->execute();
            // Pickup data
            $data = $stmt2->fetch();

            if (password_verify($oudwachtwoord, $data['wachtwoord'])) {
                //Execute SQL
                $stmt->execute();
            }
        } catch (PDOException $e) {
            $this->conn = NULL;
            // Send status back
            return $e;
        }
    }

    //Delete function
    public function delete($user_id, $email)
    {
        // Create a connection with the database
        $this->conn();
        // Define SQL Query
        $sql = "DELETE FROM `gebruikers` WHERE id_gebruiker = :userid AND email = :email";
        // Prepare SQL
        $stmt = $this->conn->prepare($sql);
        // Bind values to named placeholder
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':email', $email);
        //Pickup data
        $stmt->execute();

        session_destroy(); //stops session

        $this->conn = NULL; //breaks connection with database 
    }

    public function getProfile($user_id, $email)
    {
        // Create a connection with the database
        $this->conn();
        // Define SQL Query
        $sql = "SELECT * FROM gebruikers WHERE email = :email AND id_gebruiker = :userid"; // Prepare SQL
        $stmt = $this->conn->prepare($sql);
        // Bind value with the named placeholder
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':email', $email);
        //Data ophalen
        $stmt->execute();

        //Fetch alle data
        $data = $stmt->fetchAll();

        //return variable
        return $data;
        //sluit verbinding
        $this->conn = NULL;
    }
}

//create class dagboek also uses class gebruikers
class Dagboeken extends Gebruikers
{
    //retrieve diary
    public function getDiary()
    {
        //unpack session
        $user = unserialize($_SESSION['gebruiker_data']);
        //Zet gebruikers id uit sessie in variable
        $user_id = $user->id;
        try {
            // Create a connection with the database
            $this->conn();
            // Define SQL Query
            $sql = "SELECT * FROM dagboeken WHERE id_gebruiker = :id";
            // Prepare SQL
            $stmt = $this->conn->prepare($sql);
            // Bind value with the named placeholder
            $stmt->bindParam(':id', $user_id);
            //execute SQL
            $stmt->execute();
            // retrieve data
            $data = $stmt->fetchAll();
            // Close off database connection
            $this->conn = NULL;

            // return retrieved rows
            return $data;
        } catch (PDOException $e) {
            // Close off database connection
            $this->conn = NULL;
            // Return Variable
            return $e;
        }
    }
    //retrieve story
    public function getStories($dbid)
    {
        try {
            // Create a connection with the database
            $this->conn();
            // Define SQL Query
            $sql = "SELECT * FROM posts WHERE id_dagboek = :iddagboek";
            // Prepare SQL
            $stmt = $this->conn->prepare($sql);
            // Bind value with the named placeholder
            $stmt->bindParam(':iddagboek', $dbid);

            $stmt->execute();

            // retrieve data
            $data = $stmt->fetchAll();
            // Close off database connection
            $this->conn = NULL;

            // return retrieved rows
            return $data;
        } catch (PDOException $e) {
            // Close off database connection
            $this->conn = NULL;
            // Return Variable
            return $e;
        }
    }
    //retrieve story
    public function getStory($dagboekid)
    {
        try {
            // Create a connection with the database
            $this->conn();
            // Define SQL Query
            $sql = "SELECT post FROM posts WHERE id_dagboek = :iddagboek";
            // Prepare SQL
            $stmt = $this->conn->prepare($sql);
            // Bind value with the named placeholder
            $stmt->bindParam(':iddagboek', $dagboekid);

            //execute SQL
            $stmt->execute();

            // retrieve data
            $data = $stmt->fetchAll();

            // Close off database connection
            $this->conn = NULL;

            // return retrieved rows
            return $data;
        } catch (PDOException $e) {
            // Close off database connection
            $this->conn = NULL;
            return $e;
        }
    }
    //retrieve diary name
    public function getDiaryName($dagboekid, $user_id)
    {
        try {

            // Create a connection with the database
            $this->conn();
            // Define SQL Query
            $sql = "SELECT naam FROM dagboeken WHERE id_dagboek = :iddagboek AND id_gebruiker = :userid";
            // Prepare SQL
            $stmt = $this->conn->prepare($sql);
            // Bind value with the named placeholder
            $stmt->bindParam(':iddagboek', $dagboekid);
            $stmt->bindParam(':userid', $user_id);

            $stmt->execute();

            // retrieve data
            $data = $stmt->fetchAll();

            // Close off database connection
            $this->conn = NULL;

            // return retrieved rows
            return $data;
        } catch (PDOException $e) {
            // Close off database connection
            $this->conn = NULL;
            // Return Variable
            return $e;
        }
    }
    //add diary to database
    public function setDiary($naam, $user_id)
    {
        // Create a connection with the database
        $this->conn();
        // Define SQL Query
        $sql = "INSERT INTO `dagboeken` (id_gebruiker, naam) VALUES (:userid, :naam)";
        // Prepare SQL
        $stmt = $this->conn->prepare($sql);
        // Bind value with the named placeholder	
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':naam', $naam);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
    //add story to database
    public function setStory($dagboekid, $posts, $datum)
    {
        // Create a connection with the database
        $this->conn();
        // Define SQL Query
        $sql = "INSERT INTO `posts` (id_dagboek, post, datum) VALUES (:dagboekid, :posts, :datum)";
        // Prepare SQL
        $stmt = $this->conn->prepare($sql);
        // Bind value with the named placeholder 

        $stmt->bindParam(':dagboekid', $dagboekid);
        $stmt->bindParam(':posts', $posts);
        $stmt->bindParam(':datum', $datum);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
    //delete diary
    public function deleteDiary($dagboekid, $user_id)
    {
        // Create a connection with the database
        $this->conn();
        // Define SQL Query
        $sql = "DELETE FROM `dagboeken` WHERE id_gebruiker = :userid AND id_dagboek = :dagboekid";
        // Prepare SQL
        $stmt = $this->conn->prepare($sql);
        // Bind value with the named placeholder	
        $stmt->bindParam(':userid', $user_id);
        $stmt->bindParam(':dagboekid', $dagboekid);
        // sql query daadwerkelijk uitvoeren
        $stmt->execute();
        //sluit verbinding
        $this->conn = NULL;
    }
}
 
// public function deleteVerhaal()
