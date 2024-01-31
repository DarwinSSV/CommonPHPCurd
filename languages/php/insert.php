<?php

public static function add_update( $id, $tablename, $insert_data, $update_data ) {

    try {

        if( !empty( $id ) ) {

            // Checking data with ID present
            $row = SupportFunctions::data_exists( $tablename, $column, $value );
            
            if( !empty( $row ) ) {

                $setClause = SupportFunctions::setupdateclause( $update_data );                    

                $sql = "Update `" . $tablename . "` SET " . $setClause . "WHERE id = :id";
                $query = $this->conn->prepare( $sql );

                foreach ( $data as $column => $value ) {
                    
                    $query->bindParam( ":$column", $value );
                }                    

                $query->bindParam( ":id", $id, PDO::PARAM_INT );

                $updated = $query->execute();

                if( $updated ) {

                    self::common_response( 0, 'Data Updated Successfully', [] );
                } else {

                    self::common_response( 0, 'Error Updating Data', [] );
                }
            } else {

                self::common_response( 0, 'Invalid Data ID', [] );
            }
        } else {

            $columns = implode( ', ', array_keys( $data ) );
            $values = implode( ', ', array_fill( 0, count( $data ), '?' ) );

            $sql = "INSERT INTO `" . $tablename . "`" . $columns . " VALUES (" . $values . ")";
            $query = $this->conn->prepare( $sql );

            foreach ( $insert_data as $column => &$value ) {

                $query->bindParam( ":$column", $value );
            }

            $inserted = $query->execute();

            if( $inserted ) {

                self::common_response( 0, 'Data Added Successfully', [] );
            } else {

                self::common_response( 0, 'Error Adding Data', [] );
            }
        }
    } catch( Exception $e ) {

        $response = self::common_response( 0, 'Exception: ' . $e->getMessage(), [] );
    }

    return $response;
}
?>