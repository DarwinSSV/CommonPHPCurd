<?php
namespace SupportFunctions;

class SupportFunctions {

    public function data_exists( $tablename, $column, $value ) {

        $sql = "SELECT $column FROM `" . $tablename ."` WHERE $column = :value";
        $query = $this->conn->prepare( $sql );
        $query->bindParam( ":value", $value );
        $query->execute();
        
        $row = $query->fetch( PDO::ASSOC );

        return $row;
    }

    public static function setupdateclause( $array ) {

        $setClause = implode( ', ', array_map( function ( $column, $value ) {
                        
            return "`$column` = :$column";
        }, array_keys( $array ), $array ) );

        return $setClause;
    }
}