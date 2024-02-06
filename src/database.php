<?php

class Databases {
    
    /* database connection details */
    private $db_host = 'localhost'; 
    private $db_name = 'diary';
    private $db_user = 'root';
    private $db_pass = '';
    
    /* stored initialized connection */
    protected $db;
    
    /* connect to the database */
    protected function dbConnect() { /* Functie connectie naar de database*/
        try { /* soortige if statement*/
            $db = new PDO("mysql:host=$this->db_host;dbname=$this->db_name",$this->db_user, $this->db_pass); /* Er wordt een variabel gemaakt om de gegevens van de database connectie in op te slaan*/
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); /*haalt alle errrors uit pdo op  */
            $this->db = $db; /* db is een verwijzing naar de variabel db*/
            return true; /* de connectie naar de data base is gelukt*/
        } catch (PDOException $ex) { /* Zet de error in de variabel $ex */
            return $ex; /*toont de error code*/
        }
    }
    
    /* close the database connection */
    protected function dbClose() { /* functie wordt gecreeerd*/
        $this->db = null;/* zorgt er voor dat de database connectie op nul is*/
    }
    
    /* generate sql and insert data into database */
    protected function dbInsert(string $table, array $columns_and_values, bool $return_id = false) { /* maakt een insert in to database functie aan */
        foreach ($columns_and_values as $column => $value) { /*voor elke colum*/
            $columns[] = $column;  /* de array columns wordt in een variabel gezet genaamt column */
            $params[] = ':'.str_replace(' ', '_', $column); /* : wordt vervangen een spatie of _ in de column*/
            $exe[':'.str_replace(' ', '_', $column)] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value); /* als de $value identiek is aan boolean en de value true is geeft het een 1 in anders 0 anders geeft het value aan*/
        }
        $sql = "INSERT INTO ".$table." (".implode(", ",$columns).") VALUES (".implode(", ",$params).");"; /* Voegt een ... toe en een zijn waarde */
        try {
            $stmt = $this->db->prepare($sql); /* bereid de sql voor */
            $stmt->execute($exe);  /* voert de prepare statement uit*/ 
            return ($return_id ? $this->db->lastInsertId() : true); /*laat de laatste ingevoerde id zien*/
        } catch (PDOException $ex) {
            return $ex->errorInfo; /* laat de error info zien */
        }
    }
    
    /* generate sql and selct data from database */
    protected function dbSelect(string $type, string $table, array $columns = ['*'], array $where_columns_and_values = null, int $limit = null, int $offset = null, array $order = null) {
        if ($where_columns_and_values !== null) {
            $where_clause = ' WHERE '; 
            foreach ($where_columns_and_values as $column => $value) { 
                $columns_and_params[] = $column.' = :'.str_replace(' ', '_', $column);
                $exe[':'.str_replace(' ', '_', $column)] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value);
            }
            $where_clause = $where_clause.implode(' AND ', $columns_and_params);
        }
        $sql = 'SELECT '.($columns[0] === '*' ? $columns[0] : implode(', ', $columns)).' FROM '.$table.(is_null($where_columns_and_values) ? '' : $where_clause).(!is_null($order) ? ' ORDER BY '.implode(', ', $order) : '').(!is_null($limit) ? ' LIMIT '.$limit : '').(!is_null($offset) ? ' OFFSET '.$offset : '').';';
        try {
            $stmt = $this->db->prepare($sql);
            (is_null($where_columns_and_values) ? $stmt->execute() : $stmt->execute($exe));
            $data = ($type === 'one' ? $stmt->fetch(PDO::FETCH_ASSOC) : ($type === 'all' ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false));
            return $data;
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* generate sql and update data in database */
    protected function dbUpdate(string $table, array $columns_and_values, array $where_columns_and_values = null) { /* zorgt voor een update in de database*/
        foreach ($columns_and_values as $column => $value) {/* in elke column is een value*/
            $updates[] = $column.' = :'.str_replace(' ', '_', $column); /* er wordt een array updates gemaakt waarin de spate door een _ wordt vervangen*/
            $exe[':'.str_replace(' ', '_', $column)] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value); /* voert een een if statement uit*/
        }
        if ($where_columns_and_values !== null) { /* als de */
            $where_clause = ' WHERE '; /* zorgt ervoor dat alleen records met een speciale conditie worden opgehaald*/
            foreach ($where_columns_and_values as $column => $value) { /* filtert de columns*/
                $columns_and_params[] = $column.' = :'.str_replace(' ', '_', $column); 
                $exe[':'.$column] = $value;
            }
            $where_clause .= implode(' AND ', $columns_and_params);
        }
        $sql = 'UPDATE '.$table.' SET '.(implode(', ', $updates)).(!is_null($where_columns_and_values) ? $where_clause : '').';'; 
        try {
            $stmt = $this->db->prepare($sql); /* bereid the database voor*/
            (is_null($where_columns_and_values) ? $stmt->execute() : $stmt->execute($exe));
            return true;
        } catch (PDOException $ex) { 
            return $ex->errorInfo; /* voert error code uit */
        }
    }
    
    /* generate sql and delete data from database */
    protected function dbDelete(string $table, array $where_columns_and_values = null, int $limit = null) { /* creeert een functie waaruit de database wordt gehaald*/
        if (!is_null($where_columns_and_values)) {/* column met een lege waarde*/
            $where_clause = ' WHERE '; /* zorgt ervoor dat alleen records met een speciale conditie worden opgehaald*/
            foreach ($where_columns_and_values as $column => $value) { /* voor elke column wordt de value gefilterd*/
                $columns_and_params[] = $column.' = :'.str_replace(' ', '_', $column); /* de column en params variabel wordt in een andere variabel gezet*/
                $exe[':'.str_replace(' ', '_', $column)] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value); /* er wordt een korte if statement uitgevoerd*/
            }
            $where_clause .= implode(' AND ', $columns_and_params); /* zet and tussen alle waardes*/
        }
        $sql = 'DELETE FROM '.$table.($where_columns_and_values !== null ? $where_clause : '').($limit !== null ? ' LIMIT '.$limit : '').';';
        try {
            $stmt = $this->db->prepare($sql); /*bereid de database voor */ 
            (is_null($where_columns_and_values) ? $stmt->execute() : $stmt->execute($exe)); 
            return true;
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* execute a sql query that hasn't have a method in this class */
    protected function dbCustom(string $sql, array $params_and_values = null, string $return = null) {
        try {
            $stmt = $this->db->prepare($sql);
            if (!is_null($params_and_values)) {
                foreach ($params_and_values as $k => $v) {
                    $exe[':'.$k] = $v;
                }
            } 
            (is_null($params_and_values) ? $stmt->execute() : $stmt->execute($exe));
            return (is_null($return) ? true : ($return === 'one' ? $stmt->fetch(PDO::FETCH_ASSOC) : ($return === 'all' ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false)));
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* perform a left join */
    protected function dbLeftJoin(string $type, string $base_table, array $select_columns_and_aliases, array $tables_and_common_columns, array $where_columns_and_values = null, int $limit = null, int $offset = null, array $order = null) {
        foreach ($select_columns_and_aliases as $ca) {
            $sca[] = $ca['column'].(!empty($ca['alias']) ? ' AS '.$ca['alias'] : '');
        }
        $sql = 'SELECT '.implode(', ', $sca).' FROM '.$base_table;
        foreach ($tables_and_common_columns as $tcc) {
            $sql = $sql.' LEFT JOIN '.$tcc['table'].' ON '.$tcc['left'].' = '.$tcc['right'];
        }
        if (!is_null($where_columns_and_values)) {
            $a = 1;
            $where_clause = ' WHERE ';
            foreach ($where_columns_and_values as $column => $value) {
                $columns_and_params[] = $column.' = '.':v_'.$a;
                $exe[':v_'.$a] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value);
                $a++;
            }
            $where_clause .= implode(' AND ', $columns_and_params);
        }
        $sql = $sql.(!is_null($where_columns_and_values) ? $where_clause : '').(!is_null($order) ? ' ORDER BY '.implode(', ', $order) : '').(!is_null($limit) ? ' LIMIT '.$limit : '').(!is_null($offset) ? ' OFFSET '.$offset : '').';';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($exe);
            return ($type === 'one' ? $stmt->fetch(PDO::FETCH_ASSOC) : ($type === 'all' ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false));
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* perform an inner join */
    protected function dbInnerJoin(string $type, string $base_table, array $select_columns_and_aliases, array $tables_and_common_columns, array $where_columns_and_values = null, int $limit = null, int $offset = null, array $order = null) {
        foreach ($select_columns_and_aliases as $ca) {
            $sca[] = $ca['column'].(!empty($ca['alias']) ? ' AS '.$ca['alias'] : '');
        }
        $sql = 'SELECT '.implode(', ', $sca).' FROM '.$base_table;
        foreach ($tables_and_common_columns as $tcc) {
            $sql = $sql.' INNER JOIN '.$tcc['table'].' ON '.$tcc['left'].' = '.$tcc['right'];
        }
        if (!is_null($where_columns_and_values)) {
            $a = 1;
            $where_clause = ' WHERE ';
            foreach ($where_columns_and_values as $column => $value) {
                $columns_and_params[] = $column.' = '.':v_'.$a;
                $exe[':v_'.$a] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value);
                $a++;
            }
            $where_clause .= implode(' AND ', $columns_and_params);
        }
        $sql = $sql.(!is_null($where_columns_and_values) ? $where_clause : '').(!is_null($order) ? ' ORDER BY '.implode(', ', $order) : '').(!is_null($limit) ? ' LIMIT '.$limit : '').(!is_null($offset) ? ' OFFSET '.$offset : '').';';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($exe);
            return ($type === 'one' ? $stmt->fetch(PDO::FETCH_ASSOC) : ($type === 'all' ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false));
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* get all unique first characters of a specified column */
    protected function dbUniqueFirstCharactersOfColumn(string $table, string $column) {
        $sql = 'SELECT DISTINCT LEFT(UPPER(:column), 1) AS letter FROM :table ORDER BY letter ASC;';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':column' => $column, ':table' => $table]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
    
    /* count the rows form a specified request (BASIC) */
    protected function dbCount(string $table, string $column = '*', array $where_columns_and_values = null) {
        $sql = 'SELECT COUNT(:column) AS count FROM :table';
        $exe[':column'] = $column;
        $exe[':table'] = $table;
        if ($where_columns_and_values !== null) {
            $where_clause = ' WHERE ';
            foreach ($where_columns_and_values as $column => $value) {
                $columns_and_params[] = $column.' = :'.str_replace(' ', '_', $column);
                $exe[':'.str_replace(' ', '_', $column)] = (gettype($value) === 'boolean' ? ($value === true ? '1' : '0') : $value);
            }
            $where_clause = $where_clause.implode(' AND ', $columns_and_params);
        }
        $sql .= ';';
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($exe);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['count'];
        } catch (PDOException $ex) {
            return $ex->errorInfo;
        }
    }
}