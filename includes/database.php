<?php
function query($sql = '', $data = [], $statementStatus = false)
{
    global $conn;
    try {
        $statement = $conn->prepare($sql);
        $query = $statement->execute($data);
        if ($statementStatus && $query) {
            return $statement;
        }
    } catch (Exception $e) {
        echo 'Error query: ' . $e->getMessage();
        return false;
    }
    return $query;
}
function insertData($table = '', $dataInsert = [])
{
    $fields = array_keys($dataInsert);
    $fieldStr = implode(', ', $fields);
    $placeholders = array_map(function ($field) {
        return ':' . $field;
    }, $fields);

    $placeholderStr = implode(', ', $placeholders);
    $sql = 'INSERT INTO ' . $table . '(' . $fieldStr . ') VALUES(' . $placeholderStr . ')';

    $result = query($sql, $dataInsert);
    return $result !== false;
}
function deleteData($table = '', $condition = '')
{
    $sql = null;
    if (!empty($condition)) {
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $condition;
    }
    return query($sql);
}

function updateData($table = '', $dataUpdate = [], $condition = '')
{
    $updateFields = array_map(function ($key) {
        return $key . '=:' . $key;
    }, array_keys($dataUpdate));

    $updateStr = implode(', ', $updateFields);
    $sql = 'UPDATE ' . $table . ' SET ' . $updateStr;

    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }

    return query($sql, $dataUpdate);
}


function getAllDataBySql($sql)
{
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    return false;
}

function getDataBySql($sql)
{
    $statement = query($sql, [], true);
    if (is_object($statement)) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    return false;
}

function getAllData($table, $fields = '*', $condition = '')
{
    $sql = 'SELECT ' . $fields . ' FROM ' . $table;

    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }

    return getAllDataBySql($sql);
}

function getData($table, $fields = '*', $condition = '')
{
    $sql = 'SELECT ' . $fields . ' FROM ' . $table;

    if (!empty($condition)) {
        $sql .= ' WHERE ' . $condition;
    }

    return getDataBySql($sql);
}

function getExists($sql)
{
    $statement = query($sql, [], statementStatus: true);
    if (!empty($statement)) {
        return $statement->rowCount();
    }
}
