<html>
    <head>
        <title>Chikitsa - Patient Management System</title>
        <script src="js/jquery-ui-1.9.1.custom.js"></script>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link href="css/smoothness/jquery-ui-1.9.1.custom.css" rel="stylesheet">
    </head>
    <body>
        <?php
        $latest_version = "0.0.7";
        $dbprefix = "";
        class Database {

            var $db_connection = null;        // Database connection string
            var $db_server = null;            // Database server
            var $db_database = null;          // The database being connected to
            var $db_username = null;          // The database username
            var $db_password = null;          // The database password

            /** NewConnection Method
             * This method establishes a new connection to the database. */

            public function Connection(&$db_connection, &$db_server, &$db_username, &$db_password, $server, $username, $password) { //Avoid global variables within functions

                // Assign variables
                $db_server = $server;
                $db_username = $username;
                $db_password = $password;

                // Attempt connection 
                try {
                    // Create connection to MYSQL database
                    // Fourth true parameter will allow for multiple connections to be made
                    $db_connection = mysql_connect($server, $username, $password, true);
                    if (!$db_connection) {
                        throw new Exception('MySQL Connection Database Error: ' . mysql_error());
                    }
                } catch (Exception $e) { ?>
                    <div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0.7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right:.3em;"></span> <?php 
                    echo $e->getMessage(); ?> </p></div> <?php
                }
            }

            /** Open Method
             * This method opens the database connection (only call if closed!) */
            public function Open($db_connection, $db_server, $db_database, $db_username, $db_password) { //Avoid global variables within functions
                if (!$CONNECTED) {
                    try {
                        $db_connection = mysql_connect($db_server, $db_username, $db_password);
                        mysql_select_db($db_database);
                        if (!$db_connection) {
                            throw new Exception('MySQL Connection Database Error: ' . mysql_error());
                        }
                    } catch (Exception $e) {
                        ?> <div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0.7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right:.3em;"></span>
                        <?php echo $e->getMessage(); ?> </p></div> <?php
                    }
                } else {
                    $message = "No connection has been established to the database. Cannot open connection.";
                    return "<div class=\"ui-state-error ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em;\">
                <p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right:.3em;\"></span>" .
                            $message . "</p></div>";
                }
            }

            /** Close Method
             * This method closes the connection to the MySQL Database */
            public function Close($db_connection) { //Avoid global variables within functions
                if ($db_connection) {
                    mysql_close($db_connection);
                } else {
                    $message = "No connection has been established to the database. Cannot close connection.";
                    return "<div class=\"ui-state-error ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em;\">
                <p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right:.3em;\"></span>" .
                            $message . "</p></div>";
                }
            }

            public function get_Connection($db_connection) { //Avoid global variables within functions
                return $db_connection;
            }

            /** Create Database Method
             * This method creates database */
            public function CreateDatabase($database, $db_connection) { //Avoid global variables within functions
                if ($db_connection) {
                    if (!mysql_query("CREATE DATABASE $database", $db_connection)) {
                        $message = "Cannot create database." . mysql_error();
                        return "<div class=\"ui-state-error ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em;\">
                    <p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right:.3em;\"></span>" .
                                $message . "</p></div>";
                    }
                } else {
                    $message = "No connection has been established to the database. Cannot create database.";
                    return "<div class=\"ui-state-error ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em;\">
                        <p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right:.3em;\"></span>" .
                            $message . "</p></div>";
                }
            }

        }

        function get_server() {
            // Edit config/database.php file 
            $database_file = "application/config/database.php";
            $line_array = file($database_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['default']['hostname']")) {
                    $server = str_replace('$db[\'default\'][\'hostname\'] = ', "", $line_array[$i]);
                    $server = str_replace("'", "", $server);
                    $server = str_replace(";", "", $server);
                    $server = trim($server);
                    return $server;
                }
            }
        }

        function get_username() {
            // Edit config/database.php file 
            $database_file = "application/config/database.php";
            $line_array = file($database_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['default']['username']")) {
                    $username = str_replace('$db[\'default\'][\'username\'] = ', "", $line_array[$i]);
                    $username = str_replace("'", "", $username);
                    $username = str_replace(";", "", $username);
                    $username = trim($username);
                    return $username;
                }
            }
        }

        function get_password() {
            // Edit config/database.php file 
            $database_file = "application/config/database.php";
            $line_array = file($database_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['default']['password']")) {
                    $password = str_replace('$db[\'default\'][\'password\'] = ', "", $line_array[$i]);
                    $password = str_replace("'", "", $password);
                    $password = str_replace(";", "", $password);
                    $password = trim($password);
                    return $password;
                }
            }
        }

        function get_database() {
            $database_file = "application/config/database.php";
            $line_array = file($database_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['default']['database']")) {
                    $database = str_replace('$db[\'default\'][\'database\'] = ', "", $line_array[$i]);
                    $database = str_replace("'", "", $database);
                    $database = str_replace(";", "", $database);
                    $database = trim($database);
                    return $database;
                }
            }
        }

        function get_dbprefix() {
            $database_file = "application/config/database.php";
            $line_array = file($database_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['default']['dbprefix']")) {
                    $dbprefix = str_replace('$db[\'default\'][\'dbprefix\'] = ', "", $line_array[$i]);
                    $dbprefix = str_replace("'", "", $dbprefix);
                    $dbprefix = str_replace(";", "", $dbprefix);
                    $dbprefix = trim($dbprefix);
                    return $dbprefix;
                }
            }
        }

        function is_installed() {
            $config_file = "application/config/config.php";
            $line_array = file($config_file);

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['install']")) {
                    if (strstr($line_array[$i], '$config[\'install\'] = 0;')) {
                        // Application is not installed
                        return false;
                    } elseif (strstr($line_array[$i], '$config[\'install\'] = 1;')) {
                        // Application is installed
                        return true;
                    }
                }
            }
        }

        function display_information($message) {
            ?> <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0.7em;">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right:.3em;"></span>
             <?php echo $message; ?> </p></div> <?php
        }

        function display_error($message) {
            ?> <div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0.7em;">
            <p><span class="ui-icon ui-icon-info" style="float: left; margin-right:.3em;"></span>
            <?php echo $message; ?> </p></div> <?php
        }

        function execute_sql($sql, $con) {
            if (!mysql_query($sql, $con)) {
                $message = "Error : " . mysql_error() . " while executing : " . $sql;
                display_error($message);
            }
        }

        /** Create Table */
