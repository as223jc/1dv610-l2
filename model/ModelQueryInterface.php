<?php

namespace startup\model;

interface ModelQueryInterface {
    /**
     * Find a matching row by PK
     *
     * @param string $tPk
     * @param array $aSelectFields which fields to retrieve e.g. ['id', 'username']
     * @return mixed False if not found, array with values if match
     */
    function findByPk(string $tPk, array $aSelectFields = []);

    /**
     * Find a matching row by field - operator - value
     *
     * @param array $aWhere e.g. ['username', '=', 'myUserName']
     * @param array $aSelectFields which fields to retrieve e.g. ['id', 'username']
     * @return array of all results
     */
    function findWhere(array $aWhere, array $aSelectFields = []): array;

    /**
     * Insert a new row into the table
     *
     * @param array $aQueryFields fields and values to insert e.g. ['username' => 'myUser', 'password' => 123]
     * @return bool if successfully inserted
     * @throws \Exception if field is not present in table
     */
    function insert(array $aQueryFields): bool;
}
