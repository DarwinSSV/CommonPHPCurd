<?php
namespace DarwinS\CommonPHPCurd;

class CommonPHPCurd {
    public static function commonCurd($conn, $action, $table, $data = array(), $condition = "") {
        try {
            switch ($action) {
                case 'insert':
                    return self::insert_data($conn, $table, $data);
                case 'update':
                    return self::update_data($conn, $table, $data, $condition);
                case 'delete':
                    return self::delete_data($conn, $table, $condition);
                case 'select':
                    // Implement a select function if needed
                    break;
                case 'select':
                    return self::select_data($conn, $table, $data, $condition);
                default:
                    return 0; // Invalid action specified
            }
        } catch (Exception $e) {
            // Handle exceptions here (e.g., log the error, display a user-friendly message)
            return 0;
        }
    }

    private static function insert_data($conn, $table, $data) {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), '?'));

            // Using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            // Bind parameters
            $types = str_repeat('s', count($data)); // Assuming all data is strings
            $stmt->bind_param($types, ...array_values($data));

            if ($stmt->execute()) {
                // Return the last inserted row id
                return $stmt->insert_id;
            } else {
                throw new Exception("Error during insertion: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // Close the statement
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    private static function update_data($conn, $table, $data, $condition) {
        try {
            $set_clause = implode(", ", array_map(function ($key) {
                return "$key = ?";
            }, array_keys($data)));

            // Using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("UPDATE $table SET $set_clause WHERE $condition");

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            // Bind parameters
            $types = str_repeat('s', count($data)); // Assuming all data is strings
            $stmt->bind_param($types, ...array_values($data));

            if ($stmt->execute()) {
                return 1; // Update successful
            } else {
                throw new Exception("Error during update: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // Close the statement
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    private static function delete_data($conn, $table, $condition) {
        try {
            // Using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("DELETE FROM $table WHERE $condition");

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            if ($stmt->execute()) {
                return 1; // Delete successful
            } else {
                throw new Exception("Error during delete: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // Close the statement
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    private static function select_data($conn, $table, $columns, $condition) {
        try {
            $selectedColumns = implode(", ", $columns);
            // Using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT $selectedColumns FROM $table WHERE $condition");

            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            if ($stmt->execute()) {
                // Fetch the result
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return $row;
            } else {
                throw new Exception("Error during select: " . $stmt->error);
            }
        } catch (Exception $e) {
            throw $e;
        } finally {
            // Close the statement
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }
}