//        function create_address($dbprefix, $con) {
//            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "address (
//            address_id      int(11)      NOT NULL AUTO_INCREMENT,
//            contact_id      int(11)      NOT NULL,
//            type            varchar(50)  NOT NULL,
//            address_line_1  varchar(150) NOT NULL,
//            address_line_2  varchar(150) NOT NULL,
//            city            varchar(50)  NOT NULL,
//            state           varchar(50)  NOT NULL,
//            postal_code     varchar(50)  NOT NULL,
//            country         varchar(50)  NOT NULL,
//            PRIMARY KEY (address_id)
//            );";
//            if (!mysql_query($sql, $con)) {
//                $message = "Error creating table " . $dbprefix . "address : " . mysql_error();
//                display_error($message);
//            } else {
//                display_information("Table Address Created");
//            }
//        }

        function create_appointments($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "appointments (
            appointment_id      int(11)      NOT NULL AUTO_INCREMENT,
            appointment_date    date         NOT NULL,
            start_time          time         NOT NULL,
            end_time            time         NOT NULL,
            title               varchar(150) NOT NULL,
            patient_id          int(11)      NOT NULL,
            userid              int(11)      NOT NULL,
            status              varchar(255) NOT NULL,
            PRIMARY KEY (appointment_id)
            );";
            if (!mysql_query(addslashes($sql), $con)) {
                $message = "Error creating table " . $dbprefix . "appointments : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Appointments Created");
            }
        }

        function create_appointment_log($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "appointment_log (
            appointment_id      int(11)      NOT NULL,
            change_date_time    varchar(255) NOT NULL,
            start_time          time         NOT NULL,
            from_time           time         NOT NULL,
            to_time             time         NOT NULL,
            old_status          varchar(255) NOT NULL,
            status              varchar(255) NOT NULL,
            name                varchar(255) NOT NULL
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "appointment_log : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Appointment Log Created");
            }
        }

        function create_bill($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "bill (
            bill_id         int(11)       NOT NULL AUTO_INCREMENT,
            bill_date       date          NOT NULL,
            patient_id      int(11)       NOT NULL,
            visit_id        int(11)       NOT NULL,
            total_amount    decimal(10,0) NOT NULL,
            due_amount      decimal(11,2) NOT NULL,
            PRIMARY KEY (bill_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "bill : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Bill Created");
            }
        }

        function create_bill_detail($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "bill_detail (
                bill_detail_id  int(11)         NOT NULL AUTO_INCREMENT,
                bill_id         int(11)         NOT NULL,
                particular      varchar(50)     NOT NULL,
                amount          decimal(10,2)   NOT NULL,
                quantity        int(11)         NOT NULL,			
                mrp             decimal(10,2)	NOT NULL,			
                type            varchar(25)	NOT NULL,
                purchase_id     int(11),
                PRIMARY KEY (bill_detail_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "bill_detail : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Bill_Detail Created");
            }
        }

        function create_clinic($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "clinic (
            clinic_id           int(11)       NOT NULL,
            start_time          varchar(10)    NOT NULL,
            end_time            varchar(10)    NOT NULL,
            time_interval       decimal(11,2) NOT NULL DEFAULT '0.50',
            clinic_name         varchar(50),
            tag_line            VARCHAR(100),
            clinic_address      VARCHAR(500),
            landline            VARCHAR(50),
            mobile              VARCHAR(50),
            email               VARCHAR(50),
            next_followup_days  int(11)       NOT NULL DEFAULT '15'
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "clinic : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Clinic Created");
            }
            $sql = "INSERT INTO " . $dbprefix . "clinic (clinic_id, start_time, end_time) VALUES (1, '9:00am', '7:00pm');";
            if (!mysql_query((mysql_escape_string($sql), $con)) {
                $message = "Error inserting records in table " . $dbprefix . "clinic : " . mysql_error();
                display_error($message);
            }
        }

        function create_contacts($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "contacts (
            contact_id      int(11) NOT     NULL AUTO_INCREMENT,
            first_name      varchar(50)     DEFAULT NULL,
            middle_name     varchar(50)     DEFAULT NULL,
            last_name       varchar(50)     NOT NULL,
            display_name    varchar(255)    NOT NULL,
            phone_number    varchar(15)     NOT NULL,
            email           varchar(150)    NOT NULL,            
            contact_image   varchar(255)    NOT NULL DEFAULT 'images/Profile.png',
            type            varchar(50)     NOT NULL,
            address_line_1  varchar(150)    NOT NULL,
            address_line_2  varchar(150)    NOT NULL,
            city            varchar(50)     NOT NULL,
            state           varchar(50)     NOT NULL,
            postal_code     varchar(50)     NOT NULL,
            country         varchar(50)     NOT NULL,
            PRIMARY KEY (`contact_id`)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "contacts : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Contacts Created");
            }
        }

        function create_contact_details($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "contact_details (
            contact_detail_id   int(11)      NOT NULL AUTO_INCREMENT,
            contact_id          int(11)      NOT NULL,
            type                varchar(50)  NOT NULL,
            detail              varchar(150) NOT NULL,
            PRIMARY KEY (contact_detail_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "contact_details : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Contact_Details Created");
            }
        }

        function create_invoice($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "invoice (
            invoice_id      INT(11) NOT NULL AUTO_INCREMENT ,
            static_prefix   VARCHAR( 10 ) NOT NULL ,
            left_pad        INT(11) NOT NULL ,
            next_id         INT(11) NOT NULL ,
            currency_symbol VARCHAR(10) NOT NULL,
	    currency_postfix    char(10)    NOT NULL DEFAULT '/-',
            PRIMARY KEY ( invoice_id )
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "invoice : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Invoice Created");
            }
            $sql = "INSERT INTO " . $dbprefix . "invoice (static_prefix, left_pad, next_id,currency_symbol) VALUES ('', 4, 1,'Rs.');";
            if (!mysql_query(mysql_escape_string($sql), $con)) {
                $message = "Error inserting records in table " . $dbprefix . "invoice : " . mysql_error();
                display_error($message);
            }
        }

        function create_item($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "item (
            item_id         INT(11)         NOT NULL AUTO_INCREMENT ,
            item_name       VARCHAR( 100 )  NOT NULL ,
            desired_stock   INT(11) ,
            PRIMARY KEY ( item_id )
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "item : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Item Created");
            }
        }

        function create_patient($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "patient (
            patient_id      int(11)      NOT NULL AUTO_INCREMENT,
            contact_id      int(11)      NOT NULL,
            patient_since   date         NOT NULL,
            display_id      varchar(12)  NOT NULL,
            followup_date   date         NOT NULL,
            reference_by    varchar(255) NOT NULL,
            PRIMARY KEY (patient_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "patient : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Patient Created");
            }
        }

        function create_payment($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "payment (
            payment_id  int(11)         NOT NULL AUTO_INCREMENT,
            bill_id     int(11)         NOT NULL,
            pay_date    date            NOT NULL,
            pay_mode    varchar(50)     NOT NULL,
            amount      decimal(10,0)   NOT NULL,
            cheque_no   varchar(50)     NOT NULL,
            PRIMARY KEY (payment_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "payment : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Payment Created");
            }
        }

        function create_payment_transaction($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "payment_transaction (
            transaction_id  int(11)         NOT NULL AUTO_INCREMENT,
            bill_id         int(11),
            patient_id      int(11)         NOT NULL,
            visit_id        int(11)         NOT NULL,
            amount          decimal(11,2)   NOT NULL,
            payment_type    varchar(50)     NOT NULL,
            PRIMARY KEY (transaction_id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "payment_transaction : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Payment Transaction Created");
            }
        }

        function create_purchase($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "purchase (
            purchase_id     int(11)      NOT NULL AUTO_INCREMENT,
            purchase_date   date         DEFAULT NULL,
            item_id         int(11)      NOT NULL ,
            quantity        int(11)      NOT NULL ,
            supplier_id     int(11)      NOT NULL ,
            cost_price      DECIMAL(10,0) DEFAULT NULL,
            remain_quantity int(11)      NOT NULL ,
            bill_no         varchar(255) NOT NULL,
            mrp             float(11,2)  NOT NULL,
            PRIMARY KEY (purchase_id)
        );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "purchase : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Purchase Created");
            }
        }

        function create_sell($dbprefix, $con) {

            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "sell (
            sell_id     INT(11)         NOT NULL AUTO_INCREMENT ,
            sell_date   DATE            NOT NULL ,
            patient_id  INT(11)         NOT NULL ,
            visit_id    INT(11)         NOT NULL ,
            sell_amount DECIMAL(10,0),
            PRIMARY KEY ( sell_id )
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "sell : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Sell Created");
            }
        }

        function create_sell_detail($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "sell_detail (
            sell_detail_id  INT(11)         NOT NULL AUTO_INCREMENT ,
            sell_id         INT(11)         NOT NULL ,
            item_id         INT(11)         NOT NULL ,
            quantity        INT(11)         NOT NULL ,
            sell_price      DECIMAL(10,0),
            sell_amount     DECIMAL(10,0),
            PRIMARY KEY ( sell_detail_id )
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "sell_detail : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Sell Detail Created");
            }
        }

        function create_supplier($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "supplier (
            supplier_id     INT(11)          NOT NULL AUTO_INCREMENT ,
            supplier_name   VARCHAR( 100 )   NOT NULL ,
            contact_number  VARCHAR(100) ,
            PRIMARY KEY ( supplier_id )
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "supplier : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Supplier Created");
            }
        }
        
        function create_todos($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS ". $dbprefix. "todos (
                id_num      int(11)         NOT NULL AUTO_INCREMENT,
                userid      int(11)         DEFAULT '0',
                todo        varchar(250)    DEFAULT NULL,
                done        int(11)         DEFAULT '0',
                add_date    datetime        DEFAULT NULL,
                done_date   datetime        DEFAULT NULL,
                PRIMARY KEY (id_num));";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "todos : " . mysql_error()."<br/>".$sql;
                display_error($message);
            } else {
                display_information("Table Todos Created");
            }
        }
        
        function create_treatments($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS ". $dbprefix. "treatments (
                id int(11) NOT NULL AUTO_INCREMENT,
                treatment varchar(80) DEFAULT NULL,
                price float(11,2) DEFAULT NULL,
                PRIMARY KEY (id),
                UNIQUE KEY treatment (treatment));";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "treatments : " . mysql_error()."<br/>".$sql;
                display_error($message);
            } else {
                display_information("Table Treatments Created");
            }
        }
        
        function create_users($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "users (
            userid      int(11) NOT     NULL AUTO_INCREMENT,
            name        varchar(255)    DEFAULT NULL,
            username    varchar(16)     DEFAULT NULL,
            password    varchar(255)    NOT NULL,
            level       varchar(15)     NOT NULL,
            PRIMARY KEY (userid),
            UNIQUE KEY username (username)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "users : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Users Created");
            }
            $sql = "INSERT INTO " . $dbprefix . "users (userid, name, username,password,level) VALUES (1, 'Administrator', 'admin','" . base64_encode('admin') . "','Administrator');";
            if (!mysql_query(mysql_escape_string($sql), $con)) {
                $message = "Error inserting records in table " . $dbprefix . "clinic : " . mysql_error();
                display_error($message);
            }
        }

        function create_version($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "version (current_version varchar(11) NOT NULL);";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "version" . " : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Version Created");
            }
            $sql = "INSERT INTO " . $dbprefix . "version (current_version) VALUES ('0.0.6');";
            if (!mysql_query(mysql_escape_string($sql), $con)) {
                $message = "Error inserting records in table " . $dbprefix . "version : " . mysql_error();
                display_error($message);
            }
        }

        function create_visit($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "visit (
            visit_id    int(11)     NOT NULL AUTO_INCREMENT,
            patient_id  int(11)     NOT NULL,
            userid      int(11)     NOT NULL,
            notes       text        NOT NULL,
            type        varchar(50) NOT NULL,
            visit_date  varchar(60) NOT NULL,
            visit_time  varchar(50),            
            PRIMARY KEY (`visit_id`)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "visit : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Visit Created");
            }
        }

        function create_visit_img($dbprefix, $con) {
            $sql = "CREATE TABLE IF NOT EXISTS " . $dbprefix . "visit_img (
            id              int(11)         NOT NULL AUTO_INCREMENT,
            visit_id        int(11)         NOT NULL,
            patient_id      int(11)         NOT NULL,
            visit_img_path  varchar(255)    NOT NULL,
            img_name        varchar(11)     NOT NULL,
            PRIMARY KEY (id)
            );";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating table " . $dbprefix . "visit_img : " . mysql_error();
                display_error($message);
            } else {
                display_information("Table Visit Image Created");
            }
        }

        /** Create View */
