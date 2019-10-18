<?php

namespace startup\model;

use DB;
use ModelQueryInterface;

abstract class Model implements ModelQueryInterface {
    protected $oDB;
    protected $tTableName;
    protected $tPrimaryKey = 'id';

    public function __construct(DB $oDB) {
        $this->oDB = $oDB;
    }
    /**
     * Find a matching row by PK
     *
     * @param string $tPk
     * @param array $aSelectFields which fields to retrieve e.g. ['id', 'username']
     * @return mixed False if not found, array with values if match
     */
    function findByPk(string $tPk, array $aSelectFields = []) {
        $aSelectFields = !empty($aSelectFields) ? implode(', ', $aSelectFields) : '*';

        $stmt = $this->oDB->prepare("SELECT $aSelectFields FROM {$this->tTableName} WHERE {$this->tPrimaryKey} = ?");
        $stmt->execute([$tPk]);
        return $stmt->fetch();
    }

    /**
     * Find a matching row by field - operator - value
     *
     * @param array $aWhere array of arrays with search params e.g.
     *      [
     *          ['username', '=', 'myUserName'],
     *          ['remember_me', '=', 'asdKASDmkl213s'],
     *      ]
     * @param array $aSelectFields which fields to retrieve e.g. ['id', 'username']
     * @return array of all results
     */
    function findWhere(array $aWhere, array $aSelectFields = []): array {
        $tFields = !empty($aSelectFields) ? implode(', ', $aSelectFields) : '*';

        $tPreparedFields = $this->prepareWhereFields($aWhere);
        $aPreparedValues = [];

        foreach ($aWhere as $aWhereParam) {
            [$tFieldName,,$tPreparedValue] = $aWhereParam;
            $aPreparedValues[":$tFieldName"] = $tPreparedValue;
        }

        $stmt = $this->oDB->prepare("SELECT $tFields FROM {$this->tTableName} WHERE {$tPreparedFields}");
        $stmt->execute($aPreparedValues);
        return $stmt->fetchAll();
    }

    function update(array $aUpdateFields, array $aWhere) {
        $tPreparedFields = $this->prepareWhereFields($aWhere);
        $aUpdateParams = $this->prepareUpdateFields($aUpdateFields);
        $aPreparedParams = $this->prepareFields($aUpdateFields);

        foreach ($aWhere as $aWhereParam) {
            [$tFieldName,,$tPreparedValue] = $aWhereParam;
            $aPreparedParams[":$tFieldName"] = $tPreparedValue;
        }

        $stmt = $this->oDB->prepare("UPDATE {$this->tTableName} SET $aUpdateParams WHERE $tPreparedFields");
        return $stmt->execute($aPreparedParams);
    }

    /**
     * Insert a new row into the table
     *
     * @param array $aQueryFields fields and values to insert e.g. ['username' => 'myUser', 'password' => 123]
     * @return bool if successfully inserted
     * @throws \Exception if field is not present in table
     */
    function insert(array $aQueryFields): bool {
        if (empty($aQueryFields)) {
            throw new \Exception('Missing fields in insert query');
        }

        $tFields = implode(', ', array_keys($aQueryFields));
        $aPreparedParameters = $this->prepareFields($aQueryFields);
        $aPreparedFields = implode(', ', array_keys($aPreparedParameters));

        $stmt = $this->oDB->prepare("INSERT INTO {$this->tTableName} ($tFields) VALUES ($aPreparedFields)");
        return $stmt->execute($aPreparedParameters);
    }

    /**
     * Insert a new row into the table
     *
     * @param array $aWhere
     * @return bool if successfully inserted
     * @throws \Exception if field is not present in table
     */
    function delete(array $aWhere): bool {
        if (empty($aWhere)) {
            throw new \Exception('Missing where statement in delete query');
        }

        $tPreparedFields = $this->prepareWhereFields($aWhere);
        $aPreparedParams = [];

        foreach ($aWhere as $aWhereParam) {
            [$tFieldName,,$tPreparedValue] = $aWhereParam;
            $aPreparedParams[":$tFieldName"] = $tPreparedValue;
        }

        $stmt = $this->oDB->prepare("DELETE FROM {$this->tTableName} WHERE ($tPreparedFields)");
        return $stmt->execute($aPreparedParams);
    }

    protected function all(array $aSelectFields = [], int $iLimit = 1000) {
        $aSelectFields = !empty($aSelectFields) ? implode(', ', $aSelectFields) : '*';

        $stmt = $this->oDB->prepare("SELECT $aSelectFields FROM {$this->tTableName} LIMIT $iLimit");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Return array with prepared keys
     *
     * @param array $aFields
     * @return array
     */
    private function prepareFields(array $aFields): array {
        return array_reduce(array_keys($aFields), function ($aArr, $tFieldKey) use ($aFields) {
            $aArr[":$tFieldKey"] = $aFields[$tFieldKey];
            return $aArr;
        }, []);
    }

    /**
     * Return array with prepared keys
     *
     * @param array $aFields
     * @return array
     */
    private function prepareUpdateFields(array $aFields): string {
        return array_reduce(array_keys($aFields), function ($tStr, $tFieldKey) use ($aFields) {
            if (!empty($tStr)) {
                $tStr .= ', ';
            }

            $tStr .= $tFieldKey . " = :$tFieldKey";
            return $tStr;
        }, '');
    }

    /**
     * Return prepared 'where' query
     *
     * @param array $aWhere
     * @return string
     */
    private function prepareWhereFields(array $aWhere): string {
        $tRet = '';

        foreach ($aWhere as $index => $aQuery) {
            [$tField, $tOperator] = $aQuery;

            $tRet .= "$tField $tOperator :$tField";

            if ($index < count($aWhere) - 1) {
                $tRet .= ' AND ';
            }
        }

        return $tRet;
    }
}
