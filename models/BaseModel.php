<?php

class BaseModel {
    const DEFAULT_PAGE_SIZE = 10;

    protected $table;
    protected $where;
    protected $columns;
    protected $limit;
    protected $db;

    public function __construct($args = array()) {
        $args = array_merge(array(
            'where' => '',
            'columns' => '*',
            'limit' => 0
        ), $args);

        if (!isset($args['table'])) {
            die('Table not defined');
        }

        $this->table = $args['table'];
        $this->where = $args['where'];
        $this->columns = $args['columns'];
        $this->limit = $args['limit'];

        include_once "lib/Database.php";

        $db = Database::getInstance();
        $this->db = $db::getDb();
    }

    public function get($id) {
        $results = $this->find(array('where' => 'id = ' . $id));

        return $results;
    }

    public function find( $args = array() ) {
        $args = array_merge( array(
            'table' => $this->table,
            'where' => '',
            'columns' => '*',
            'limit' => 0
        ), $args );

        $table = $args['table'];
        $where = $args['where'];
        $columns = $args['columns'];
        $limit = $args['limit'];


        $query = "select {$columns} from {$table}";

        if( ! empty( $where ) ) {
            $query .= ' where ' . $where;
        }

        if( ! empty( $limit ) ) {
            $query .= ' limit ' . $limit;
        }

        $result_set = $this->db->query( $query );

        $results = $this->processResults( $result_set );

        return $results;
    }


    protected function processResults( $result_set ) {
        $results = array();
        if( ! empty( $result_set ) && $result_set->num_rows > 0) {
            while($row = $result_set->fetch_assoc()) {
                $results[] = $row;
            }
        }

        return $results;
    }

} 