//        function create_view_address($dbprefix, $con) {
//            $sql = "create or replace view " . $dbprefix . "view_address as
//            select address_id,
//                   contact_id,
//                   type address_type,
//	           concat(address_line_1,',',address_line_2,',',city,',',state,',',country,',',postal_code) as address
//              from " . $dbprefix . "address;";
//            if (!mysql_query($sql, $con)) {
//                $message = "Error creating view " . $dbprefix . "view_address : " . mysql_error();
//                display_error($message);
//            } else {
//                display_information("Create View View_Address");
//            }
//        }

        function create_view_bill($dbprefix, $con) {
            $sql = "create or replace view " . $dbprefix . "view_bill as
            SELECT a.bill_id, particular, amount, TYPE , visit_id
            FROM " . $dbprefix . "bill AS a, " . $dbprefix . "bill_detail AS b
            WHERE a.bill_id = b.bill_id;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_bill : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Purchase");
            }
        }

        function create_view_bill_detail_report($dbprefix, $con) {
            $sql = "CREATE OR REPLACE VIEW " . $dbprefix . "view_bill_detail_report AS
       select bill.bill_id,
              bill.bill_date,
              bill.visit_id,
              bill_detail.particular,
              bill_detail.amount,
              visit.userid,
              CONCAT(view_patient.first_name,' ',view_patient.middle_name, ' ',view_patient.last_name) as patient_name,
              view_patient.display_id,
			  bill_detail.type
       from " . $dbprefix . "bill as bill
       LEFT JOIN " . $dbprefix . "bill_detail as bill_detail ON bill_detail.bill_id = bill.bill_id
       LEFT JOIN " . $dbprefix . "visit as visit ON visit.visit_id = bill.visit_id
       LEFT JOIN " . $dbprefix . "view_patient as view_patient ON view_patient.patient_id =bill.patient_id;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_bill_detail_report : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Bill_Detail_Report");
            }
        }

        function create_view_bill_total($dbprefix, $con) {
            $sql = "CREATE OR REPLACE VIEW " . $dbprefix . "view_bill_total AS
    SELECT `purchase_date`,
            `bill_no`,
            sum(`quantity`*`cost_price`) AS total 
    FROM " . $dbprefix . "purchase GROUP BY bill_no;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_bill_total : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Bill_Total");
            }
        }

