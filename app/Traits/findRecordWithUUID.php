<?php

namespace App\Traits;


trait findRecordWithUUID
{
    protected $tableName;
    protected $theUUID;

    /**
     * find the record of the table using UUID
     * 
     * @param string $tableName
     * @param string $theUUID
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @return \App\Models\tableName|Null
     */
    public static function findUsingUUID(string $tableName, string $theUUID)
    {
        return static::findWithUUID($tableName, $theUUID);
    }

    /**
     * Generate Unique ID in related to given table and column name
     * 
     * @param string $tableName
     * @param string $theUUID
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * 
     * @return \App\Models\tableName|Null
     */
    protected static function findWithUUID(string $tableName, string $theUUID)
    {
        return \Illuminate\Support\Facades\DB::table($tableName)->where('uuid', $theUUID)->first();
    }
}