//        function create_view_contacts($dbprefix, $con) {
//            $sql = "Create or replace View " . $dbprefix . "view_contacts
//            as
//            Select  " . $dbprefix . "contacts.contact_id, 
//                    first_name,
//                    middle_name,
//                    last_name,
//                    phone_number,
//                    " . $dbprefix . "address.address_id,
//                    " . $dbprefix . "address.type address_type,
//                    address_line_1,
//                    address_line_2,
//                    city,
//                    state,
//                    country,
//                    postal_code
//               from " . $dbprefix . "contacts, 
//                    " . $dbprefix . "address
//              where " . $dbprefix . "contacts.contact_id = " . $dbprefix . "address.contact_id;";
//            if (!mysql_query($sql, $con)) {
//                $message = "Error creating view " . $dbprefix . "view_contacts : " . mysql_error();
//                display_error($message);
//            } else {
//                display_information("Create View View_Contacts");
//            }
//        }

        function create_view_contact_email($dbprefix, $con) {
            $sql = "Create or replace View " . $dbprefix . "view_contact_email as
            Select contact_id,detail email
            from " . $dbprefix . "contact_details
            where type = 'email';";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_contact_email : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Contact_Email");
            }
        }

        function create_view_email($dbprefix, $con) {
            $sql = "create or replace view " . $dbprefix . "view_email as 
            select contact_id,
                   group_concat(detail) as emails
              from " . $dbprefix . "contact_details 
             where type = 'email'
             group by contact_id;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_email : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Email");
            }
        }

        function create_view_patient($dbprefix, $con) {

            $sql = "create or replace view " . $dbprefix . "view_patient as 
            Select patient.patient_id,
                   appointment.userid,
                   patient.patient_since,
                   patient.display_id,
                   patient.reference_by,
                   contacts.display_name,
                   contacts.contact_id,
                   contacts.first_name,
                   contacts.middle_name,
                   contacts.last_name,
                   contacts.phone_number,
                   view_email.emails                   
              from " . $dbprefix . "patient as patient
                    LEFT JOIN " . $dbprefix . "contacts as contacts ON patient.contact_id = contacts.contact_id
                    LEFT JOIN " . $dbprefix . "appointments as appointment ON patient.patient_id = appointment.patient_id
                    LEFT JOIN " . $dbprefix . "view_email as view_email ON view_email.contact_id = contacts.contact_id;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_patient : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Patient");
            }
        }

        function create_view_purchase($dbprefix, $con) {
            $sql = "create or replace view " . $dbprefix . "view_purchase as
            select purchase_id,purchase_date,item_name,quantity,
            supplier_name,cost_price,a.item_id,a.supplier_id,a.remain_quantity,a.bill_no,a.mrp
             from " . $dbprefix . "purchase as a, " . $dbprefix . "item as b, " . $dbprefix . "supplier as c
            where a.item_id = b.item_id
              and a.supplier_id = c.supplier_id;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_purchase : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Purchase");
            }
        }

        function create_view_report($dbprefix, $con) {
            $sql = "create or replace view " . $dbprefix . "view_report as
            Select appointment.userid,
                CONCAT(view_patient.first_name,' ',view_patient.middle_name, ' ',view_patient.last_name) as patient_name,
                appointment.appointment_date,
                min(appointment.start_time) as appointment_time,
                max(CASE appointment_log.old_status WHEN 'Waiting' THEN appointment_log.from_time END)  as waiting_in,
                max(CASE appointment_log.old_status WHEN 'Waiting' THEN timediff(appointment_log.to_time,appointment_log.from_time) END)  as waiting_duration,
                max(CASE appointment_log.old_status WHEN 'Consultation' THEN appointment_log.from_time END)  as consultation_in,
                max(CASE appointment_log.old_status WHEN 'Consultation' THEN timediff(appointment_log.to_time,appointment_log.from_time) END)  as consultation_duration,
                max(bill.total_amount) as collection_amount
            from  " . $dbprefix . "appointments as appointment
		LEFT JOIN " . $dbprefix . "view_patient as view_patient ON appointment.patient_id = view_patient.patient_id
		LEFT JOIN " . $dbprefix . "bill as bill ON appointment.patient_id = bill.patient_id
		LEFT JOIN " . $dbprefix . "appointment_log as appointment_log ON appointment.appointment_id = appointment_log.appointment_id
            WHERE appointment_log.old_status in ('Waiting','Consultation')
            GROUP BY appointment.appointment_date,patient_name;";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_report : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Report");
            }
        }

        function create_view_stock($dbprefix, $con) {
            $sql = "CREATE or replace VIEW " . $dbprefix . "view_stock AS
            Select  a.item_id,a.item_name,a.desired_stock,
                    (select sum(b.quantity) from " . $dbprefix . "purchase b where a.item_id = b.item_id) purchase_quantity,
                    (select avg(b.cost_price) from " . $dbprefix . "purchase b where a.item_id = b.item_id) avg_purchase_price,
                    (select sum(c.quantity) from " . $dbprefix . "sell_detail c where a.item_id = c.item_id) sell_quantity,
                    (select avg(c.sell_price) from " . $dbprefix . "sell_detail c where a.item_id = c.item_id) avg_sell_price
               from " . $dbprefix . "item a";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_stock : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Stock");
            }
        }
        
        function create_view_visit_treatments($dbprefix, $con) {
            $sql = "CREATE OR REPLACE view " . $dbprefix . "view_visit_treatments as 
                SELECT visit.visit_id,
                       bill_detail.particular,
                       bill_detail.type 
                FROM " . $dbprefix . "visit AS visit 
                LEFT JOIN " . $dbprefix . "bill AS bill ON bill.visit_id = visit.visit_id 
                LEFT JOIN " . $dbprefix . "bill_detail AS bill_detail ON bill_detail.bill_id = bill.bill_id";
            if (!mysql_query($sql, $con)) {
                $message = "Error creating view " . $dbprefix . "view_visit_treatments : " . mysql_error();
                display_error($message);
            } else {
                display_information("Create View View_Visit_Treatments");
            }
        }
        ?>
        <?php
        if (!isset($_GET["step"])) {
            /** Step 1 */
            // Check if application is installled or not      
            if (is_installed()) {
                /** Check the version */
                $server = get_server();
                $username = get_username();
                $password = get_password();
                $database = get_database();
                $dbprefix = get_dbprefix();

                // Connect to Server 
                $conn = new Database;
                echo $conn->Connection($server, $username, $password);
                $con = $conn->get_Connection();

                // Select Database 
                mysql_select_db($database, $con);
                $sql = "Select current_version from " . $dbprefix . "version;";
                $result = mysql_query(($sql), $con);
                if (!$result) {
                    $current_version = '0.0.1';
                    create_version($dbprefix, $con);
                } else {
                    $row = mysql_fetch_assoc($result);
                    $current_version = $row['current_version'];
                }
				// corretto errore issue #9665
                display_information(htmlentities("Current Version :" . $current_version));
                if ($current_version == $latest_version) {
                    display_information("You have latest version of application installed. <br/>Please delete the install.php file");
                } else {
                    if ($current_version == '0.0.1') {
                        display_information("Upgrading from 0.0.1 to 0.0.2");

                        $sql = "RENAME TABLE " . $dbprefix . 'settings' . " TO " . $dbprefix . 'clinic' . ";";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD clinic_name VARCHAR(50);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD tag_line VARCHAR(100);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD clinic_address VARCHAR(500);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD landline VARCHAR(50);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD mobile VARCHAR(50);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD email VARCHAR(50);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " CHANGE  settings_id  clinic_id INT( 11 ) NOT NULL";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'visit' . " ADD visit_time VARCHAR(50);";
                        execute_sql($sql, $con);

                        create_bill($dbprefix, $con);
                        create_bill_detail($dbprefix, $con);
                        create_payment($dbprefix, $con);
                        create_invoice($dbprefix, $con);


                        $current_version = '0.0.2';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        execute_sql($sql, $con);
                    }
                    if ($current_version == '0.0.2') {
                        display_information("Upgrading from 0.0.2 to 0.0.3");
                        create_item($dbprefix, $con);
                        create_supplier($dbprefix, $con);
                        create_purchase($dbprefix, $con);
                        create_sell($dbprefix, $con);
                        create_sell_detail($dbprefix, $con);

                        create_view_purchase($dbprefix, $con);
                        create_view_stock($dbprefix, $con);
                        $current_version = '0.0.3';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        execute_sql($sql, $con);
                    }
                    if ($current_version == '0.0.3') {
                        display_information("Upgrading from 0.0.3 to 0.0.4");

                        $current_version = '0.0.4';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        execute_sql($sql, $con);
                    }
                    if ($current_version == '0.0.4') {

                        display_information("Upgrading from 0.0.4 to 0.0.5");
                        
                        /* ADD NEW COLUMNs IN invoice TABLE */ 
                        $sql = "ALTER TABLE " . $dbprefix . 'invoice' . " ADD currency_symbol VARCHAR(10) NOT NULL;";
                        execute_sql($sql, $con);
                        
                        /* ADD DETAIL OF CURRENCY SYMBOL IN invoice TABLE */
                        $sql = "UPDATE " . $dbprefix . 'invoice' . " SET currency_symbol ='Rs.';";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN bill_detail TABLE */ 
                        $sql = "ALTER TABLE " . $dbprefix . 'bill_detail' . " ADD quantity int(11) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'bill_detail' . " ADD mrp	decimal(10,2)	NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'bill_detail' . " ADD type	varchar(25)	NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'bill_detail' . " ADD purchase_id     int(11);";
                        execute_sql($sql, $con);
                        
                        /* REMOVE COLUMNs FROM payment TABLE */ 
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " DROP pay_date;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " DROP pay_mode;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " DROP amount;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " DROP cheque_no;";                        
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN payment TABLE */
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " ADD patient_id int(11);";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'payment' . " ADD pay_amount decimal(11,2);";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN appointments TABLE */
                        $sql = "ALTER TABLE " . $dbprefix . 'appointments' . " ADD userid int(11) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'appointments' . " ADD status varchar(255) NOT NULL;";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN patient TABLE */ 
                        $sql = "ALTER TABLE " . $dbprefix . 'patient' . " ADD display_id varchar(12) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'patient' . " ADD followup_date date NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'patient' . " ADD reference_by varchar(255) NOT NULL;";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN contacts TABLE */ 
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD display_name varchar(255) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD email varchar(150) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD type varchar(50) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD address_line_1 varchar(150) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD address_line_2 varchar(150) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD city varchar(50) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD state varchar(50) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD postal_code varchar(50) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'contacts' . " ADD country varchar(50) NOT NULL;";
                        execute_sql($sql, $con);

                        /* ADD DETAIL OF ADDRESS FROM ck_address TABLE TO contacts TABLE */
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.type' . " = " . $dbprefix . 'address.type' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.address_line_1' . " = " . $dbprefix . 'address.address_line_1' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.address_line_2' . " = " . $dbprefix . 'address.address_line_2' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.city' . " = " . $dbprefix . 'address.city' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.state' . " = " . $dbprefix . 'address.state' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.postal_code' . " = " . $dbprefix . 'address.postal_code' . ";";
                        execute_sql($sql, $con);
                        $sql = "UPDATE " . $dbprefix . 'contacts' . " INNER JOIN " . $dbprefix . 'address' . " ON (" . $dbprefix . 'contacts.contact_id' . " = " . $dbprefix . 'address.contact_id' . ") SET " . $dbprefix . 'contacts.country' . " = " . $dbprefix . 'address.country' . ";";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN visit TABLE */
                        $sql = "ALTER TABLE " . $dbprefix . 'visit' . " ADD userid int(11) NOT NULL;";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN clinic TABLE */
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD time_interval decimal(11,2) NOT NULL DEFAULT '0.50';";
                        execute_sql($sql, $con);
                        
                        /* ADD NEW COLUMNs IN purchase TABLE */
                        $sql = "ALTER TABLE " . $dbprefix . 'purchase' . " ADD remain_quantity INT NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'purchase' . " ADD bill_no varchar(255) NOT NULL;";
                        execute_sql($sql, $con);
                        $sql = "ALTER TABLE " . $dbprefix . 'purchase' . " ADD mrp float(11,2) NOT NULL;";
                        execute_sql($sql, $con);
                        
                        /* DROP address TABLE */
                        $sql = "DROP TABLE IF EXISTS ". $dbprefix . 'address' . ";";
                        execute_sql($sql, $con);
                        
                        /* DROP view_address VIEW */
                        $sql = "DROP VIEW IF EXISTS ". $dbprefix . 'view_address' . ";";
                        execute_sql($sql, $con);
                        
                        /* DROP view_contacts VIEW */
                        $sql = "DROP VIEW IF EXISTS ". $dbprefix . 'view_contacts' . ";";
                        execute_sql($sql, $con);
                        
                        /* CALL FUNCTION TO CREATE NEW TABLES  */
                        create_users($dbprefix, $con);
                        create_appointment_log($dbprefix, $con);
                        create_payment_transaction($dbprefix, $con);
                        create_visit_img($dbprefix, $con);
                        
                        
                        /* CALL FUNCTION TO CREATE NEW VIEWS*/
                        create_view_bill($dbprefix, $con);
                        create_view_patient($dbprefix, $con);
                        create_view_purchase($dbprefix, $con);
                        create_view_report($dbprefix, $con);
                        create_view_bill_detail_report($dbprefix, $con);
                        create_view_bill_total($dbprefix, $con);                        
                        
                        $current_version = '0.0.5';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        if (!mysql_query(mysql_escape_string($sql), $con)) {
                            $message = "Error updating records in table " . $dbprefix . "version : " . mysql_error();
                            display_error($message);
                        }
                    }
                    if ($current_version == '0.0.5'){
                        display_information("Upgrading from 0.0.5 to 0.0.6");
                        
                        $sql = "ALTER TABLE " . $dbprefix . 'bill' . " ADD due_amount decimal(11,2) DEFAULT '0.00';";
                        execute_sql($sql, $con);
                        
                        create_todos($dbprefix, $con);
                        create_treatments($dbprefix, $con);
                        create_view_patient($dbprefix, $con);
                        create_view_visit_treatments($dbprefix, $con);
						
                        $current_version = '0.0.6';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        if (!mysql_query($sql, $con)) {
                            $message = "Error updating records in table " . $dbprefix . "version : " . mysql_error();
                            display_error($message);
                        }
                    }
                    if ($current_version == '0.0.6'){
                         display_information("Upgrading from 0.0.5 to 0.0.6");
                        
                        $sql = "ALTER TABLE " . $dbprefix . 'clinic' . " ADD next_followup_days int(11) DEFAULT '15';";
                        execute_sql($sql, $con);
                        
			$sql = "ALTER TABLE " . $dbprefix . 'invoice' . " ADD currency_postfix CHAR(10) DEFAULT '/-';";
                        execute_sql($sql, $con);

                        $current_version = '0.0.7';
                        $sql = "UPDATE " . $dbprefix . "version SET current_version='" . $current_version . "';";
                        if (!mysql_query($sql, $con)) {
                            $message = "Error updating records in table " . $dbprefix . "version : " . mysql_error();
                            display_error($message);
                        }
                    }
                }
            } else {
                /** Ask for Database Credentials */
                echo "<br/>";
                echo "<br/>";
                echo "<div class=\"form_style\">";
                ?> <h2>Chikitsa - Installation</h2> <?php
                echo "<form method='post' action='install.php?step=2' >";
                echo "<div id=\"install\">";
                ?> <label for='server'>Database Host<span class="small">You should be able to get this info from your web host, if localhost does not work.</span></label> <?php
                echo "<input type='text' name='server' value=\"localhost\">";
                ?> </div><div id="install">
				   <label for='dbname'>Database Name<span class="small">The name of the database you want to run Chikitsa in.</span></label> <?php
                echo "<input type='text' name='dbname'><input type='checkbox' name='createdb' value='createdb'>Create database<br/>";
                ?> </div><div id="install">
                   <label for='tableprefix'>Table Prefix<span class="small">If you want to run multiple Chikitsa installations in a single database, change this.</span></label> <?php
                echo "<input type='text' name='tableprefix' value=\"ck_\"><br/>";
                ?> </div><div id="install">
                   <label for='username'>User Name<span class="small">Your MySQL username</span></label> <?php
                echo "<input type='text' name='username'><br/>";
                ?> </div><div id="install">
                   <label for='password'>Password<span class="small">...and your MySQL password</span></label> <?php
                echo "<input type='text' name='password'><br/>";
                ?> </div><div id="install">
                   <button type="submit" name="submit" class="submit"/></button>
                   <br/></div></form></div> <?php
            }
        } elseif ($_GET["step"] == 2) {
            // Step 2 - Install the application for the first time
            // Connect to Server 

            $conn = new Database;
            echo $conn->Connection(filter_input(INPUT_POST,'server',FILTER_SANITIZE_MAGIC_QUOTES), filter_input(INPUT_POST,'username',FILTER_SANITIZE_MAGIC_QUOTES), filter_input(INPUT_POST,'password',FILTER_SANITIZE_MAGIC_QUOTES));
            $con = $conn->get_Connection();

            // Create Database
            echo $conn->CreateDatabase(filter_input(INPUT_POST,'dbname',FILTER_SANITIZE_MAGIC_QUOTES), $con);
            // Create Tables 
            mysql_select_db(filter_input(INPUT_POST,'dbname',FILTER_SANITIZE_MAGIC_QUOTES), $con);
			//corretto errore issue #9662
            $table_prefix = filter_input(INPUT_POST,'tableprefix',FILTER_SANITIZE_MAGIC_QUOTES);

//            create_address($table_prefix, $con);
            create_appointments($table_prefix, $con);
            create_appointment_log($table_prefix, $con);
            create_contacts($table_prefix, $con);
            create_contact_details($table_prefix, $con);
            create_patient($table_prefix, $con);
            create_clinic($table_prefix, $con);
            create_invoice($table_prefix, $con);
            create_visit($table_prefix, $con);
            create_bill($table_prefix, $con);
            create_bill_detail($table_prefix, $con);
            create_payment($table_prefix, $con);
            create_payment_transaction($table_prefix, $con);
            create_item($table_prefix, $con);
            create_supplier($table_prefix, $con);
            create_purchase($table_prefix, $con);
            create_sell($table_prefix, $con);
            create_sell_detail($table_prefix, $con);
            create_visit_img($table_prefix, $con);
            create_users($table_prefix, $con);
            create_todos($table_prefix, $con);
            create_treatments($table_prefix, $con);
            create_version($table_prefix, $con);
            
            create_view_purchase($table_prefix, $con);
            create_view_stock($table_prefix, $con);
            create_view_contact_email($table_prefix, $con);
//            create_view_contacts($table_prefix, $con);
            create_view_email($table_prefix, $con);
            create_view_patient($table_prefix, $con);
//            create_view_address($table_prefix, $con);
            create_view_bill($table_prefix, $con);
            create_view_report($table_prefix, $con);
            create_view_bill_detail_report($table_prefix, $con);
            create_view_bill_total($table_prefix, $con);
            create_view_visit_treatments($table_prefix, $con);            // Close Connection
            $conn->Close();

            // Edit config/database.php file 
            $database_file = "application/config/database.php";
            $line_array = file(htmlspecialchars($database_file)); // BUG FIXED: Avoid non-neutralized user-controlled input to be part of a pathname (file or directory) used in I/O operations

            for ($i = 0; $i < count($line_array); $i++) {

                if (strstr($line_array[$i], "['default']['hostname']")) {
                    $line_array[$i] = '$db[\'default\'][\'hostname\'] = \'' . $_POST["server"] . '\';' . "\n";
                }
                if (strstr($line_array[$i], "['default']['username']")) {
                    $line_array[$i] = '$db[\'default\'][\'username\'] = \'' . $_POST["username"] . '\';' . "\n";
                }
                if (strstr($line_array[$i], "['default']['password']")) {
                    $line_array[$i] = '$db[\'default\'][\'password\'] = \'' . $_POST["password"] . '\';' . "\n";
                }
                if (strstr($line_array[$i], "['default']['database']")) {
                    $line_array[$i] = '$db[\'default\'][\'database\'] = \'' . $_POST["dbname"] . '\';' . "\n";
                }
                if (strstr($line_array[$i], "['default']['dbprefix']")) {
                    $line_array[$i] = '$db[\'default\'][\'dbprefix\'] = \'' . $table_prefix . '\';' . "\n";
                }
            }
            file_put_contents(htmlspecialchars($database_file), htmlspecialchars($line_array)); // BUG FIXED: Avoid non-neutralized user-controlled input to be part of a pathname (file or directory) used in I/O operations

            //Store that application is installed
            $config_file = "application/config/config.php";
            $line_array = file(htmlspecialchars($config_file)); // BUG FIXED: Avoid non-neutralized user-controlled input to be part of a pathname (file or directory) used in I/O operations

            for ($i = 0; $i < count($line_array); $i++) {
                if (strstr($line_array[$i], "['install']")) {
                    $line_array[$i] = '$config[\'install\'] = 1;' . "\n";
                }
            }
            file_put_contents(htmlspecialchars($config_file), htmlspecialchars($line_array)); // BUG FIXED: Avoid non-neutralized user-controlled input to be part of a pathname (file or directory) used in I/O operations
        }
		
		/* Get Page Url */
        $pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }        
        $pageURL = explode("/", $pageURL);        
        $base_path = '';
        for($i=0; $i < (sizeof($pageURL)-1); $i++){
            $base_path .= $pageURL[$i] . "/";
        }
        ?>
		
		<div style="padding-left: 46%;padding-top: 50px;">
            <a class="button" title="Goto Application" href="<?php echo $base_path . 'index.php/login/index';?>">Goto Application</a>
        </div>
    </body>
</html>
